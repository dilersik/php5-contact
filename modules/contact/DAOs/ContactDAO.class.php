<?php

class ContactDAO {
    
    public static function insert(ContactVO $vo) {
        $pstmt = DAO::newPDO()->prepare("INSERT INTO contacts SET
                                        status = :status,
                                        date_post = '" . SystemC::dateTimeISO() . "',
                                        date_update = NULL,
                                        name = :name,
                                        email = LOWER(:email),
                                        ddd_tel = :ddd_tel,
                                        tel = :tel,
                                        subject = :subject,
                                        msg = :msg,
                                        filename = :filename,
                                        seen = :seen,
                                        responded = :responded");
        $pstmt->bindValue(':status', $vo->getStatus(), PDO::PARAM_INT);
        $pstmt->bindValue(':name', $vo->getName());
        $pstmt->bindValue(':email', $vo->getEmail());
        $pstmt->bindValue(':ddd_tel', $vo->getDdd_tel());
        $pstmt->bindValue(':tel', $vo->getTel());
        $pstmt->bindValue(':subject', $vo->getSubject());
        $pstmt->bindValue(':msg', $vo->getMsg());
        $pstmt->bindValue(':filename', $vo->getFilename());
        $pstmt->bindValue(':seen', $vo->getSeen(), PDO::PARAM_INT);
        $pstmt->bindValue(':responded', $vo->getResponded(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));        
    }

    public static function update(ContactVO $vo) {
        $pstmt = DAO::newPDO()->prepare("UPDATE contacts SET
                                        date_update = '" . SystemC::dateTimeISO() . "',
                                        update_admin_id = :update_admin_id,
                                        name = :name,
                                        email = LOWER(:email),
                                        ddd_tel = :ddd_tel,
                                        tel = :tel,
                                        subject = :subject,
                                        msg = :msg,
                                        seen = :seen,
                                        responded = :responded
                                        WHERE
                                        id = :id AND
                                        status > 0");
        $pstmt->bindValue(':update_admin_id', $vo->getUpdateAdminVO()->getId(), PDO::PARAM_INT);
        $pstmt->bindValue(':name', $vo->getName());
        $pstmt->bindValue(':email', $vo->getEmail());
        $pstmt->bindValue(':ddd_tel', $vo->getDdd_tel());
        $pstmt->bindValue(':tel', $vo->getTel());
        $pstmt->bindValue(':subject', $vo->getSubject());
        $pstmt->bindValue(':msg', $vo->getMsg());
        $pstmt->bindValue(':seen', $vo->getSeen(), PDO::PARAM_INT);
        $pstmt->bindValue(':responded', $vo->getResponded(), PDO::PARAM_INT);
        $pstmt->bindValue(':id', $vo->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));        
    }

    public static function updateDisable(ContactVO $vo) {
        $pstmt = DAO::newPDO()->prepare("UPDATE contacts SET status = status * -1, update_admin_id = :update_admin_id 
                                        WHERE id = :id AND status > 0");
        $pstmt->bindValue(':update_admin_id', $vo->getUpdateAdminVO()->getId(), PDO::PARAM_INT);
        $pstmt->bindValue(':id', $vo->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));        
    }

    public static function select(ContactVO $vo, array $params = array()) {
        $sql = "SELECT SQL_CALC_FOUND_ROWS id, status, date_post, date_update, name, email, ddd_tel, tel, subject, seen, responded ";
        $sql .= " FROM contacts WHERE status > 0 ";
        $sql .= $vo->getStatus() ? " AND status = :status " : "";
        $sql .= $vo->getName() ? " AND name LIKE :name " : "";
        $sql .= $vo->getSubject() ? " AND subject LIKE :subject " : "";
        if ($vo->getSeen() === 1) {            
            $sql .= " AND seen = 1 ";
        } else if ($vo->getSeen() === 0) {
            $sql .= " AND (seen = 0 OR seen IS NULL) ";
        }
        if ($vo->getResponded() === 1) {
            $sql .= " AND responded = 1 ";
        } else if ($vo->getResponded() === 0) {
            $sql .= " AND (responded = 0 OR responded IS NULL) ";
        }
        $sql .= @$params['contactInfo'] ? " AND (CONCAT(ddd_tel, ' ', tel) LIKE :contactInfo "
                                              . " OR email LIKE :contactInfo) " : "";
        $sql .= " ORDER BY ";
        switch (@$params['order_by']) {
            case 1: $sql .= ' subject ASC '; break;
            case 2: $sql .= ' subject DESC '; break;
            case 3: $sql .= ' id ASC '; break;
            case 5: $sql .= ' status ASC '; break;
            case 6: $sql .= ' status DESC '; break;
            default: $sql .= ' id DESC '; break;
        }
        $pstmt = DAO::newPDO()->prepare($sql . (@$params['qtd'] ? " LIMIT :ini, :qtd" : ""));
        if ($vo->getStatus()) {
            $pstmt->bindValue(":status", $vo->getStatus(), PDO::PARAM_INT);
        }
        if ($vo->getName()) {
            $pstmt->bindValue(":name", "%" . $vo->getName() . "%");
        }
        if ($vo->getSubject()) {
            $pstmt->bindValue(":subject", "%" . $vo->getSubject() . "%");
        }
        if (@$params['contactInfo']) {
            $pstmt->bindValue(":contactInfo", "%" . $params['contactInfo'] . "%");
        }
        if ($params['qtd']) {
            $pstmt->bindValue(':ini', $params['ini'], PDO::PARAM_INT);
            $pstmt->bindValue(':qtd', $params['qtd'], PDO::PARAM_INT);
        }
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));

