<?php

abstract class ControllerAC {
    
    protected $order_by, $ini, $qtd, $pagina;
    protected static $rows;
    
    public function getOrder_by() {
        return (int) $this->order_by;
    }

    public function getIni() {
        return (int) $this->ini;
    }

    public function getQtd() {
        return (int) $this->qtd;
    }

    public function getPagina() {
        return (int) $this->pagina;
    }

    public static function getRows() {
        return (int) self::$rows;
    }

    public static function setRows($rows) {
        self::$rows = (int) $rows;
    }
    
    public static function showPostUpdateText(ModelVOAC $vo) {
        return '<p style="margin-top: 50px">
            <b>Cadastrado:</b> ' . FormatU::dateFormat_ptBR($vo->getDate_post(), 'full') . ' -
            <a href="' . SystemC::link_('adminEditVA/' . $vo->getPostAdminVO()->getId()) . '" target="_blank">
                ' . AdminC::getByID($vo->getPostAdminVO())->getName() . '
            </a><br />
            <b>Alterado:</b> ' . ($vo->getDate_update() ? FormatU::dateFormat_ptBR($vo->getDate_update(), 'full') : '') . ' -
            <a href="' . SystemC::link_('adminEditVA/' . $vo->getPostAdminVO()->getId()) . '" target="_blank">
                ' . AdminC::getByID($vo->getUpdateAdminVO())->getName() . '
            </a>
        </p>';
    }

}
