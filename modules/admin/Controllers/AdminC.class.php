<?php

class AdminC extends ControllerAC {

    private $AdminVO;
    private static $isLogado = null;
    private static $array_pagAdmin_Area = array(
        2 => array('homeVA' => array(), 'restrito' => array(), 'Access_DeniedVA' => array())
    );
    public function getAdminVO() { return $this->AdminVO; return new AdminVO(); }
    public static function getIsLogado() { return self::$isLogado; return new AdminVO(); }
    public static function getSession_Admin_id() { return md5(PROJECT_NAME . 'SESSION_ADMIN_ID'); }
    public static function getSession_Admin_Login_id() { return md5(PROJECT_NAME . 'SESSION_ADMIN_LOGIN_ID'); }
    public static function getCookie_Admin_id() { return md5(PROJECT_NAME . 'COOKIE_ADMIN_ID'); }
    public static function getCookie_Admin_Login_id() { return md5(PROJECT_NAME . 'COOKIE_ADMIN_LOGIN_ID'); }

    public static function controller() {
        switch (isset($_REQUEST['funcao']) ? ValidateU::antStr($_REQUEST['funcao']) : false) {
            case 'existAdmin': self::existAdmin(); exit();
            case 'Cadastrar': self::cadastrar(); exit();
            case 'Alterar': self::alterar(); exit();
            case 'Deletar': self::deletar(); exit();
            case 'Order_By': self::order_by(); exit();
            case 'Search': self::search(); exit();
            case 'CleanSearch': self::cleanSearch(); exit();
            case 'logar': self::logar(); exit();
            case 'logout': self::logout(); exit();
            case 'updateLogin': self::updateLogin(); exit();
        }
    }

    private static function existAdmin() {
        self::isLogado();

        $AdminVO = new AdminVO();
        $AdminVO->setId(isset($_GET['admin_id']) ? (int) $_GET['admin_id'] : 0);

        if (isset($_GET['email'])) {
            $AdminVO->setEmail(ValidateU::antStr($_GET['email']));
        } else if (isset($_GET['username'])) {
            $AdminVO->setUsername(ValidateU::antStr($_GET['username']));
        }

        echo (AdminDAO::selectCount($AdminVO) == 0 ? 'true' : 'false');
    }
    
    private static function getPOST(AdminVO $vo) {
        $vo->setPostAdminVO(AdminC::getIsLogado());
        $vo->setUpdateAdminVO(AdminC::getIsLogado());
        $vo->setStatus((int) $_POST['status']);
        $list = array();
        if (isset($_POST['admin_area_id']) && is_array($_POST['admin_area_id'])) {
            $array = array_unique($_POST['admin_area_id']);
            foreach ($array as $value) {
                $admAreaUn = new Admin_Area_UnVO();
                $admAreaUn->setAdmin_AreaVO(new Admin_AreaVO());
                $admAreaUn->getAdmin_AreaVO()->setId($value);
                $list[] = $admAreaUn;
            }
        }
        $vo->setListAdmin_Area_UnVO($list);
        $vo->setName(FormatU::tupper(ValidateU::antStr($_POST['name'])));
        $vo->setLastname(FormatU::tupper(ValidateU::antStr($_POST['lastname'])));
        $vo->setEmail(FormatU::tlower(ValidateU::antStr($_POST['email'])));
        $vo->setUsername(ValidateU::antStr($_POST['username']));
        if (isset($_POST['pwd'])) {
            $vo->setPwd(ValidateU::antStr($_POST['pwd']));
        }

        return $vo;
    }

    private static function cadastrar() {
        self::isLogado();

        if (self::validatePwdAtual()) {
            try {
                AdminBO::add(self::getPOST(new AdminVO()));
                SystemC::setSucessMsg('Novo usuário cadastrado com sucesso');
            } catch (Exception $e) {
                SystemC::setErrorMsg($e->getMessage());
            }
        }

        SystemC::redirect();
    }

    private static function alterar() {
        self::isLogado();

        $AdminVO = new AdminVO();
        $AdminVO->setId((int) SystemC::getPag(1));
        if (self::validatePwdAtual()) {
            try {
                AdminBO::edit(self::getPOST($AdminVO));
                SystemC::setSucessMsg('Dados do usuário alterados com sucesso');
            } catch (Exception $e) {
                SystemC::setErrorMsg($e->getMessage());
            }
        }

        SystemC::redirect(SystemC::getPag() . '/' . $AdminVO->getId());
    }