        if (@$params['pager']) {
            ContactC::setRows(DAO::newPDO()->query("SELECT FOUND_ROWS()")->fetchColumn());
        }
        
        return $pstmt->fetchAll(PDO::FETCH_CLASS, 'ContactVO');
        return new ContactVO();
    }
    
    public static function selectByID(ContactVO $vo) {
        $pstmt = DAO::newPDO()->prepare("SELECT id, status, date_post, date_update, post_admin_id, update_admin_id, name, email, ddd_tel, tel, subject, msg, filename, seen, responded "
                                        . " FROM contacts WHERE id = :id AND status > 0 " 
                                        . ($vo->getStatus() ? " AND status = :status " : ""));
        $pstmt->bindValue(':id', $vo->getId(), PDO::PARAM_INT);
        if ($vo->getStatus()) {
            $pstmt->bindValue(':status', $vo->getStatus(), PDO::PARAM_INT);
        }
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));
        
        $row = $pstmt->fetchObject('ContactVO');
        if (!$row) {
            return null;
        }
        $row->setPostAdminVO(new AdminVO());
        $row->getPostAdminVO()->setId($row->post_admin_id);
        $row->setUpdateAdminVO(new AdminVO());
        $row->getUpdateAdminVO()->setId($row->update_admin_id);
        
        return $row;
        return new ContactVO();
    }
    
    public static function selectCount(ContactVO $vo) {
        $pstmt = DAO::newPDO()->prepare("SELECT COUNT(id) FROM contacts
                                        WHERE
                                        id != :id AND
                                        status > 0 AND
                                        name = :name");
        $pstmt->bindValue(':id', (int) $vo->getId(), PDO::PARAM_INT);
        $pstmt->bindValue(':name', $vo->getName());
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));
        
        return $pstmt->fetchColumn();
    }
    
    public static function selectCountByID(ContactVO $vo) {
        $pstmt = DAO::newPDO()->prepare("SELECT COUNT(id) FROM contacts WHERE id = :id AND status > 0 " .
                                        ($vo->getStatus() ? " AND status = :status " : ''));
        $pstmt->bindValue(':id', $vo->getId(), PDO::PARAM_INT);
        if ($vo->getStatus()) {
            $pstmt->bindValue(':status', $vo->getStatus(), PDO::PARAM_INT);
        }
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));
                
        return $pstmt->fetchColumn();
    }
    
}
