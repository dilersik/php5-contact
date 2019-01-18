<?php

class ToolsT {

    public static function calcAge($dateBirth) {
        list($ano, $mes, $dia) = explode('-', $dateBirth);
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);
        return floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
    }

    public static function calcFirstDayUtilOfWeek($date) {
        while (date('N', strtotime($date)) != 1) {
            $date = self::calcFirstDayUtilOfWeek(date('Y-m-d', strtotime($date . ' -1days')));
        }

        return $date;
    }

    public static function calcLastDayUtilOfWeek($date) {
        while (date('N', strtotime($date)) != 5) {
            $date = self::calcLastDayUtilOfWeek(date('Y-m-d', strtotime($date . ' +1days')));
        }

        return $date;
    }

    public static function calcIni($quantidade, $pagina) {
        $pagina = $pagina > 0 ? $pagina : 1;
        return $quantidade * $pagina - $quantidade;
    }

    public static function calcValueDiscount($value, $percem) {
        return $value - $value * ($percem / 100);
    }

    public static function calcDiscount($value, $percem) {
        return round($value * ($percem / 100), 2);
    }

    public static function calcPercent($val, $total) {
        return (100 * $val) / ($total ? $total : 1);
    }

    public static function cleanSESSION(array $arraySESSION) {
        foreach ($arraySESSION as $value) {
            if (isset($_SESSION[$value])) {
                unset($_SESSION[$value]);
            }
        }
    }

    public static function cleanCOOKIE(array $arrayCOOKIE, $time, $path = '/') {
        foreach ($arrayCOOKIE as $value) {
            if (isset($_COOKIE[$value])) {
                setcookie($value, '', time() - $time, $path);
            }
        }
    }

    public static function createToken($tamanho = 5, $maiusculas = true, $numeros = true, $minusculas = false, $simbolos = false) {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@_%&*-+';
        $retorno = '';
        $caracteres = '';

        if ($minusculas) {
            $caracteres .= $lmin;
        }
        if ($maiusculas) {
            $caracteres .= $lmai;
        }
        if ($numeros) {
            $caracteres .= $num;
        }
        if ($simbolos) {
            $caracteres .= $simb;
        }

        for ($n = 1; $n <= $tamanho; $n ++) {
            $rand = mt_rand(1, strlen($caracteres));
            $retorno .= $caracteres[$rand - 1];
        }
        return $retorno;
    }

    public static function diffDate($d1, $d2, $return = 'y', $sep = '-') {
        $hora1 = substr($d1, 11, 2);
        $minuto1 = substr($d1, 14, 2);
        $segundo1 = substr($d1, 17, 2);
        $hora2 = substr($d2, 11, 2);
        $minuto2 = substr($d2, 14, 2);
        $segundo2 = substr($d2, 17, 2);

        $d1 = substr($d1, 0, 10);
        $d2 = substr($d2, 0, 10);
        $d1 = explode($sep, $d1);
        $d2 = explode($sep, $d2);
        switch (strtoupper($return)) {
            case 'Y': $X = 31536000; break;
            case 'M': $X = 2592000; break;
            case 'D': $X = 86400; break;
            case 'H': $X = 3600; break;
            case 'MI': $X = 60; break;
            default: $X = 1; break;
        }

        return floor((mktime($hora2, $minuto2, $segundo2, $d2[1], $d2[2], $d2[0]) - mktime($hora1, $minuto1, $segundo1, $d1[1], $d1[2], $d1[0]) ) / $X);
    }

    /**
    * @param 0000-00-00 <p>
    * @return int in days
    */
    public static function diffDate2($d1, $d2) {
        $dtInArray = explode('/', date('d/m/Y', strtotime($d1)));
        $dtIn = mktime(0, 0, 0, $dtInArray[1], $dtInArray[0], $dtInArray[2]);
        $dtFnArray = explode('/', date('d/m/Y', strtotime($d2)));
        $dtFn = mktime(0, 0, 0, $dtFnArray[1], $dtFnArray[0], $dtFnArray[2]);
        return (int) floor(($dtFn - $dtIn) / (60 * 60 * 24));
    }
    
    /**
    * @param string $pasta deve ter / no final
    * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
    */
    public static function delAllFilesFromFolder($pasta) {
        if (!is_dir($pasta)) {
            return false;
        } else {
            $diretorio = dir($pasta);
            while ($arquivo = $diretorio->read()) {
                if (($arquivo != '.') && ($arquivo != '..')) {
                    unlink($pasta . $arquivo);
                }
            }
            $diretorio->close();
        }
        
        return true;
    }

    public static function downloadForce($file, $name = null, $deleteAfterDown = false) {
        $ext = FormatU::getExt($file);
        if ($ext == 'php' || $ext == 'html' || $ext == 'js' || $ext == 'css') {
            exit();
        }
        if (!file_exists($file)) {
            die("file not found");
        }
        header('Content-Type: application/save');
        header('Content-Length: ' . filesize($file));
        header('Content-Disposition: attachment; filename=' . basename($name ? FormatU::toAlphaNumeric($name) . '.' . $ext : $file));
        readfile($file);

        if ($deleteAfterDown) {
            unlink($file);
        }
    }

    public static function getBrowser() {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $matched = null;
        if (preg_match('|MSIE ([0-9].[0-9]{1,2})|', $useragent, $matched)) {
            $browser_version = $matched[1];
            $browser = 'IE';
        } else if (preg_match('|Opera/([0-9].[0-9]{1,2})|', $useragent, $matched)) {
            $browser_version = $matched[1];
            $browser = 'Opera';
        } else if (preg_match('|Firefox/([0-9\.]+)|', $useragent, $matched)) {
            $browser_version = $matched[1];
            $browser = 'Firefox';
        } else if (preg_match('|Chrome/([0-9\.]+)|', $useragent, $matched)) {
            $browser_version = $matched[1];
            $browser = 'Chrome';
        } else if (preg_match('|Safari/([0-9\.]+)|', $useragent, $matched)) {
            $browser_version = $matched[1];
            $browser = 'Safari';
        } else {
            // browser not recognized!
            $browser_version = 0;
            $browser = 'other';
        }

        return array($browser, $browser_version);
    }

    public static function headerLocation($url) {
        header('Location: ' . $url);
        exit();
    }

    public static function paginator($numTotal, $quantidade, $pagina, $url, $complemento = '', $sep = true, $div_class = 'pagination', $exibir = 3) {
        if ($numTotal <= $quantidade || !$quantidade) {
            return ;
        }

        $pagina = (int) ($pagina > 0 ? $pagina : 1);
        $totalPagina = ceil($numTotal / $quantidade);
        echo '<ul class="' . $div_class . ' pull-right">';
        echo '<li><span>Página ' . $pagina . ' de ' . $totalPagina . '</span></li>';
        echo '<li>';
//        echo '<a href="' . $url . ($sep ? '/pagina/1' : '&amp;pagina=1') . $complemento . '">Primeira</a>';
        echo '<a href="' . $url . ($sep ? '/pagina/' : '&amp;pagina=') . ((($pagina - 1) == 0) ? 1 : $pagina - 1) . $complemento . '">&laquo; Anterior</a>';
        echo '</li>';
        for ($i = $pagina - $exibir; $i <= $pagina - 1; $i ++) {
            if ($i > 0) {
                echo '<li><a href="' . $url . ($sep ? '/pagina/' : '&amp;pagina=') . $i . $complemento . '">' . $i . '</a></li>';
            }
        }
        echo '<li class="active"><a>' . $pagina . '</a></li>';
        for ($i = $pagina + 1; $i < $pagina + $exibir; $i ++) {
            if ($i <= $totalPagina) {
                echo '<li><a href="' . $url . ($sep ? '/pagina/' : '&amp;pagina=') . $i . $complemento . '">' . $i . '</a></li>';
            }
        }
        echo '<li>';
        echo '<a href="' . $url . ($sep ? '/pagina/' : '&amp;pagina=') . ((($pagina + 1) >= $totalPagina) ? $totalPagina : $pagina + 1) . $complemento . '">Próxima &raquo;</a>';
//        echo '<a href="' . $url . ($sep ? '/pagina/' : '&amp;pagina=') . $totalPagina . $complemento . '">Última</a>';
        echo '</li></ul>';
    }

    public static function simple_curl($url, $post = array(), $get = array(), $curlopt_header = null) {
        $url = explode('?', $url, 2);
        if (count($url) === 2) {
            $temp_get = array();
            parse_str($url[1], $temp_get);
            $get = array_merge($get, $temp_get);
        }

        $ch = curl_init($url[0] . "?" . http_build_query($get));
        if ($curlopt_header) {
            curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => array($curlopt_header), 
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_VERBOSE => 1));
//            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
//            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        }
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        return curl_exec($ch);
    }
    
    public static function renameFile($path_file, $file, $getExt) {
        $x = null;
        if (file_exists($path_file . $file . $getExt)) {
            $x = 1;
            while (file_exists($path_file . $file . $x . $getExt)) {
                $x ++;
            }
        }
        
        return $file . $x;
    }
    
    public static function unlinkFile($file) {
        if (file_exists($file)) {
            unlink($file);
        }
    }

}