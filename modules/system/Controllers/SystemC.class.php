<?php

class SystemC {

    public static function controller() {
        switch (isset($_REQUEST['funcao']) ? ValidateU::antStr($_REQUEST['funcao']) : false) {
            case 'bkpDB': self::bkpDB(); exit();
            case 'bkpDelDB': self::bkpDelDB(); exit();
            case 'DeletarBKP': self::deletarBKP(); exit();
        }
    }

    private static function bkpDB() {
        try {
            DAO::bkp();
            self::setSucessMsg("BACKUP do banco de dados realizado com sucesso");
        }  catch (Exception $e) {
            self::setErrorMsg($e->getMessage());
        }

        header("Location: " . HTTP_SERVER . "/backupDBListVA");
    }

    private static function bkpDelDB() {
        try {
            SystemBO::checkOldBKPs();
            self::setSucessMsg("BACKUPs antigos deletados com sucesso");
        }  catch (Exception $e) {
            self::setErrorMsg($e->getMessage());
        }

        header("Location: " . HTTP_SERVER . "/" . SystemC::getPag());
    }

    private static function deletarBKP() {
        if (isset($_POST['file']) && is_array($_POST['file'])) {
            $array = array_unique($_POST['file']);
            try {
                foreach ($array as $value) {
                    SystemBO::deleteBKP($value);
                }
                SystemC::setSucessMsg('Arquivo(s) excluído(s) com sucesso');
            } catch (Exception $e) {
                SystemC::setErrorMsg($e->getMessage());
            }
        }

        header("Location: " . HTTP_SERVER . "/" . SystemC::getPag());
    }

    public static function setIconArray_status($key) {
        if ($key == SystemVO::STATUS_ATIVO) {
            return '<img src="' . self::imgSrcSys('ativo_icon.png') . '" class="this_tooltip" alt="Ativo" title="Ativo." />';
        } else if ($key == SystemVO::STATUS_INATIVO) {
            return '<img src="' . self::imgSrcSys('inativo_icon.png') . '" class="this_tooltip" alt="Inativo" title="Inativo." />';
        } else {
            return '<img src="' . self::imgSrcSys('pendente_icon.png') . '" class="this_tooltip" alt="Pendente" title="Pendente." />';
        }
    }

    public static function setPag() {
        $getPag = (isset($_GET['pag'])) ? $_GET['pag'] : GET_PAG_DEFAULT;
        return substr_count($getPag, '/') > 0 ? SystemVO::setGetPag(explode('/', $getPag)) : SystemVO::setGetPag(array($getPag));
    }

    public static function getPag($key = 0) {
        $array = SystemVO::getGetPag();
        $nice_url = DefineC::d()->getPage_nice_url() ? DefineC::d()->getPage_nice_url() : "000";
        return isset($array[$key]) && $array[$key] ? str_replace('-' . $nice_url, '', $array[$key]) : "0";
    }

