<?php

class DefineC extends ControllerAC {
    
    private $defineVO;
    public function getDefineVO() { return $this->defineVO; return new DefineVO(); }
    
    public static function controller() {
        switch (isset($_REQUEST['funcao']) ? ValidateU::antStr($_REQUEST['funcao']) : false) {            
            case 'Cadastrar': self::cadastrar(); exit();
            case 'Alterar': self::alterar(); exit();
            case 'Deletar': self::deletar(); exit();
            case 'Order_By': self::order_by(); exit();
            case 'Search': self::search(); exit();
            case 'CleanSearch': self::cleanSearch(); exit();
        }
    }
    
    private static function getPOST(DefineVO $vo) {
        $vo->setPostAdminVO(AdminC::getIsLogado());
        $vo->setUpdateAdminVO(AdminC::getIsLogado());
        $vo->setStatus((int) $_POST['status']);
        $vo->setPage_title(ValidateU::antStr($_POST['page_title']));
        $vo->setPage_meta_keywords(ValidateU::antStr($_POST['page_meta_keywords']));
        $vo->setPage_meta_description(ValidateU::antStr($_POST['page_meta_description']));
        $vo->setPage_nice_url(ValidateU::antStr($_POST['page_nice_url']));
        $vo->setPage_analytics_code(ValidateU::antStr($_POST['page_analytics_code']));
        $vo->setCompany_cnpj(FormatU::int($_POST['company_cnpj']));
        $vo->setCompany_state_registration(ValidateU::antStr($_POST['company_state_registration']));
        $vo->setCompany_corporate_name(ValidateU::antStr($_POST['company_corporate_name']));
        $vo->setCompany_fancy_name(ValidateU::antStr($_POST['company_fancy_name']));
        $vo->setCompany_email(ValidateU::antStr($_POST['company_email']));
        $vo->setCompany_tel(ValidateU::antStr($_POST['company_tel']));
        $vo->setCompany_tel2(ValidateU::antStr($_POST['company_tel2']));
        $vo->setCompany_cel(ValidateU::antStr($_POST['company_cel']));
        $vo->setCompany_cel2(ValidateU::antStr($_POST['company_cel2']));
        $vo->setCompany_whatsapp(ValidateU::antStr($_POST['company_whatsapp']));        
        $vo->setCompany_address(ValidateU::antStr(nl2br($_POST['company_address']), '<br>'));
        $vo->setCompany_address2(ValidateU::antStr(nl2br($_POST['company_address2']), '<br>'));
        $vo->setCompany_cep_origem(FormatU::int($_POST['company_cep_origem']));
        $vo->setCompany_facebook(ValidateU::antStr($_POST['company_facebook']));
        $vo->setCompany_instagram(ValidateU::antStr($_POST['company_instagram']));
        $vo->setCompany_linkedin(ValidateU::antStr($_POST['company_linkedin']));
        $vo->setCompany_twitter(ValidateU::antStr($_POST['company_twitter']));
        $vo->setCompany_youtube(ValidateU::antStr($_POST['company_youtube']));
        $vo->setCorreio_empresa(ValidateU::antStr($_POST['correio_empresa']));
        $vo->setCorreio_senha(ValidateU::antStr($_POST['correio_senha']));
        
        return $vo;
    }
    
    private static function cadastrar() {
        AdminC::isLogado();
        
        try {
            DefineBO::add(self::getPOST(new DefineVO()));
            SystemC::setSucessMsg("Configurações salvas com sucesso");
        } catch (Exception $e) {
            SystemC::setErrorMsg($e->getMessage());
        }
        
        SystemC::redirect();
    }
    
    private static function alterar() {
        AdminC::isLogado();
        
        $vo = new DefineVO();
        $vo->setId((int) $_POST['define_id']);
        
        try {
            DefineBO::add(self::getPOST($vo));
            SystemC::setSucessMsg("Configurações salvas com sucesso");
        } catch (Exception $e) {
            SystemC::setErrorMsg($e->getMessage());
        }
        
        SystemC::redirect(SystemC::getPag() . '/' . $vo->getId());
    }
    
