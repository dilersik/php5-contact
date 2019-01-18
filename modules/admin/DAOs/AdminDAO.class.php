<?php

class AdminDAO {

    public static function insert(AdminVO $vo) {
        $pstmt = DAO::newPDO()->prepare("INSERT INTO admins SET
                                         status = :status,
                                         date_post = '" . SystemC::dateTimeISO() . "',
                                         date_update = NULL,
                                         post_admin_id = :post_admin_id,
                                         update_admin_id = NULL,
                                         token = :token,
                                         name = UPPER(:name),
                                         lastname = UPPER(:lastname),
                                         email = LOWER(:email),
                                         username = :username,
                                         pwd = :pwd,
                                         ip = '" . $_SERVER['REMOTE_ADDR'] . "'");
        $pstmt->bindValue(':status', $vo->getStatus(), PDO::PARAM_INT);
        $pstmt->bindValue(':post_admin_id', $vo->getPostAdminVO()->getId(), PDO::PARAM_INT);
        $pstmt->bindValue(':name', $vo->getName());
        $pstmt->bindValue(':lastname', $vo->getLastname());
        $pstmt->bindValue(':token', $vo->getToken());
        $pstmt->bindValue(':email', $vo->getEmail());
        $pstmt->bindValue(':username', $vo->getUsername());
        $pstmt->bindValue(':pwd', $vo->getPwd());
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));

