<?php

class Admin_AreaVO extends ModelVOAC {
    
    private $name;
    
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }
    
}