    private static function aplicar($funcao) {
        if (isset($_POST['define_id']) && is_array($_POST['define_id'])) {
            $seen = 0;
            if ($funcao == 'seen') {
                $seen = 1;
            } else if ($funcao == 'notseen') {
                $seen = 0;
            }
            
            $array = array_unique($_POST['define_id']);
            try {
                foreach ($array as $value) {
                    $vo = new DefineVO();
                    $vo->setId((int) $value);
                    $vo->setUpdateAdminVO(AdminC::getIsLogado());
                    
                    $vo = DefineDAO::selectByIDorLast($vo);
                    if (!$vo) {
                        break;
                    }
                    
                    $vo->setSeen($seen);                    
                    DefineDAO::update($vo);
                }
                SystemC::setSucessMsg('Ação aplicada com sucesso');
            } catch (Exception $e) {
                SystemC::setErrorMsg('ID inválido');
            }
        }
        
        SystemC::redirect(SystemC::getPag() . '/order_by/' . (int) SystemC::getPag(2) . '/pagina/' . (int) SystemC::getPag(4));
    }
    
    private static function deletar() {
        AdminC::isLogado();

        if (isset($_POST['define_id']) && is_array($_POST['define_id'])) {
            $array = array_unique($_POST['define_id']);
            try {
                foreach ($array as $value) {
                    $vo = new DefineVO();
                    $vo->setId((int) $value);
                    $vo->setUpdateAdminVO(AdminC::getIsLogado());

                    DefineBO::disable($vo);
                }
                SystemC::setSucessMsg('Configuração(s) excluído(s) com sucesso');
            } catch (Exception $e) {
                SystemC::setErrorMsg('ID inválido');
            }
        }

        SystemC::redirect(SystemC::getPag() . '/order_by/' . (int) SystemC::getPag(2) . '/pagina/' . (int) SystemC::getPag(4));
    }

    private static function order_by() {
        AdminC::isLogado();

        SystemC::redirect(SystemC::getPag() . '/order_by/' . (int) $_POST['order_by'] . '/pagina/' . (int) SystemC::getPag(4));
    }

    private static function search() {
        AdminC::isLogado();

        $_SESSION['define_page_title_src'] = ValidateU::antStr(@$_POST['page_title']);
        $_SESSION['define_page_nice_url_src'] = ValidateU::antStr(@$_POST['page_nice_url']);

        SystemC::redirect(SystemC::getPag() . '/order_by/' . (int) SystemC::getPag(2));
    }

    private static function cleanSearch() {
        AdminC::isLogado();

        ToolsT::cleanSESSION(array('define_page_title_src', 'define_page_nice_url_src'));
        SystemC::redirect();
    }
    
    public function defineList() {
        $this->defineVO = new DefineVO();
        $this->defineVO->setPage_title(ValidateU::antStr(@$_SESSION['define_page_title_src']));
        $this->defineVO->setPage_nice_url(ValidateU::antStr(@$_SESSION['define_page_nice_url_src']));
        
        $this->order_by = SystemC::getPag(2) ? (int) SystemC::getPag(2) : 4;
        $this->qtd = SystemVO::QTDBYPAGE;
        $this->pagina = SystemC::getPag(4);
        $this->ini = ToolsT::calcIni($this->qtd, $this->pagina);

        return DefineDAO::select($this->defineVO, array('order_by' => $this->order_by, 'ini' => $this->ini, 'qtd' => $this->qtd, 'pager' => true));
    }
    
    public static function defineEdit() {
        AdminC::isLogado();
        
        $vo = new DefineVO();
        $vo->setId((int) SystemC::getPag(1));

        $vo = DefineDAO::selectByIDorLast($vo);
        if ($vo) {
            $admin = AdminDAO::selectByID($vo->getPostAdminVO(), false);
            $vo->setPostAdminVO($admin ? $admin : new AdminVO());
            
            self::addRequireScript();
            
            return $vo;
        }
            
        SystemC::redirect('404');
    }
    
    public static function addRequireScript() {
        SystemC::addScript(array('valida_define', 'messages_pt-BR'));
    }
    
    public static function d() {
        return DefineBO::d();
    }

}