    private static function deletar() {
        self::isLogado();

        if (self::validatePwdAtual()) {
            if (isset($_POST['admin_id']) && is_array($_POST['admin_id'])) {
                $array = array_unique($_POST['admin_id']);
                try {
                    foreach ($array as $value) {
                        $vo = new AdminVO();
                        $vo->setId((int) $value);
                        $vo->setUpdateAdminVO(AdminC::getIsLogado());

                        AdminBO::disable($vo);
                    }
                    SystemC::setSucessMsg('Usuário(s) excluído(s) com sucesso');
                } catch (Exception $e) {
                    SystemC::setErrorMsg('ID inválido');
                }
            }
        }
        SystemC::redirect(SystemC::getPag() . '/order_by/' . (int) SystemC::getPag(2) . '/pagina/' . (int) SystemC::getPag(4));
    }

    private static function order_by() {
        self::isLogado();
        SystemC::redirect(SystemC::getPag() . '/order_by/' . (int) $_POST['order_by'] . '/pagina/' . (int) SystemC::getPag(4));
    }
    
    private static function search() {
        self::isLogado();

        $_SESSION['admin_name_src'] = ValidateU::antStr(@$_POST['name']);
        $_SESSION['admin_area_id_src'] = intval(@$_POST['admin_area_id']);

        SystemC::redirect(SystemC::getPag() . '/order_by/' . (int) SystemC::getPag(2));
    }

    private static function cleanSearch() {
        self::isLogado();

        ToolsT::cleanSESSION(array('admin_name_src', 'admin_area_id_src'));
        SystemC::redirect();
    }

    private static function logar() {
        $AdminVO = new AdminVO();
        $AdminVO->setUsername(ValidateU::antStr($_POST['username']));
        $AdminVO->setPwd(ValidateU::antStr($_POST['pwd']));
        $url_return = isset($_POST['url_return']) ? ValidateU::antStr($_POST['url_return']) : '';

        if (AdminBO::login($AdminVO)) {
            SystemC::redirect($url_return ? SystemC::setREQUEST_URI($url_return) : 'homeVA');
        } else {
            SystemC::setErrorMsg('Login e/ou senha incorretos, favor verifique');
            SystemC::redirect('admin_loginVP&url_return=' . $url_return);
        }
    }

    private static function logout() {
        AdminBO::isntLogado();
        SystemC::setInfoMsg('Logout efetuado com sucesso');
        SystemC::redirect('admin_loginVP');
    }

    private static function updateLogin() {
        self::isLogado(FALSE);

        echo AdminC::expireDateLogin(AdminC::getName()->getListAdmin_LoginVO(0)->getDate_update());
    }
    
    private static function showMessages($code) {
        switch ($code) {
            case 2: SystemC::setWarningMsg('Tempo expirado! Entre com seu Login e Senha'); break;
            case 5: SystemC::setWarningMsg('Sessão encerrada! Talvez mesmo Login em uso'); break;
            case 6: SystemC::setWarningMsg("Tempo de sessão expirada por inatividade, por favor, efetue o login novamente"); break;
            default: SystemC::setInfoMsg('Entre com seu Login e Senha'); break;
        }
    }

    public static function addRequireScript() {
        SystemC::addScript(array('jquery.pstrength.min', 'jquery.pstrength.config', 'valida_admin', 'messages_pt-BR'));
    }

    public static function getName() {
        self::isLogado();

        return AdminDAO::selectNameByID(self::getIsLogado());
    }

    public static function getByID(AdminVO $vo) {
        $get = AdminDAO::selectByID($vo, FALSE);
        return $get ? $get : $vo;
        return new AdminVO();
    }

    private static function validatePwdAtual() {
        if (!AdminBO::validateAtualPwd(self::$isLogado, ValidateU::antStr($_POST['pwd_atual']))) {
            SystemC::setWarningMsg('A sua senha atual de administrador não confere');
            return false;
        }

        return true;
    }

