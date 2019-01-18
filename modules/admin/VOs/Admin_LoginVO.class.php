<?php

class Admin_LoginVO extends ModelVOAC {
    
    private $token;
    
    public function getToken() {
        return $this->token;
    }
    public function setToken($token) {
        $this->token = $token;
    }
    
}