<?php

class AdminVO extends ModelVOAC {
    
    private $token;
    private $name;
    private $lastname;
    private $email;
    private $username;
    private $pwd;
    private $listAdmin_LoginVO = array();
    private $listAdmin_Area_UnVO = array();
    
    public function getToken() {
        return $this->token;
    }
    public function setToken($token) {
        $this->token = $token;
    }

    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getLastname() {
        return $this->lastname;
    }
    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }

    public function getUsername() {
        return $this->username;
    }
    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPwd() {
        return $this->pwd;
    }
    public function setPwd($pwd) {
        $this->pwd = $pwd;
    }
    
    public function getListAdmin_LoginVO($key = NULL) {
        return array_key_exists($key, $this->listAdmin_LoginVO) ? $this->listAdmin_LoginVO[$key] : $this->listAdmin_LoginVO;
        return new Admin_LoginVO();
    }
    public function setListAdmin_LoginVO(array $listAdmin_LoginVO) {
        $this->listAdmin_LoginVO = (array) $listAdmin_LoginVO;
    }
    
    public function getListAdmin_Area_UnVO($key = NULL) {
        return array_key_exists($key, $this->listAdmin_Area_UnVO) ? $this->listAdmin_Area_UnVO[$key] : $this->listAdmin_Area_UnVO;
        return new Admin_Area_UnVO();
    }
    public function setListAdmin_Area_UnVO(array $listAdmin_Area_UnVO) {
        $this->listAdmin_Area_UnVO = (array) $listAdmin_Area_UnVO;
    }
    
    public function getFullName() {
        return $this->name . ($this->lastname ? ' ' . $this->lastname : '');
    }
    
}