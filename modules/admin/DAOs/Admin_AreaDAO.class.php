<?php

class Admin_AreaDAO {
    
    public static function select() {
        $query = DAO::newPDO()->query("SELECT id, name FROM admin_areas
                                      WHERE status = " . SystemVO::STATUS_ATIVO . "
                                      ORDER BY name ASC") or die('query error');
        return $query->fetchAll(PDO::FETCH_CLASS, 'Admin_AreaVO');
    }
    
    public static function selectCountByID(Admin_AreaVO $vo) {
        $pstmt = DAO::newPDO()->prepare("SELECT COUNT(id) FROM admin_areas
                                        WHERE status = " . SystemVO::STATUS_ATIVO . " AND id = :id");
        $pstmt->bindValue(':id', $vo->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));
        
        return $pstmt->fetchColumn();
    }
    
}

?>
