<?php

class ContactVO extends ModelVOAC {
    
    private $name;
    private $email;
    private $ddd_tel;
    private $tel;
    private $subject;
    private $msg;
    private $filename;
    private $seen;
    private $responded;
    
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getDdd_tel() {
        return $this->ddd_tel;
    }
    public function setDdd_tel($ddd_tel) {
        $this->ddd_tel = $ddd_tel;
    }
    
    public function getTel() {
        return $this->tel;
    }
    public function setTel($tel) {
        $this->tel = $tel;
    }
    
    public function getSubject() {
        return $this->subject;
    }
    public function setSubject($subject) {
        $this->subject = $subject;
    }
    
    public function getMsg() {
        return $this->msg;
    }
    public function setMsg($msg) {
        $this->msg = $msg;
    }
    
    public function getFilename() {
        return $this->filename;
    }
    public function setFilename($filename) {
        $this->filename = $filename;
    }
    
    public function getSeen() {
        return $this->seen;
    }
    public function setSeen($seen) {
        $this->seen = $seen;
    }
    
    public function getResponded() {
        return $this->responded;
    }
    public function setResponded($responded) {
        $this->responded = $responded;
    }
    
    public function getFullTel() {
        return $this->ddd_tel . $this->tel;
    }
    
}
