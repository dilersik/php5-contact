<?php

class SystemVO {

    private static $array_status = array(1 => 'Ativo', 'Inativo');
    const STATUS_ATIVO = 1, STATUS_INATIVO = 2;
    private static $array_order_default = array(1 => 'Título A-Z', 'Título Z-A', 'Data de cadastro crescente', 'Data de cadastro decrescente', 'Status Ativo', 'Status Inativo');
    private static $arrayOrder = array(1 => 'Título A-Z', 'Título Z-A', 'Data de cadastro crescente', 'Data de cadastro decrescente');
    private static $array_bit = array('Não', 'Sim');
    private static $array_gender = array(1 => 'Feminino', 'Masculino');
    const GENDER_FEM = 1, GENDER_MAS = 2;
    private static $array_person = array(1 => 'Física', 'Jurídica');
    const PERSON_FISICA = 1, PERSON_JURIDICA = 2;
    private static $array_weight = array(1 => 'mg', 'g', 'Kg');
    const WEIGHT_MG = 1, WEIGHT_G = 2, WEIGHT_KG = 3;
    private static $array_volume = array(1 => 'ml', 'L');
    const VOLUME_ML = 1, VOLUME_L = 2;
    private static $array_un = array(self::UN_BB => "BB", self::UN_BL => "BL", self::UN_BT => "BT", self::UN_CJ => "CJ", self::UN_CX => "CX", self::UN_ES => "ES",
        self::UN_FD => "FD", self::UN_FL => "FL", self::UN_FR => "FR", self::UN_JG => "JG", self::UN_KG => "KG", self::UN_LT => "LT", self::UN_MT => "MT",
        self::UN_PC => "PC", self::UN_PT => "PT", self::UN_RL => "RL", self::UN_TB => "TB", self::UN_TN => "TN", self::UN_UN => "UN");
    const UN_BB = 1, UN_BL = 2, UN_BT = 3, UN_CJ = 4, UN_CX = 5, UN_ES = 6, UN_FD = 7, UN_FL = 8, UN_FR = 9, UN_JG = 10, UN_KG = 11, UN_LT = 12, UN_MT = 13, UN_PT = 14, UN_RL = 15,
          UN_TB = 16, UN_TN = 17, UN_UN = 18, UN_PC = 19;
    private static $array_measure = array(1 => "cm", "m");
    const MEASURE_CM = 1, MEASURE_M = 2;
    private static $array_daysOfWeek = array('domingo', 'segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado');
    private static $array_monthsOfYear = array(1 => 'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro');
    private static $pageMeta_keywords;
    private static $pageMeta_description;
    private static $pageTitle;
	
	//FACEBOOK OG
    private static $OGtitle;
    private static $OGurl;
    private static $OGtype = 'website';
    private static $OGimg;
    private static $OGdescription;
	
    private static $array_style = array();
    private static $array_script = array();
    private static $getPag = array();
    private static $includeFilter = false;
    private static $includeLeft = FALSE;
    private static $includeLeftCat = true;
    private static $includeLeftMyAcc = false;
    const CODE_ERROR_MESSAGE = 1, CODE_SUCESS_MESSAGE = 2, CODE_INFO_MESSAGE = 3, CODE_WARNING_MESSAGE = 4;
    const SESSION_MESSAGE = 'return_msg';
    const QTDBYPAGE = 50;
    private static $metaOg = array();

    /**
     * @param array $metaOg <p>
     * array('url' => "", 'image' => "", 'site_name' => "", 'title' => "")
     * </p>
     */
    public static function setMetaOg(array $metaOg) {
        self::$metaOg['site_name'] = DefineC::d()->getCompany_fancy_name();
        foreach ($metaOg as $key => $value) {
            self::$metaOg[$key] = $value;
        }
    }
    public static function getMetaOg($key) {
        return array_key_exists($key, self::$metaOg) && !is_null($key) ? self::$metaOg[$key] : '';
    }

    public static function getArray_status($key = 0) {
        return $key > 0 ? self::$array_status[$key] : self::$array_status;
    }

    public static function getArray_order_default($key = 0) {
        return $key > 0 ? self::$array_order_default[$key] : self::$array_order_default;
    }

    public static function getArrayOrder($key = 0) {
        return $key > 0 ? self::$arrayOrder[$key] : self::$arrayOrder;
    }

    public static function getArray_bit($key = -1) {
        return $key > -1 ? self::$array_bit[$key] : self::$array_bit;
    }