    public static function getSERVER_PROTOCOL() {
        return (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https')) ? 'https' : 'http';
    }

    public static function getREQUEST_URI($url = null) {
        // return str_replace('?', '$', str_replace('&', '*', HTTP_REQUEST));
        $url = $url ? FormatU::removeHttp($url) : $url;
        return str_replace('?', '$', str_replace('&', '*', ($url ? $url : $_SERVER['REQUEST_URI'])));
    }

    public static function setREQUEST_URI($url, $removeFirstLetter = true) {
        // return self::getSERVER_PROTOCOL() . "://" . str_replace('$', '?', str_replace('*', '&', $url));
        $url = str_replace(PROJECT_NAME . '/', '', str_replace('$', '?', str_replace('*', '&', $url)));
        $url = self::isHomologationEnvironmentOnServer() ? str_replace('novo/', '', $url) : $url;
        return $removeFirstLetter ? substr($url, 1) : $url;
    }

    public static function setErrorMsg($msg) {
        $_SESSION[SystemVO::SESSION_MESSAGE] = SystemVO::CODE_ERROR_MESSAGE . ' ' . $msg;
    }

    public static function setSucessMsg($msg) {
        $_SESSION[SystemVO::SESSION_MESSAGE] = SystemVO::CODE_SUCESS_MESSAGE . ' ' . $msg;
    }

    public static function setInfoMsg($msg) {
        $_SESSION[SystemVO::SESSION_MESSAGE] = SystemVO::CODE_INFO_MESSAGE . ' ' . $msg;
    }

    public static function setWarningMsg($msg) {
        $_SESSION[SystemVO::SESSION_MESSAGE] = SystemVO::CODE_WARNING_MESSAGE . ' ' . $msg;
    }

    public static function setMsg(array $msg) {
        $_SESSION[SystemVO::SESSION_MESSAGE] = $msg;
    }

    private static function getMsg($type_msg) {
        switch ($type_msg) {
            case SystemVO::CODE_ERROR_MESSAGE: $class = 'alert-danger'; $m = 'Erro:'; break;
            case SystemVO::CODE_SUCESS_MESSAGE: $class = 'alert-success'; $m = ''; break;
            case SystemVO::CODE_INFO_MESSAGE: $class = 'alert-info'; $m = 'Informação:'; break;
            case SystemVO::CODE_WARNING_MESSAGE: $class = 'alert-warning'; $m = 'Atenção:'; break;
            default: die('No message type is corretly'); break;
        }

        return array($class, $m);
    }

    public static function return_msg() {
        if (!isset($_SESSION[SystemVO::SESSION_MESSAGE])) {
            return ;
        }

        if (is_array($_SESSION[SystemVO::SESSION_MESSAGE])) {
            foreach ($_SESSION[SystemVO::SESSION_MESSAGE] as $key => $value) {
                $msg = self::getMsg($key);
                echo $value ? '<div class="alert ' . $msg[0] . ' alert-dismissable fade in">'
                        . '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                        . '<strong>' . $msg[1] . '</strong> ' . $value . '.</</div>' : "";
            }
        } else {
            $type_msg = (int) substr($_SESSION[SystemVO::SESSION_MESSAGE], 0, 1);
            $msg = self::getMsg($type_msg);
            echo $msg[0] ? '<div class="alert ' . $msg[0] . ' alert-dismissable fade in">'
                    . '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                    . '<strong>' . $msg[1] . '</strong> ' . str_replace($type_msg . ' ', '', $_SESSION[SystemVO::SESSION_MESSAGE]) . '</div>'
                 : "";
        }

        unset($_SESSION[SystemVO::SESSION_MESSAGE]);
    }

    public static function printTitle($title) {
        echo '<div class="page-header"><h1>' . $title . '</h1></div>';
    }

    public static function addStyle(array $array_style, $print = false) {
        $array = array();
        foreach ($array_style as $value) {
            if ($value) {
                $array[] = $value;
            }
        }
        foreach (SystemVO::getArray_style() as $value) {
            if ($value) {
                $array[] = $value;
            }
        }
        $array = array_unique($array);
        SystemVO::setArray_style($array);

        if ($print) {
            self::printHTMLStyle();
			SystemVO::setArray_style(array());
        }
    }

    private static function printHTMLStyle() {
        foreach (SystemVO::getArray_style() as $value) {
            $isFoundFile = false;
            $isFoundFile2 = false;
            if (file_exists(DIR_CSS . '/' . $value . '.css')) {
                echo '<link href="' . HTTP_SERVER . '/' . DIR_CSS . '/' . $value . '.css" rel="stylesheet" type="text/css" />' . "\r\n";
                $isFoundFile = true;
            } else {
                foreach (_MODULES() as $module) {
                    if (file_exists(DIR_MODULES . '/' . $module . '/' . DIR_CSS . '/' . $value . '.css')) {
                        echo '<link href="' . HTTP_SERVER . '/' . DIR_MODULES . '/' . $module . '/' . DIR_CSS . '/' . $value . '.css" rel="stylesheet" type="text/css" />' . "\r\n";
                        $isFoundFile2 = true;
                        break;
                    }
                }
            }

            if (!$isFoundFile && !$isFoundFile2) {
                die ('Style File: ' . $value . '.css NOT FOUND');
            }
        }
    }

    public static function addScript(array $array_script, $print = false) {
        $array = array();
        foreach ($array_script as $value) {
            if ($value) {
                $array[] = $value;
            }
        }
        foreach (SystemVO::getArray_script() as $value) {
            if ($value) {
                $array[] = $value;
            }
        }
        $array = array_unique($array);
        SystemVO::setArray_script($array);

        if ($print) {
            self::printHTMLScript();
            SystemVO::setArray_script(array());
        }
    }

    private static function printHTMLScript() {
        foreach (SystemVO::getArray_script() as $value) {
            $path = DIR_JS . '/';
            $isFoundFile = false;
            $folders = array('configs', 'functions', 'plugins', 'validate');
            foreach ($folders as $subfolder) {
                if (file_exists($path . $subfolder . '/' . $value . '.js')) {
                    $path .= $subfolder . '/' . $value . '.js';
                    $isFoundFile = true;
                    break;
                } else if (file_exists($path . $subfolder . '/' . $value . '.js')) {
                    $path .= $subfolder . '/' . $value . '.php';
                    $isFoundFile = true;
                    break;
                }
            }
            if ($isFoundFile) {
                echo '<script type="text/javascript" src="' . HTTP_SERVER . '/' . $path . '"></script>' . "\r\n";
            } else {
                $isFoundFile2 = false;
                foreach (_MODULES() as $module) {
                    foreach ($folders as $subfolder) {
                        $path = DIR_MODULES . '/' . $module . '/' . DIR_JS . '/' . $subfolder . '/' . $value;
                        if (file_exists($path . '.js')) {
                            $path .= '.js';
                            $isFoundFile2 = true;
                            break;
                        } else if (file_exists($path . '.php')) {
                            $path .= '.php';
                            $isFoundFile2 = true;
                            break;
                        }
                    }
                    if ($isFoundFile2) {
                        break;
                    }
                }
                if ($isFoundFile2) {
                    echo '<script type="text/javascript" src="' . HTTP_SERVER . '/' . $path . '"></script>' . "\r\n";
                } else {
                    die ('Script File: ' . $value . ' NOT FOUND');
                }
            }
        }
    }

    public static function addAnalytics() {
        if (DefineC::d()->getPage_analytics_code() != "" && !is_null(DefineC::d()->getPage_analytics_code())) {
            echo "<script type=\"text/javascript\">
                    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                    ga('create', '" . DefineC::d()->getPage_analytics_code() . "', 'auto');
                    ga('send', 'pageview');
                  </script>";
        }
    }

    public static function dateTimeISO() {
        return date("Y-m-d H:i:s");
    }

    /**
    * @param string $pag ; default atual getPag()
    */
    public static function redirect($pag = NULL) {
        ToolsT::headerLocation(HTTP_SERVER . '/' . ($pag ? $pag : self::getPag()));
        exit();
    }
    
    public static function imgSrc($img, $subfolder = null) {
        return HTTP_SERVER . '/' . DIR_IMG . '/' . ($subfolder ? $subfolder . '/' : '') . $img;
    }
    
    public static function imgSrcSys($img) {
        return HTTP_SERVER . '/' . DIR_IMG_SYSTEM . '/' . $img;
    }
    
    public static function link($pagSomenteEnadaMais, $qualquerOutraCoisaaMaisnaURL = null) {
        return HTTP_SERVER . '/' . $pagSomenteEnadaMais . (DefineC::d()->getPage_nice_url() ? '-' . DefineC::d()->getPage_nice_url() : "") . '/' . $qualquerOutraCoisaaMaisnaURL;
    }
    
    public static function link_($href) {
        return HTTP_SERVER . '/' . $href . '/';
    }
    
    public static function isDevelopmentAmbient() {
        return strpos($_SERVER['HTTP_HOST'], 'localhost') !== false;
    }
    
    public static function isHomologationEnvironmentOnServer() {
        return strpos($_SERVER['REQUEST_URI'], '/novo') !== false ;
    }
    
    public static function isHomologationEnvironment() {
        return self::isHomologationEnvironmentOnServer();
    }
    
    public static function isMobile($forceMobile = FALSE) {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            $_SESSION['mobile'] = false;
        } else {
            $url = $_SERVER['HTTP_HOST'] == 'm.' . DOMAIN_NAME;

            $pagMobile_ = strcmp(str_replace('/' . PROJECT_NAME, '', $_SERVER['REQUEST_URI']), '/mobile') == 0 ||
                          strcmp(str_replace('/' . PROJECT_NAME, '', $_SERVER['REQUEST_URI']), '/mobile/') == 0 ? true : false;
            $pagDesktop = strcmp(str_replace('/' . PROJECT_NAME, '', $_SERVER['REQUEST_URI']), '/desktop') == 0 ||
                          strcmp(str_replace('/' . PROJECT_NAME, '', $_SERVER['REQUEST_URI']), '/desktop/') == 0 ? true : false;

            if (!isset($_SESSION['mobile']) || $forceMobile || $url || $pagMobile_ || $pagDesktop) {
                if (($forceMobile || $url || $pagMobile_ || MobileU::mobile_device_detect()) && !$pagDesktop) {
                    $_SESSION['mobile'] = true;
                } else {
                    $_SESSION['mobile'] = false;
                }
            }
        }
        return (bool) $_SESSION['mobile'];
    }
    
    public static function issetModule($name) {
        return in_array($name, _MODULES());
    }

}