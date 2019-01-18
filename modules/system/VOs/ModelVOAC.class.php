<?php

abstract class ModelVOAC {

    protected $id;
    protected $status;
    protected $date_post;
    protected $date_update;
    protected $postAdminVO;
    protected $updateAdminVO;
    
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getStatus() {
        return $this->status;
    }
    public function setStatus($status) {
        $this->status = $status;
    }

    public function getDate_post() {
        return $this->date_post;
    }
    public function setDate_post($date_post) {
        $this->date_post = $date_post;
    }

    public function getDate_update() {
        return $this->date_update;
    }
    public function setDate_update($date_update) {
        $this->date_update = $date_update;
    }
    
    public function getPostAdminVO() {
        return $this->postAdminVO;
        return new AdminVO();
    }
    public function setPostAdminVO(AdminVO $AdminVO) {
        $this->postAdminVO = $AdminVO;
    }
    
    public function getUpdateAdminVO() {
        return $this->updateAdminVO;
        return new AdminVO();
    }
    public function setUpdateAdminVO(AdminVO $AdminVO) {
        $this->updateAdminVO = $AdminVO;
    }
    
}
