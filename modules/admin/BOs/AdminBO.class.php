<?php

class AdminBO extends BusinessABO {

    const COOKIE_LOGIN_EXPIRE = 10800; //s = 12h
    const SESSION_INACTIVE_EXPIRE = 3600; //s = 60m

    private static function validate(AdminVO $vo) {
        if (!self::validateAdmin($vo)) {
            return false;
        }
        if (!array_key_exists($vo->getStatus(), SystemVO::getArray_status())) {
            throw new Exception("Invalid status");
        }
        if (!$vo->getListAdmin_Area_UnVO()) {
            throw new Exception("Invalid Admin Array AreaID");
        }
        foreach ($vo->getListAdmin_Area_UnVO() as $value) {
            if (!Admin_AreaDAO::selectCountByID($value->getAdmin_AreaVO())) {
                throw new Exception("Invalid Admin AreaID");
            }
        }
        if (!ValidateU::isName($vo->getName())) {
            throw new Exception("Invalid name");
        }
        if ($vo->getLastname() && !ValidateU::isLastName($vo->getLastname())) {
            throw new Exception("Invalid lastname");
        }
        if (!ValidateU::isEmail($vo->getEmail())) {
            throw new Exception("Invalid email");
        }
        $AVo = new AdminVO();
        $AVo->setId($vo->getId());
        $AVo->setEmail($vo->getEmail());
        if (AdminDAO::selectCount($AVo)) {
            throw new Exception("Invalid email exists");
        }
        if (!ValidateU::isUsername($vo->getUsername())) {
            throw new Exception("Invalid username");
        }
        $AVo = new AdminVO();
        $AVo->setId($vo->getId());
        $AVo->setUsername($vo->getUsername());
        if (AdminDAO::selectCount($AVo)) {
            throw new Exception("Invalid username exists");
        }

        return true;
    }
    
    private static function validatePwd(AdminVO $vo) {
        if (!ValidateU::isPWD($vo->getPwd())) {
            throw new Exception("Invalid password");
        }
        if ($vo->getPwd() == $vo->getUsername()) {
            throw new Exception("Invalid password = username");
        }

        $vo->setPwd(FormatU::cryptPwd($vo->getPwd()));

        return true;
    }

    public static function validateAtualPwd(AdminVO $vo, $pwdAtual) {
        return AdminDAO::selectPwdByID($vo)->getPwd() == FormatU::cryptPwd($pwdAtual);
    }

    private static function addAdmin_Area_Un(AdminVO $vo) {
        foreach ($vo->getListAdmin_Area_UnVO() as $value) {
            $value->setAdminVO($vo);

            if (Admin_Area_UnDAO::selectCount($value, null)) {
                Admin_Area_UnDAO::updateEnable($value);
            } else {
                Admin_Area_UnDAO::insert($value);
            }
        }

        return true;
    }

    public static function add(AdminVO $vo) {
        if (!self::validate($vo)) {
            return false;
        }
        if (!self::validatePwd($vo)) {
            return false;
        }

        $vo->setToken(FormatU::uniqStr());
        $vo->setId(AdminDAO::insert($vo));

        self::addAdmin_Area_Un($vo);

        return true;
    }

    public static function edit(AdminVO $vo) {
        $AVo = new AdminVO();
        $AVo->setId($vo->getId());
        if (!AdminDAO::selectCountByID($AVo)) {
            throw new Exception("Invalid AdminID");
        }
        if (!self::validate($vo)) {
            return false;
        }
        if ($vo->getPwd() && !self::validatePwd($vo)) {
            return false;
        }

        $vo->setToken(FormatU::uniqStr());
        AdminDAO::update($vo);
        $AdmAreUn = new Admin_Area_UnVO();
        $AdmAreUn->setAdminVO($vo);
        Admin_Area_UnDAO::updateDisable($AdmAreUn);

        self::addAdmin_Area_Un($vo);

        return true;
    }

    public static function disable(AdminVO $vo) {
        if (!self::validateAdmin($vo)) {
            return false;
        }
        if (!AdminDAO::selectCountByID($vo)) {
            throw new Exception("Invalid AdminID");
        }

        AdminDAO::updateDisable($vo);

        return true;
    }

