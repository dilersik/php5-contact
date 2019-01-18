<?php

class DefineVO extends ModelVOAC {
    
    private $page_title;
    private $page_meta_keywords;
    private $page_meta_description;
    private $page_nice_url;
    private $page_analytics_code;
    private $company_cnpj;
    private $company_state_registration;
    private $company_corporate_name;
    private $company_fancy_name;
    private $company_email;
    private $company_tel;
    private $company_tel2;
    private $company_cel;
    private $company_cel2;
    private $company_whatsapp;
    private $company_address;
    private $company_address2;
    private $company_cep_origem;
    private $company_facebook;
    private $company_instagram;
    private $company_linkedin;
    private $company_twitter;
    private $company_youtube;
    private $correio_empresa;
    private $correio_senha;
    
    public function getPage_title() {
        return $this->page_title;
    }
    public function setPage_title($page_title) {
        $this->page_title = $page_title;
    }
    
    public function getPage_meta_keywords() {
        return $this->page_meta_keywords;
    }
    public function setPage_meta_keywords($page_meta_keywords) {
        $this->page_meta_keywords = $page_meta_keywords;
    }
    
    public function getPage_meta_description() {
        return $this->page_meta_description;
    }
    public function setPage_meta_description($page_metadescription) {
        $this->page_meta_description = $page_metadescription;
    }
    
    public function getPage_nice_url() {
        return $this->page_nice_url;
    }
    public function setPage_nice_url($page_nice_url) {
        $this->page_nice_url = $page_nice_url;
    }
    
    public function getPage_analytics_code() {
        return $this->page_analytics_code;
    }
    public function setPage_analytics_code($page_analytics_code) {
        $this->page_analytics_code = $page_analytics_code;
    }
    
    public function getCompany_cnpj() {
        return $this->company_cnpj;
    }
    public function setCompany_cnpj($company_cnpj) {
        $this->company_cnpj = $company_cnpj;
    }
    
    public function getCompany_state_registration() {
        return $this->company_state_registration;
    }
    public function setCompany_state_registration($company_state_registration) {
        $this->company_state_registration = $company_state_registration;
    }
    
    public function getCompany_corporate_name() {
        return $this->company_corporate_name;
    }
    public function setCompany_corporate_name($company_corporate_name) {
        $this->company_corporate_name = $company_corporate_name;
    }
    
    public function getCompany_fancy_name() {
        return $this->company_fancy_name;
    }
    public function setCompany_fancy_name($company_fancy_name) {
        $this->company_fancy_name = $company_fancy_name;
    }
    
    public function getCompany_email() {
        return $this->company_email;
    }
    public function setCompany_email($company_email) {
        $this->company_email = $company_email;
    }
    
    public function getCompany_tel() {
        return $this->company_tel;
    }
    public function setCompany_tel($company_tel) {
        $this->company_tel = $company_tel;
    }
    
    public function getCompany_tel2() {
        return $this->company_tel2;
    }
    public function setCompany_tel2($company_tel2) {
        $this->company_tel2 = $company_tel2;
    }
    
    public function getCompany_cel() {
        return $this->company_cel;
    }
    public function setCompany_cel($company_cel) {
        $this->company_cel = $company_cel;
    }
    
    public function getCompany_cel2() {
        return $this->company_cel2;
    }
    public function setCompany_cel2($company_cel2) {
        $this->company_cel2 = $company_cel2;
    }
    
    public function getCompany_whatsapp() {
        return $this->company_whatsapp;
    }
    public function setCompany_whatsapp($company_whatsapp) {
        $this->company_whatsapp = $company_whatsapp;
    }
    
    public function getCompany_address() {
        return $this->company_address;
    }
    public function setCompany_address($company_address) {
        $this->company_address = $company_address;
    }
    
    public function getCompany_address2() {
        return $this->company_address2;
    }
    public function setCompany_address2($company_address2) {
        $this->company_address2 = $company_address2;
    }
    
    public function getCompany_cep_origem() {
        return $this->company_cep_origem;
    }
    public function setCompany_cep_origem($company_cep_origem) {
        $this->company_cep_origem = $company_cep_origem;
    }
    
    public function getCompany_facebook() {
        return $this->company_facebook;
    }
    public function setCompany_facebook($company_facebook) {
        $this->company_facebook = $company_facebook;
    }
    
    public function getCompany_instagram() {
        return $this->company_instagram;
    }
    public function setCompany_instagram($company_instagram) {
        $this->company_instagram = $company_instagram;
    }
    public function getCompany_instagram_page() {
        $page = explode('/', $this->company_instagram);
        $key = count($page) - 1;
        return $page[$key] ? $page[$key] : $page[$key - 1];
    }
    
    public function getCompany_linkedin() {
        return $this->company_linkedin;
    }
    public function setCompany_linkedin($company_linkedin) {
        $this->company_linkedin = $company_linkedin;
    }
    
    public function getCompany_twitter() {
        return $this->company_twitter;
    }
    public function setCompany_twitter($company_twitter) {
        $this->company_twitter = $company_twitter;
    }
    
    public function getCompany_youtube() {
        return $this->company_youtube;
    }
    public function setCompany_youtube($company_youtube) {
        $this->company_youtube = $company_youtube;
    }
    
    public function getCorreio_empresa() {
        return $this->correio_empresa;
    }
    public function setCorreio_empresa($correio_empresa) {
        $this->correio_empresa = $correio_empresa;
    }
    
    public function getCorreio_senha() {
        return $this->correio_senha;
    }
    public function setCorreio_senha($correio_senha) {
        $this->correio_senha = $correio_senha;
    }
    
}
