<?php

class ContactBO extends BusinessABO {

    const ANEXO_EXT = 'doc|docx|pdf';
    const ANEXO_SIZE = 512000;
    const FOLDER = 'contact';
    
    private static function validate(ContactVO $vo) {
        if (!self::validateAdmin($vo)) {
            return false;
        }
        if (!array_key_exists($vo->getStatus(), SystemVO::getArray_status())) {
            throw new Exception("Status incorreto");
        }
        if (!ValidateU::isName($vo->getName()) && !ValidateU::isFullName($vo->getName())) {
            throw new Exception("Nome está incorreto");
        }
        if (!ValidateU::isEmail($vo->getEmail())) {
            throw new Exception("Email está incorreto");
        }
        if ($vo->getDdd_tel() || $vo->getTel()) {
            if (!ValidateU::isDDD($vo->getDdd_tel())) {
                throw new Exception("DDD telefone está incorreto");
            }
            if (!ValidateU::isTel($vo->getTel()) && !ValidateU::isCel($vo->getTel())) {
                throw new Exception("Telefone está incorreto");
            }
        }
        if (strlen($vo->getMsg()) > 1000) {
            throw new Exception("Mensagem excede os caracteres");
        }
        
        return true;
    }
    
    public static function add(ContactVO $vo) {
        if (!self::validate($vo)) {
            return false;
        }
        ContactDAO::insert($vo);
        
        return true;
    }
    
    public static function addTrabalheConosco(ContactVO $vo, array $array_filename) {
        if (!self::validate($vo)) {
            return false;
        }
        if (!ValidateU::vltFile(FormatU::getExt($array_filename['name']), self::ANEXO_EXT)) {
            throw new Exception("Extensão inválida, somente: " . self::ANEXO_EXT);
        }
        if ($array_filename['size'] > self::ANEXO_SIZE) {
            throw new Exception('Arquivo excede o tamanho máximo permitido: ' . FormatU::by2M(self::ANEXO_SIZE));
        }
        if (!self::upload($vo, $array_filename)) {
            return false;
        }
        
        $vo->setStatus(SystemVO::STATUS_ATIVO);
        $vo->setSubject('Trabalhe conosco do site - ' . $vo->getName());
        ContactDAO::insert($vo);
        
        $PHPMailer = new PHPMailer();
        $PHPMailer->addAddress(DefineC::d()->getCompany_email(), DefineC::d()->getCompany_fancy_name());
        $PHPMailer->addReplyTo($vo->getEmail(), $vo->getName());
        $PHPMailer->Subject = $vo->getSubject();
        $PHPMailer->addAttachment(DIR_UPLOADS . '/' . self::FOLDER . '/' . $vo->getFilename());
        $PHPMailer->msgHTML(EMAIL_MKT_HEAD . '<div style="display: table; padding: 40px;">
                                <h1 style="' . EMAIL_MKT_H1 . '">Trabalhe conosco do site</h1>
                                <span style="' . EMAIL_MKT_H3 . '">
                                    <b>Nome:</b> ' . $vo->getName() . '<br />
                                    <b>Email:</b> ' . $vo->getEmail() . '<br />
                                    <b>Telefone:</b> ' . FormatU::formatStr($vo->getDdd_tel() . $vo->getTel(), 'fone') . '<br />
                                    <b>Mensagem:</b> ' . $vo->getMsg() . '
                                </span>
                            </div>' . EMAIL_MKT_FOOTER);
        
        return MailT::sendMailerAuth($PHPMailer);
    }
    
    public static function edit(ContactVO $vo) {
        if (!self::validate($vo)) {
            return false;
        }
        $BVo = new ContactVO();
        $BVo->setId($vo->getId());
        $BVo = ContactDAO::selectByID($BVo);
        if (!$BVo) {
            throw new Exception("Invalid ID");
        }
        
        ContactDAO::update($vo);
        
        return true;
    }
    
    public static function disable(ContactVO $vo) {
        if (!self::validateAdmin($vo)) {
            return false;
        }
        if (!ContactDAO::selectCountByID($vo)) {
            throw new Exception("Invalid ID");
        }

        ContactDAO::updateDisable($vo);

        return true;
    }
    
    private static function upload(ContactVO $b, array $array_filename) {
        $getExt = '.' . FormatU::getExt($array_filename['name']);
        $file_name = substr(strtolower(FormatU::toAlphaNumeric($array_filename['name'])), 0, 245);
        $path_file = DIR_UPLOADS . '/' . self::FOLDER . '/';
        if (!is_dir($path_file)) {
            mkdir($path_file);
        }
        
        $file_name = ToolsT::renameFile($path_file, $file_name, $getExt) . $getExt;
        $path_file .= $file_name;
        
        if (!@move_uploaded_file($array_filename['tmp_name'], $path_file)) {
            throw new Exception('O Upload do arquivo para o servidor não pode ser efetuado. Lembrou de criar a pasta <b>contact</b> em /uploads?');
        }
       
        $b->setFilename($file_name);

        return true;
    }
    
}