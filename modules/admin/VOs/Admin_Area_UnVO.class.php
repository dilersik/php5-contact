<?php

class Admin_Area_UnVO {
    
    private $AdminVO;
    private $Admin_AreaVO;
    
    public function getAdminVO() {
        return $this->AdminVO;
        return new AdminVO();
    }
    public function setAdminVO(AdminVO $AdminVO) {
        $this->AdminVO = $AdminVO;
    }
    
    public function getAdmin_AreaVO() {
        return $this->Admin_AreaVO;
        return new Admin_AreaVO();
    }
    public function setAdmin_AreaVO(Admin_AreaVO $Admin_AreaVO) {
        $this->Admin_AreaVO = $Admin_AreaVO;
    }
    
}