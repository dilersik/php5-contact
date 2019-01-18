<?php

class Admin_Area_UnDAO {
    
    public static function insert(Admin_Area_UnVO $vo) {
        $pstmt = DAO::newPDO()->prepare("INSERT INTO admin_area_un SET 
                                        status = " . SystemVO::STATUS_ATIVO . ", 
                                        admin_id = :admin_id, 
                                        admin_area_id = :area_id");
        $pstmt->bindValue(':admin_id', $vo->getAdminVO()->getId(), PDO::PARAM_INT);
        $pstmt->bindValue(':area_id', $vo->getAdmin_AreaVO()->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));        
    }
    
    public static function updateDisable(Admin_Area_UnVO $vo) {
        $pstmt = DAO::newPDO()->prepare("UPDATE admin_area_un SET status = status * -1
                                         WHERE admin_id = :admin_id AND status > 0");
        $pstmt->bindValue(':admin_id', $vo->getAdminVO()->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));        
    }
    
    public static function updateEnable(Admin_Area_UnVO $adminCatUn) {
        $pstmt = DAO::newPDO()->prepare("UPDATE admin_area_un SET status = status * -1
                                         WHERE
                                         status < 0 AND
                                         admin_id = :admin_id AND
                                         admin_area_id = :admin_area_id");
        $pstmt->bindValue(':admin_id', $adminCatUn->getAdminVO()->getId(), PDO::PARAM_INT);
        $pstmt->bindValue(':admin_area_id', $adminCatUn->getAdmin_AreaVO()->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));
    }
    
    public static function select(Admin_Area_UnVO $vo) {
        $pstmt = DAO::newPDO()->prepare("SELECT admin_area_id FROM admin_area_un
                                         WHERE status = " . SystemVO::STATUS_ATIVO . " AND admin_id = :admin_id
                                         ORDER BY admin_area_id ASC");
        $pstmt->bindValue(':admin_id', $vo->getAdminVO()->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));
        
        $return = array();
        while ($row = $pstmt->fetchObject()) {
            $vo = new Admin_Area_UnVO();
            $vo->setAdmin_AreaVO(new Admin_AreaVO());
            $vo->getAdmin_AreaVO()->setId($row->admin_area_id);
            
            $return[] = $vo;
        }
        
        return $return;
    }
    
    public static function selectCount(Admin_Area_UnVO $adminCatUn, $status = SystemVO::STATUS_ATIVO) {
        $pstmt = DAO::newPDO()->prepare("SELECT COUNT(id) FROM admin_area_un
                                         WHERE
                                         admin_id = :admin_id
                                         " . ($status ? " AND status = :status" : "" ) . "
                                         AND admin_area_id = :admin_area_id");
        if ($status) {
            $pstmt->bindValue(':status', $status, PDO::PARAM_INT);
        }
        $pstmt->bindValue(':admin_id', $adminCatUn->getAdminVO()->getId(), PDO::PARAM_INT);
        $pstmt->bindValue(':admin_area_id', $adminCatUn->getAdmin_AreaVO()->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));
        
        return $pstmt->fetchColumn();
    }
    
}

?>