        return DAO::newPDO()->lastInsertId();
    }

    public static function update(AdminVO $vo) {
        $sql = "UPDATE admins SET
                status = :status,
                date_update = '" . SystemC::dateTimeISO() . "',
                update_admin_id = :update_admin_id,
                name = UPPER(:name),
                lastname = UPPER(:lastname),
                email = LOWER(:email) ";
        $token = false;
        if ($vo->getUsername()) {
            $sql .= " , username = :username ";
            $token = true;
        }
        if ($vo->getPwd()) {
            $sql .= " , pwd = :pwd ";
            $token = true;
        }
        if ($token) { $sql .= " , token = :token "; }
        $sql .= " WHERE id = :id AND status > 0 ";
        $pstmt = DAO::newPDO()->prepare($sql);
        $pstmt->bindValue(':status', $vo->getStatus(), PDO::PARAM_INT);
        $pstmt->bindValue(':update_admin_id', $vo->getUpdateAdminVO()->getId(), PDO::PARAM_INT);
        $pstmt->bindValue(':name', $vo->getName());
        $pstmt->bindValue(':lastname', $vo->getLastname());
        $pstmt->bindValue(':email', $vo->getEmail());
        if ($vo->getUsername()) {
            $pstmt->bindValue(':username', $vo->getUsername());
        }
        if ($vo->getPwd()) {
            $pstmt->bindValue(':pwd', $vo->getPwd());
        }
        if ($token) {
            $pstmt->bindValue(':token', $vo->getToken());
        }
        $pstmt->bindValue(':id', $vo->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));
    }

    public static function updateDisable(AdminVO $vo) {
        $pstmt = DAO::newPDO()->prepare("UPDATE admins SET status = status * -1, update_admin_id = :update_admin_id
                                        WHERE id = :id AND status > 0 ");
        $pstmt->bindValue(':update_admin_id', $vo->getUpdateAdminVO()->getId(), PDO::PARAM_INT);        
        $pstmt->bindValue(':id', $vo->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));
    }

    public static function select(AdminVO $vo, array $params = array()) {
        $sql = "SELECT SQL_CALC_FOUND_ROWS DISTINCT(A.id), A.status, A.date_post, A.date_update, A.name, A.lastname, A.username,
                (SELECT MAX(date_post) FROM admin_logins WHERE post_admin_id = A.id) AS login_date_post 
                FROM admins AS A ";
        $sql .= $vo->getListAdmin_Area_UnVO() ? 
                " INNER JOIN admin_area_un AS AAU ON A.id = AAU.post_admin_id AND AAU.admin_area_id = :admin_area_id " : "";
        $sql .= " WHERE A.status > 0 ";
        $sql .= $vo->getName() ? " AND (A.name LIKE :name OR A.lastname LIKE :name OR CONCAT(A.name, ' ', A.lastname) "
                . " OR A.username LIKE :name "
                . " OR A.email LIKE :name) " : "";
        $sql .= " ORDER BY ";
        switch (@$params['order_by']) {
            case 2: $sql .= ' A.name DESC '; break;
            case 3: $sql .= ' A.id ASC '; break;
            case 4: $sql .= ' A.id DESC '; break;
            case 5: $sql .= ' A.status ASC '; break;
            case 6: $sql .= ' A.status DESC '; break;
            default: $sql .= ' A.name ASC '; break;
        }
        $pstmt = DAO::newPDO()->prepare($sql . (@$params['qtd'] ? " LIMIT :ini, :qtd" : ""));
        if ($vo->getListAdmin_Area_UnVO()) {
            $pstmt->bindValue(':admin_area_id', $vo->getListAdmin_Area_UnVO(0)->getAdmin_AreaVO()->getId(), PDO::PARAM_INT);
        }
        if ($vo->getName()) {
            $pstmt->bindValue(':name', "%" . $vo->getName() . "%");
        }
        if ($params['qtd']) {
            $pstmt->bindValue(':ini', $params['ini'], PDO::PARAM_INT);
            $pstmt->bindValue(':qtd', $params['qtd'], PDO::PARAM_INT);
        }
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));

        if (@$params['pager']) {
            AdminC::setRows(DAO::newPDO()->query("SELECT FOUND_ROWS()")->fetchColumn());
        }

        $list = array();
        while ($row = $pstmt->fetchObject("AdminVO")) {
            $aLogin = new Admin_LoginVO();
            $aLogin->setDate_post($row->login_date_post);
            $row->setListAdmin_LoginVO(array($aLogin));
            $list[] = $row;
        }
        return $list;
        return new AdminVO();
    }

    public static function selectUniq(AdminVO $vo) {
        $pstmt = DAO::newPDO()->prepare("SELECT id, token FROM admins WHERE status = " . SystemVO::STATUS_ATIVO . "
                                         AND BINARY username = :username
                                         AND BINARY pwd = :pwd");
        $pstmt->bindValue(':username', $vo->getUsername());
        $pstmt->bindValue(':pwd', $vo->getPwd());
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));

        return $pstmt->fetchObject('AdminVO');
    }

    public static function selectByID(AdminVO $vo, $statusPos = TRUE) {
        $pstmt = DAO::newPDO()->prepare("SELECT id, status, date_post, date_update, post_admin_id, update_admin_id, name, lastname, email, username FROM admins WHERE id = :id
                                        " . ($statusPos ? " AND status > 0 " : ""));
        $pstmt->bindValue(':id', $vo->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));

        $row = $pstmt->fetchObject('AdminVO');
        if (!$row) {
            return null;
        }
        $row->setPostAdminVO(new AdminVO());
        $row->getPostAdminVO()->setId($row->post_admin_id);
        $row->setUpdateAdminVO(new AdminVO());
        $row->getUpdateAdminVO()->setId($row->update_admin_id);
        
        return $row;
        return new AdminVO();
    }

    public static function selectNameByID(AdminVO $vo) {
        $pstmt = DAO::newPDO()->prepare("SELECT A.name,
                                        (SELECT MAX(date_update) FROM admin_logins WHERE post_admin_id = A.id) AS login_date_update
                                        FROM admins AS A
                                        WHERE A.id = :id AND A.status = " . SystemVO::STATUS_ATIVO);
        $pstmt->bindValue(':id', $vo->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));
        $row = $pstmt->fetchObject();
        if ($row) {
            $vo = new AdminVO();
            $vo->setName($row->name);
            $al = new Admin_LoginVO();
            $al->setDate_update($row->login_date_update);
            $vo->setListAdmin_LoginVO(array($al));

            return $vo;
        }
        return null;
    }

    public static function selectPwdByID(AdminVO $vo) {
        $pstmt = DAO::newPDO()->prepare("SELECT pwd FROM admins WHERE id = :id AND status > 0 ");
        $pstmt->bindValue(':id', $vo->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));

        return $pstmt->fetchObject('AdminVO');
        return new AdminVO();
    }

    public static function selectCount(AdminVO $vo) {
        $sql = "SELECT COUNT(id) FROM admins WHERE id != :id AND status > 0 ";
        if ($vo->getEmail()) {
            $sql .= " AND email = :email ";
        } else if ($vo->getUsername()) {
            $sql .= " AND username = :username ";
        }
        $pstmt = DAO::newPDO()->prepare($sql);
        $pstmt->bindValue(':id', (int) $vo->getId(), PDO::PARAM_INT);
        if ($vo->getEmail()) {
            $pstmt->bindValue(':email', $vo->getEmail());
        } else if ($vo->getUsername()) {
            $pstmt->bindValue(':username', $vo->getUsername());
        }
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));

        return $pstmt->fetchColumn();
    }

    public static function selectCountByID(AdminVO $vo) {
        $pstmt = DAO::newPDO()->prepare("SELECT COUNT(id) FROM admins WHERE status > 0 AND id = :id " .
                                        ($vo->getStatus() ? " AND status = :status " : ""));
        $pstmt->bindValue(':id', $vo->getId(), PDO::PARAM_INT);
        if ($vo->getStatus()) {
            $pstmt->bindValue(':status', $vo->getStatus(), PDO::PARAM_INT);
        }
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));

        return $pstmt->fetchColumn();
    }

}
