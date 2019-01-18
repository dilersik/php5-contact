<?php

class DefineBO extends BusinessABO {
    
    private static $define = null;
    
    private static function validate(DefineVO $vo) {
        if (!self::validateAdmin($vo)) {
            return false;
        }
        if (!ValidateU::isVarchar($vo->getPage_title())) {
            throw new Exception("Invalid page title");
        }
        if (!ValidateU::isMetaKeywords($vo->getPage_meta_keywords())) {
            throw new Exception("Invalid page keywords");
        }
        if (!ValidateU::isMetaDescription($vo->getPage_meta_description())) {
            throw new Exception("Invalid page description");
        }
        if ($vo->getPage_nice_url() && (!ValidateU::isLetterOnly_($vo->getPage_nice_url()) || !ValidateU::vltStr($vo->getPage_nice_url(), 1, 50))) {
            throw new Exception("Invalid page nice url");
        }
        if ($vo->getPage_analytics_code() && !ValidateU::vltStr($vo->getPage_analytics_code(), 12, 50)) {
            throw new Exception("Invalid page description");
        }
        if ($vo->getCompany_cnpj() && !ValidateU::isCNPJ($vo->getCompany_cnpj())) {
            throw new Exception("Invalid cnpj");
        }
        if ($vo->getCompany_state_registration() && !ValidateU::isInscricaoEstadual($vo->getCompany_state_registration())) {
            throw new Exception("Invalid state registration");
        }
        if ($vo->getCompany_corporate_name() && !ValidateU::isRazaoSocial($vo->getCompany_corporate_name())) {
            throw new Exception("Invalid corporate name");
        }
        if (!ValidateU::isNomeFantasia($vo->getCompany_fancy_name())) {
            throw new Exception("Invalid fancy_name");
        }
        if (!ValidateU::isEmail($vo->getCompany_email())) {
            throw new Exception("Invalid email");
        }
        if ($vo->getCompany_tel() && !ValidateU::isPhoneNumber($vo->getCompany_tel())) {
            throw new Exception("Invalid tel");
        }
        if ($vo->getCompany_tel2() && !ValidateU::isPhoneNumber($vo->getCompany_tel2())) {
            throw new Exception("Invalid tel2");
        }
        if ($vo->getCompany_cel() && !ValidateU::isPhoneNumber($vo->getCompany_cel())) {
            throw new Exception("Invalid cel");
        }
        if ($vo->getCompany_cel2() && !ValidateU::isPhoneNumber($vo->getCompany_cel2())) {
            throw new Exception("Invalid cel2");
        }
        if ($vo->getCompany_whatsapp() && !ValidateU::isPhoneNumber($vo->getCompany_whatsapp())) {
            throw new Exception("Invalid whatsapp");
        }
        if ($vo->getCompany_address() && !ValidateU::isVarchar($vo->getCompany_address())) {
            throw new Exception("Invalid address");
        }
        if ($vo->getCompany_address2() && !ValidateU::isVarchar($vo->getCompany_address2())) {
            throw new Exception("Invalid address2");
        }
        if (!ValidateU::isCEP($vo->getCompany_cep_origem())) {
            throw new Exception("Invalid cep_origem");
        }
        if ($vo->getCompany_facebook() && !ValidateU::isURL($vo->getCompany_facebook())) {
            throw new Exception("Invalid facebook");
        }
        if ($vo->getCompany_instagram() && !ValidateU::isURL($vo->getCompany_instagram())) {
            throw new Exception("Invalid instagram");
        }
        if ($vo->getCompany_linkedin() && !ValidateU::isURL($vo->getCompany_linkedin())) {
            throw new Exception("Invalid linkedin");
        }
        if ($vo->getCompany_twitter() && !ValidateU::isURL($vo->getCompany_twitter())) {
            throw new Exception("Invalid twitter");
        }
        if ($vo->getCompany_youtube() && !ValidateU::isURL($vo->getCompany_youtube())) {
            throw new Exception("Invalid youtube");
        }
        if ($vo->getCorreio_empresa() && !ValidateU::vltStr($vo->getCorreio_empresa(), 2, 20)) {
            throw new Exception("Invalid correio empresa");
        }
        if ($vo->getCorreio_senha() && !ValidateU::vltStr($vo->getCorreio_senha(), 2, 20)) {
            throw new Exception("Invalid correio senha");
        }
        
        return true;
    }
    
    public static function add(DefineVO $vo) {
        if (!self::validate($vo)) {
            return false;
        }
        DefineDAO::updateStatusLast(SystemVO::STATUS_INATIVO);
        
        $vo->setId(DefineDAO::insert($vo));
        
        return true;
    }
    
    public static function disable(DefineVO $vo) {
        if (!self::validateAdmin($vo)) {
            return false;
        }
        if (!DefineDAO::selectCountByID($vo)) {
            throw new Exception("Invalid ID");
        }

        DefineDAO::updateDisable($vo);

        return true;
    }
    
    public static function d() {
        if (!is_null(self::$define)) {
            return self::$define;
        }
        
        $vo = new DefineVO();
        $vo->setStatus(SystemVO::STATUS_ATIVO);
        self::$define = DefineDAO::selectByIDorLast($vo);
        self::$define = self::$define ? self::$define : new DefineVO();
        
        return self::$define;
        return new DefineVO();
    }
    
}