    public static function login(AdminVO $vo) {
        if (!ValidateU::isUsername($vo->getUsername()) || !ValidateU::isPWD($vo->getPwd())) {
            return false;
        }

        $vo->setPwd(FormatU::cryptPwd($vo->getPwd()));
        $getUniqAdmin = AdminDAO::selectUniq($vo);
        if (!$getUniqAdmin) {
            return false;
        }

        $adminLogVO = new Admin_LoginVO();
        $adminLogVO->setPostAdminVO($getUniqAdmin);
        $adminLogVO->setToken($getUniqAdmin->getToken());
        $insertAdmin_Login = Admin_LoginDAO::insert($adminLogVO);

        self::isntLogado();
        $_SESSION[AdminC::getSession_Admin_id()] = $getUniqAdmin->getId();
        $_SESSION[AdminC::getSession_Admin_Login_id()] = $insertAdmin_Login;
//        setcookie(AdminC::getCookie_Admin_id(), $getUniqAdmin->getId(), time() + self::COOKIE_LOGIN_EXPIRE, '/');
//        setcookie(AdminC::getCookie_Admin_Login_id(), $insertAdmin_Login, time() + self::COOKIE_LOGIN_EXPIRE, '/');
        setcookie(AdminC::getCookie_Admin_id(), $getUniqAdmin->getId(), 0, '/');
        setcookie(AdminC::getCookie_Admin_Login_id(), $insertAdmin_Login, 0, '/');

        return true;
    }

    public static function isLogado() {
        if (!isset($_SESSION[AdminC::getSession_Admin_id()]) || !isset($_SESSION[AdminC::getSession_Admin_Login_id()])) {
            self::isntLogado();
            throw new Exception('No SESSION created');
        }
        if (!isset($_COOKIE[AdminC::getCookie_Admin_id()]) || !isset($_COOKIE[AdminC::getCookie_Admin_Login_id()])) {
            self::isntLogado();
            throw new Exception('No COOKIE created', 2);
        }
        if ($_SESSION[AdminC::getSession_Admin_id()] != $_COOKIE[AdminC::getCookie_Admin_id()] ||
            $_SESSION[AdminC::getSession_Admin_Login_id()] != $_COOKIE[AdminC::getCookie_Admin_Login_id()]) {
            self::isntLogado();
            throw new Exception('SESSION != COOKIE', 3);
        }

        $adminLogVO = new Admin_LoginVO();
        $adminLogVO->setPostAdminVO(new AdminVO());
        $adminLogVO->getPostAdminVO()->setId($_SESSION[AdminC::getSession_Admin_id()]);
        $getUniqAdmin_Login = Admin_LoginDAO::selectUniq($adminLogVO);
        if (!$getUniqAdmin_Login) {
            self::isntLogado();
            throw new Exception('No List admin_login', 4);
        }
        if ($getUniqAdmin_Login->getId() != $_SESSION[AdminC::getSession_Admin_Login_id()]) {
            self::isntLogado();
            throw new Exception('New ID insert AT admin_login', 5);
        }

        $segundos = time() - strtotime($getUniqAdmin_Login->getDate_update());
        if ($segundos > self::SESSION_INACTIVE_EXPIRE) {
            throw new Exception("Expirou por inatividade", 6);
        }

        $getUniqAdmin_Login->setDate_update(SystemC::dateTimeISO());
        Admin_LoginDAO::update($getUniqAdmin_Login);

        // return $_SESSION[AdminC::getSession_Admin_id()];
        return $getUniqAdmin_Login->getPostAdminVO();
    }

    public static function isntLogado() {
        ToolsT::cleanSESSION(array(AdminC::getSession_Admin_id(), AdminC::getSession_Admin_Login_id()));
        ToolsT::cleanCOOKIE(array(AdminC::getCookie_Admin_id(), AdminC::getCookie_Admin_Login_id()), self::COOKIE_LOGIN_EXPIRE);

        return false;
    }

}