    public static function getArray_gender($key = 0) {
        return $key > 0 ? self::$array_gender[$key] : self::$array_gender;
    }

    public static function getArray_person($key = 0) {
        return $key > 0 ? self::$array_person[$key] : self::$array_person;
    }

    public static function getArray_weight($key = 0) {
        return $key > 0 ? self::$array_weight[$key] : self::$array_weight;
    }

    public static function getArray_volume($key = 0) {
        return $key > 0 ? self::$array_volume[$key] : self::$array_volume;
    }

    public static function getArray_un($key = 0) {
        return $key > 0 ? self::$array_un[$key] : self::$array_un;
    }

    public static function getArray_measure($key = 0) {
        return $key > 0 ? self::$array_measure[$key] : self::$array_measure;
    }

    public static function getArray_daysOfWeek($key = -1) {
        return $key > -1 ? self::$array_daysOfWeek[$key] : self::$array_daysOfWeek;
    }

    public static function getArray_monthsOfYear($key = 0) {
        return $key > 0 ? self::$array_monthsOfYear[$key] : self::$array_monthsOfYear;
    }

    public static function getPageMeta_keywords() {
        return self::$pageMeta_keywords != null && self::$pageMeta_keywords != "" ? self::$pageMeta_keywords : DefineC::d()->getPage_meta_keywords();
    }
    public static function setPageMeta_keywords($pageMeta_keywords) {
        self::$pageMeta_keywords = $pageMeta_keywords;
    }

    public static function getPageMeta_description() {
        return self::$pageMeta_description != null && self::$pageMeta_description != "" ? self::$pageMeta_description : DefineC::d()->getPage_meta_description();
    }
    public static function setPageMeta_description($pageMeta_description) {
        self::$pageMeta_description = $pageMeta_description;
    }

    public static function getPageTitle() {
        return self::$pageTitle != null && self::$pageTitle != "" ? self::$pageTitle : DefineC::d()->getPage_title();
    }
    public static function setPageTitle($pageTitle) {
        self::$pageTitle = $pageTitle;
    }
	
	public static function getOGtitle() {
        return (string) self::$OGtitle;
    }
    public static function setOGtitle($OGtitle) {
        self::$OGtitle = (string) $OGtitle;
    }

    public static function getOGurl() {
        return (string) self::$OGurl;
    }
    public static function setOGurl($OGurl) {
        self::$OGurl = (string) $OGurl;
    }

    public static function getOGType() {
        return (string) self::$OGtype;
    }
    public static function setOGtype($OGtype) {
        self::$OGtype = (string) $OGtype;
    }

    public static function getOGimg() {
        if (!self::$OGimg) {
            self::$OGimg = HTTP_SERVER . '/' . DIR_IMG . '/fb.jpg';
        }

        return (string) self::$OGimg;
    }
    public static function setOGimg($OGimg) {
        self::$OGimg = (string) $OGimg;
    }

    public static function getOGdescription() {
        return (string) self::$OGdescription;
    }
    public static function setOGdescription($OGdescription) {
        self::$OGdescription = (string) $OGdescription;
    }

    public static function getArray_style() {
        return (array) self::$array_style;
    }
    public static function setArray_style(array $array_style) {
        self::$array_style = (array) $array_style;
    }

    public static function getArray_script() {
        return (array) self::$array_script;
    }
    public static function setArray_script(array $array_script) {
        self::$array_script = (array) $array_script;
    }

    public static function getGetPag() {
        return (array) self::$getPag;
    }
    public static function setGetPag(array $getPag) {
        self::$getPag = (array) $getPag;
    }

    public static function getIncludeFilter() {
        return (bool) self::$includeFilter;
    }
    public static function setIncludeFilter($includeFilter) {
        self::$includeFilter = (bool) $includeFilter;
    }

    public static function getIncludeLeft() {
        return (bool) self::$includeLeft;
    }
    public static function setIncludeLeft($includeLeft) {
        self::$includeLeft = (bool) $includeLeft;
    }

    public static function getIncludeLeftCat() {
        return (bool) self::$includeLeftCat;
    }
    public static function setIncludeLeftCat($includeLeftCat) {
        self::$includeLeftCat = (bool) $includeLeftCat;
    }

    public static function getIncludeLeftMyAcc() {
        return (bool) self::$includeLeftMyAcc;
    }
    public static function setIncludeLeftMyAcc($includeLeftMyAcc) {
        self::$includeLeftMyAcc = (bool) $includeLeftMyAcc;
    }

}