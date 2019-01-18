<?php

class Admin_LoginDAO {

    public static function insert(Admin_LoginVO $Admin_LoginVO) {
        $date = SystemC::dateTimeISO();
        $pstmt = DAO::newPDO()->prepare("INSERT INTO admin_logins SET
                                         admin_id = :admin_id,
                                         date_post = '" . $date . "',
                                         date_update = '" . $date . "',
                                         token = :token,
                                         ip = '" . $_SERVER['REMOTE_ADDR'] . "'");
        $pstmt->bindValue(':admin_id', $Admin_LoginVO->getPostAdminVO()->getId(), PDO::PARAM_INT);
        $pstmt->bindValue(':token', $Admin_LoginVO->getToken());
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));

        return DAO::newPDO()->lastInsertId();
    }

    public static function update(Admin_LoginVO $vo) {
        $pstmt = DAO::newPDO()->prepare("UPDATE admin_logins SET
                                         date_update = :date_update
                                         WHERE
                                         id = :id AND
                                         admin_id = :admin_id");
        $pstmt->bindValue(':date_update', $vo->getDate_update());
        $pstmt->bindValue(':id', $vo->getId(), PDO::PARAM_INT);
        $pstmt->bindValue(':admin_id', $vo->getPostAdminVO()->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));
    }

    public static function selectUniq(Admin_LoginVO $Admin_LoginVO) {
        $pstmt = DAO::newPDO()->prepare("SELECT C.id, C.name,
                                        CL.id AS CL_id, CL.date_post AS CL_date_post,
                                        CL.date_update AS CL_date_update
                                        FROM admins AS C
                                        INNER JOIN admin_logins AS CL ON C.id = CL.admin_id
                                        AND C.token = CL.token
                                        WHERE C.status = " . SystemVO::STATUS_ATIVO . " AND CL.admin_id = :admin_id
                                        ORDER BY CL.id DESC LIMIT 1");
        $pstmt->bindValue(':admin_id', $Admin_LoginVO->getPostAdminVO()->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));
        $row = $pstmt->fetchObject();
        if ($row) {
            $Admin_LoginVO = new Admin_LoginVO();
            $Admin_LoginVO->setId($row->CL_id);
            $Admin_LoginVO->setDate_post($row->CL_date_post);
            $Admin_LoginVO->setDate_update($row->CL_date_update);
            $Admin_LoginVO->setPostAdminVO(new AdminVO());
            $Admin_LoginVO->getPostAdminVO()->setId($row->id);
            $Admin_LoginVO->getPostAdminVO()->setName($row->name);

            return $Admin_LoginVO;
        }

        return NULL;
    }

}