    public static function isLogado($checkPag = true) {
        if (!self::$isLogado) {
            try {
                self::$isLogado = AdminBO::isLogado();
                if (self::$isLogado && $checkPag && !self::isLogado_Pag(self::$isLogado)) {
                    SystemC::redirect('Access_DeniedVA');
                }
            } catch (Exception $e) {
                self::showMessages($e->getCode());
                SystemC::redirect('admin_loginVP&url_return=' . SystemC::getREQUEST_URI());
            }
        }
        return self::$isLogado;
    }

    private static function isLogado_Pag(AdminVO $vo) {
        $adminAUn = new Admin_Area_UnVO();
        $adminAUn->setAdminVO($vo);
        $listAdmin_Area_Un = Admin_Area_UnDAO::select($adminAUn);
        if ($listAdmin_Area_Un) {
            foreach ($listAdmin_Area_Un as $value) {
                if ($value->getAdmin_AreaVO()->getId() == 1) {
                    return true;
                }
                if (!array_key_exists($value->getAdmin_AreaVO()->getId(), self::$array_pagAdmin_Area)) {
                    return false;
                }
                if (!array_key_exists(SystemC::getPag(), self::$array_pagAdmin_Area[$value->getAdmin_AreaVO()->getId()])) {
                    return false;
                }
                if (isset($_REQUEST['funcao']) && !in_array($_REQUEST['funcao'],
                    self::$array_pagAdmin_Area[$value->getAdmin_AreaVO()->getId()][SystemC::getPag()])) {
                    return false;
                }
                return true;
            }
        }
        return false;
    }

    public static function expireDateLogin($date) {
        return date('Y-m-d H:i:s', strtotime($date . ' +' . AdminBO::SESSION_INACTIVE_EXPIRE . 'seconds'));
    }

    public function adminList() {
        $this->AdminVO = new AdminVO();
        $this->AdminVO->setName(ValidateU::antStr(@$_SESSION['admin_name_src']));
        if (@$_SESSION['admin_area_id_src']) {
            $un = new Admin_Area_UnVO();
            $un->setAdmin_AreaVO(new Admin_AreaVO());
            $un->getAdmin_AreaVO()->setId(intval($_SESSION['admin_area_id_src']));
            $this->AdminVO->setListAdmin_Area_UnVO(array($un));
        }
        
        $this->order_by = SystemC::getPag(2) ? (int) SystemC::getPag(2) : 1;
        $this->qtd = SystemVO::QTDBYPAGE;
        $this->pagina = SystemC::getPag(4);
        $this->ini = ToolsT::calcIni($this->qtd, $this->pagina);

        return AdminDAO::select($this->AdminVO, array('order_by' => $this->order_by, 'ini' => $this->ini, 'qtd' => $this->qtd, 'pager' => true));
    }

    public static function adminEdit() {
        self::isLogado();

        $AdminVO = new AdminVO();
        $AdminVO->setId((int) SystemC::getPag(1));

        $AdminVO = AdminDAO::selectByID($AdminVO);
        if ($AdminVO) {
            self::addRequireScript();

            return $AdminVO;
        }

        SystemC::redirect('404VP');
    }

    public static function countAdmin_Area_Un(AdminVO $ad, Admin_AreaVO $AdAr) {
        $adminArUn = new Admin_Area_UnVO();
        $adminArUn->setAdmin_AreaVO($AdAr);
        $adminArUn->setAdminVO($ad);

        return Admin_Area_UnDAO::selectCount($adminArUn);
    }
    
    public static function imgSrc($img) {
        return HTTP_SERVER . '/' . DIR_MODULES . '/admin/' . DIR_IMG . '/' . $img;
    }

    public static function includeTopNav() {
        foreach (_MODULES() as $module) {
            if (file_exists(DIR_MODULES . '/' . $module . '/' . DIR_VIEW . '/admin/includes/topnavVA.inc.php')) {
                include_once DIR_MODULES . '/' . $module . '/' . DIR_VIEW . '/admin/includes/topnavVA.inc.php';
            }
        }
    }
    
    public static function includeHomeNav() {
        foreach (_MODULES() as $module) {
            if (file_exists(DIR_MODULES . '/' . $module . '/' . DIR_VIEW . '/admin/includes/homenavVA.inc.php')) {
                include_once DIR_MODULES . '/' . $module . '/' . DIR_VIEW . '/admin/includes/homenavVA.inc.php';
            }
        }
    }
    
}