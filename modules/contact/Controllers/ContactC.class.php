<?php

class ContactC extends ControllerAC {
    
    private $contactVO;
    private $contactInfo;
    private static $array_filename;
    public function getContactVO() { return $this->contactVO; return new ContactVO(); }
    public function getContactInfo() { return $this->contactInfo; }
    
    public static function controller() {
        switch (isset($_REQUEST['funcao']) ? ValidateU::antStr($_REQUEST['funcao']) : false) {            
            case 'Cadastrar': self::cadastrar(); exit();
            case 'cadastrarTrabalheConosco': self::cadastrarTrabalheConosco(); exit();
            case 'Alterar': self::alterar(); exit();
            case 'seen': case 'notseen': self::aplicar($_REQUEST['funcao']); exit();
            case 'Deletar': self::deletar(); exit();
            case 'Order_By': self::order_by(); exit();
            case 'Search': self::search(); exit();
            case 'CleanSearch': self::cleanSearch(); exit();
        }
    }
    
    private static function getPOST(ContactVO $vo) {
        $vo->setPostAdminVO(AdminC::getIsLogado());
        $vo->setUpdateAdminVO(AdminC::getIsLogado());
        
        $vo->setStatus((int) $_POST['status']);
        $vo->setName(FormatU::tupper(ValidateU::antStr($_POST['name'])));
        $vo->setEmail(FormatU::tlower(ValidateU::antStr($_POST['email'])));
        if (isset($_POST['fulltel'])) {
            $fulltel = FormatU::int($_POST['fulltel']);
            $vo->setDdd_tel(substr($fulltel, 0, 2));
            $vo->setTel(substr($fulltel, 2));
        } else {
            $vo->setDdd_tel(FormatU::int(@$_POST['ddd_tel']));
            $vo->setTel(FormatU::int(ValidateU::antStr(@$_POST['tel'])));
        }
        $vo->setMsg(ValidateU::antStr(nl2br($_POST['msg']), '<br>'));
        
        return $vo;
    }
    
    private static function cadastrar() {
        AdminC::isLogado();
        
        try {
            ContactBO::add(self::getPOST(new ContactVO()));
            SystemC::setSucessMsg("Contato cadastrado com sucesso!");
        } catch (Exception $e) {
            SystemC::setErrorMsg("Ocorreu um erro no envio. Tente novamente mais tarde " . $e->getMessage());
        }
        
        SystemC::redirect();
    }
    
    private static function cadastrarTrabalheConosco() {
        if (is_file($_FILES['files']['tmp_name'])) {
            self::$array_filename = $_FILES['files'];
        }
        try {
            ContactBO::addTrabalheConosco(self::getPOST(new ContactVO()), self::$array_filename);
            SystemC::setSucessMsg("Obrigado! Seu currículo foi enviado com sucesso");
        } catch (Exception $e) {
            SystemC::setErrorMsg("Ocorreu um erro no envio. Tente novamente mais tarde " . $e->getMessage());
        }
        
        header('Location: ' . HTTP_SERVER . '/' . SystemC::getPag());
    }
    
    private static function alterar() {
        AdminC::isLogado();
        
        $vo = new ContactVO();
        $vo->setId((int) $_POST['contact_id']);
        try {
            ContactBO::edit(self::getPOST($vo));
            SystemC::setSucessMsg("Contato alterado com sucesso");
        } catch (Exception $e) {
            SystemC::setErrorMsg($e->getMessage());
        }
        
        SystemC::redirect(SystemC::getPag() . '/' . $vo->getId());
    }
    
    private static function aplicar($funcao) {
        if (isset($_POST['contact_id']) && is_array($_POST['contact_id'])) {
            $seen = 0;
            if ($funcao == 'seen') {
                $seen = 1;
            } else if ($funcao == 'notseen') {
                $seen = 0;
            }
            
            $array = array_unique($_POST['contact_id']);
            try {
                foreach ($array as $value) {
                    $vo = new ContactVO();
                    $vo->setId((int) $value);
                    
                    $vo = ContactDAO::selectByID($vo);
                    if (!$vo) {
                        break;
                    }
                    
                    $vo->setSeen($seen);                    
                    ContactDAO::update($vo);
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

        if (isset($_POST['contact_id']) && is_array($_POST['contact_id'])) {
            $array = array_unique($_POST['contact_id']);
            try {
                foreach ($array as $value) {
                    $vo = new ContactVO();
                    $vo->setId((int) $value);
                    $vo->setUpdateAdminVO(AdminC::getIsLogado());

                    ContactBO::disable($vo);
                }
                SystemC::setSucessMsg('Contato(s) excluído(s) com sucesso');
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

        $_SESSION['contact_name_src'] = ValidateU::antStr(@$_POST['name']);
        $_SESSION['contact_subject_src'] = ValidateU::antStr(@$_POST['subject']);
        $_SESSION['contact_contactinfo_src'] = ValidateU::antStr(@$_POST['contactinfo']);
        $_SESSION['contact_seen_src'] = ValidateU::antStr(@$_POST['seen']);
        $_SESSION['contact_responded_src'] = ValidateU::antStr(@$_POST['responded']);

        SystemC::redirect(SystemC::getPag() . '/order_by/' . (int) SystemC::getPag(2));
    }

    private static function cleanSearch() {
        AdminC::isLogado();

        ToolsT::cleanSESSION(array('contact_name_src', 'contact_contactinfo_src', 'contact_seen_src', 'contact_responded_src'));
        SystemC::redirect();
    }
    
    public function contactList() {
        $this->contactVO = new ContactVO();
        $this->contactVO->setName(ValidateU::antStr(@$_SESSION['contact_name_src']));
        $this->contactVO->setSeen(isset($_SESSION['contact_seen_src']) && array_key_exists($_SESSION['contact_seen_src'], SystemVO::getArray_bit()) ? 
                                (int) $_SESSION['contact_seen_src'] : null);
        $this->contactVO->setResponded(isset($_SESSION['contact_responded_src']) && array_key_exists($_SESSION['contact_responded_src'], SystemVO::getArray_bit()) ?
                                    (int) $_SESSION['contact_responded_src'] : null);
        $this->contactInfo = ValidateU::antStr(@$_SESSION['contact_contactinfo_src']);
        
        $this->order_by = SystemC::getPag(2) ? (int) SystemC::getPag(2) : 4;
        $this->qtd = SystemVO::QTDBYPAGE;
        $this->pagina = SystemC::getPag(4);
        $this->ini = ToolsT::calcIni($this->qtd, $this->pagina);

        return ContactDAO::select($this->contactVO, array('order_by' => $this->order_by, 'ini' => $this->ini, 'qtd' => $this->qtd, 'pager' => true,
                                                    'contactInfo' => $this->contactInfo));
    }
    
    public static function contactEdit() {
        $vo = new ContactVO();
        $vo->setId((int) SystemC::getPag(1));

        $vo = ContactDAO::selectByID($vo);
        if ($vo) {
            $vo->setSeen(1);
            ContactDAO::update($vo);
            
            self::addRequireScript();
            
            return $vo;
        }
            
        SystemC::redirect('404');
    }
    
    public static function addRequireScript() {
        SystemC::addScript(array('jquery.validate.min', 'methods_jQuery', 'valida_contact', 'messages_pt-BR'));
    }
    
    public static function getFileURL(ContactVO $vo, $http = true) {
        return ($http ? HTTP_SERVER . '/' : "") . DIR_UPLOADS . '/' . ContactBO::FOLDER . '/' . $vo->getFilename();
    }

}