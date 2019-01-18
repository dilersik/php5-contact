<?php

class ValidateU {

    public static function isAddress($str) {
        return self::alphaNumeric4($str) && self::vltStr($str, 1, 150);
    }

    public static function isAddress_number($number) {
        return $number > 0 && $number < 100000;
    }

    public static function alpha($string) {
        return !preg_match('/[^a-zA-ZáÁãÃâÂàÀéÉêÊíÍóÓõÕôÔúÚüÜçÇ ]/', $string);
    }

    public static function alphaNumeric($string) {
        return !preg_match('/[^a-zA-Z0-9-_.]/', $string);
    }

    public static function alphaNumeric2($string) {
        return !preg_match('/[^a-zA-Z0-9áÁãÃâÂàÀéÉêÊíÍóÓõÕôÔúÚüÜçÇ ]/', $string);
    }

    public static function alphaNumeric3($string) {
        return !preg_match('/[^a-zA-Z0-9-.]/', $string);
    }

    public static function alphaNumeric4($string) {
        return !preg_match("/[^a-zA-Z0-9áÁãÃâÂàÀéÉêÊíÍóÓõÕôÔúÚüÜçÇ,\&().\-_+ ]/", str_replace('/', '', $string));
    }

    public static function antStr($string, $ALLOWABLE_TAGS = null) {
        $string = get_magic_quotes_gpc() ? stripslashes($string) : $string;
        $string = str_replace("\r\n", '', $string);
        return trim(strip_tags($string, $ALLOWABLE_TAGS));
    }
    
    public static function cardIsValid($cardNumber) {
        $number = substr($cardNumber, 0, -1);
        $doubles = [];

        for ($i = 0, $t = strlen($number); $i < $t; ++$i) {
            $doubles[] = substr($number, $i, 1) * ($i % 2 == 0 ? 2 : 1);
        }

        $sum = 0;

        foreach ($doubles as $double) {
            for ($i = 0, $t = strlen($double); $i < $t; ++$i) {
                $sum += (int) substr($double, $i, 1);
            }
        }

        return substr($cardNumber, -1, 1) == (10 - $sum % 10) % 10;
    }
    
    public static function isCel($cel) {
//        return preg_match('/^[6-9][0-9]{3}[0-9]{4,5}$/', FormatU::int($cel));
        return self::isNumber($cel) && self::vltStr($cel, 8, 20);
    }

    public static function isCEP($cep) {
        return preg_match('/^[0-9]{5}[0-9]{3}$/', FormatU::int($cep));
    }

    public static function isCNPJ($cnpj) {
        $cnpj = FormatU::int($cnpj);
	if (strlen($cnpj) != 14) {
            return false;
        }
        $calcular = 0;
        $calcularDois = 0;
        for ($i = 0, $x = 5; $i <= 11; $i ++, $x --) {
            $x = ($x < 2) ? 9 : $x;
            $number = substr($cnpj, $i, 1);
            $calcular += $number * $x;
        }
        for ($i = 0, $x = 6; $i <= 12; $i ++, $x --) {
            $x = ($x < 2) ? 9 : $x;
            $numberDois = substr($cnpj, $i, 1);
            $calcularDois += $numberDois * $x;
        }
        $digitoUm = (($calcular % 11) < 2) ? 0 : 11 - ($calcular % 11);
        $digitoDois = (($calcularDois % 11) < 2) ? 0 : 11 - ($calcularDois % 11);

        if ($digitoUm <> substr($cnpj, 12, 1) || $digitoDois <> substr($cnpj, 13, 1)) {
            return false;
        }

        return true;
    }

    public static function isCodObjCorreio($str) {
        return strlen($str) == 13 && str_word_count($str, 0, '0123456789') == 1;
    }

    public static function isCPF($cpf) {
        $cpf = FormatU::int($cpf);
        if (strlen($cpf) != 11) {
            return false;
        }
        $digitoUm = 0;
        $digitoDois = 0;
        for ($i = 0, $x = 10; $i <= 8; $i ++, $x --) {
            $digitoUm += $cpf[$i] * $x;
        }
        for ($i = 0, $x = 11; $i <= 9; $i ++, $x --) {
            if (str_repeat($i, 11) == $cpf) {
                return false;
            }
            $digitoDois += $cpf[$i] * $x;
        }
        $calculoUm = (($digitoUm % 11) < 2) ? 0 : 11 - ($digitoUm % 11);
        $calculoDois = (($digitoDois % 11) < 2) ? 0 : 11 - ($digitoDois % 11);
        if ($calculoUm <> $cpf[9] || $calculoDois <> $cpf[10]) {
            return false;
        }

        return true;
    }

    public static function isDate($date, $format = 'YYYY-MM-DD') {
        switch (strtoupper($format)) {
            case 'YYYY/MM/DD': case 'YYYY-MM-DD':
                list($y, $m, $d) = preg_split('/[-\.\/ ]/', $date);
                break;

            case 'YYYY/DD/MM': case 'YYYY-DD-MM':
                list($y, $d, $m) = preg_split('/[-\.\/ ]/', $date);
                break;

            case 'DD-MM-YYYY': case 'DD/MM/YYYY':
                list($d, $m, $y) = preg_split('/[-\.\/ ]/', $date);
                break;

            case 'MM-DD-YYYY': case 'MM/DD/YYYY':
                list($m, $d, $y) = preg_split('/[-\.\/ ]/', $date);
                break;

            case 'YYYYMMDD':
                $y = substr($date, 0, 4);
                $m = substr($date, 4, 2);
                $d = substr($date, 6, 2);
                break;

            case 'YYYYDDMM':
                $y = substr($date, 0, 4);
                $d = substr($date, 4, 2);
                $m = substr($date, 6, 2);
                break;

            default: throw new Exception("Formato de data inválido"); break;
        }
        return checkdate($m, $d, $y);
    }

    public static function isDDD($ddd) {
        return preg_match("/^([1][0]|[1-9][1-9])$/", $ddd);
    }

    public static function isDistrict($str) {
        return self::alphaNumeric4($str) && self::vltStr($str, 2, 80);
    }

    public static function isEAN13($number) {
        $sum = 0;

        for ($i = 0; $i < 12; $i++) {
            $sum += ( $number[$i] * ( ( $i & 1 ) ? 3 : 1 ) );
        }

        $fullNumber = sprintf('%s%u', $number, ( ( 1 - ( ( $sum / 10 ) - (int) ( $sum / 10 ) ) ) * 10));

        return substr((string) $fullNumber, -1) == substr((string) $number, -1);
    }
    
    public static function isFacebookLink($validUrl) {
        $fbUrlCheck = '/^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/';
	$secondCheck = '/home((\/)?\.[a-zA-Z0-9])?/';
	
	return preg_match($fbUrlCheck, $validUrl) == 1 && preg_match($secondCheck, $validUrl) == 0;
    }

    public static function isEmail($email) {
        return self::vltStr($email, 6, 100) && preg_match('/^(?!(?>(?1)"?(?>\\\[ -~]|[^"])"?(?1)){255,})(?!(?>(?1)"?(?>\\\[ -~]|[^"])"?(?1)){65,}@)((?>(?>(?>((?>(?>(?>\x0D\x0A)?[	 ])+|(?>[	 ]*\x0D\x0A)?[	 ]+)?)(\((?>(?2)(?>[\x01-\x08\x0B\x0C\x0E-\'*-\[\]-\x7F]|\\\[\x00-\x7F]|(?3)))*(?2)\)))+(?2))|(?2))?)([!#-\'*+\/-9=?^-~-]+|"(?>(?2)(?>[\x01-\x08\x0B\x0C\x0E-!#-\[\]-\x7F]|\\\[\x00-\x7F]))*(?2)")(?>(?1)\.(?1)(?4))*(?1)@(?!(?1)[a-z0-9-]{64,})(?1)(?>([a-z0-9](?>[a-z0-9-]*[a-z0-9])?)(?>(?1)\.(?!(?1)[a-z0-9-]{64,})(?1)(?5)){0,126}|\[(?:(?>IPv6:(?>([a-f0-9]{1,4})(?>:(?6)){7}|(?!(?:.*[a-f0-9][:\]]){7,})((?6)(?>:(?6)){0,5})?::(?7)?))|(?>(?>IPv6:(?>(?6)(?>:(?6)){5}:|(?!(?:.*[a-f0-9]:){5,})(?8)?::(?>((?6)(?>:(?6)){0,3}):)?))?(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])(?>\.(?9)){3}))\])(?1)$/isD', $email);
    }

    public static function isEmbedYoutube($url) {
        return preg_match("/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/", $url);
    }

    public static function isHour($hora) {
	if (strlen($hora) > 8) {
            $hora = substr($hora, 11, 2) . ':' . substr($hora, 14, 2) . ':' . substr($hora, 17, 2);
        }

        return preg_match('/^([0-1][0-9]|[2][0-3]):[0-5][0-9]:[0-5][0-9]$/', $hora);
    }

    public static function isInscricaoEstadual($str) {
        return self::alphaNumeric3($str) && self::vltStr($str, 4, 20);
    }

    public static function isName($name) {
        return self::alpha($name) && self::vltStr($name, 2, 20, 1, 1);
    }    
    public static function isFullName($name) {
        return self::alpha($name) && self::vltStr($name, 2, 70, 2, 8);
    }
    public static function isLastName($name) {
        return self::alpha($name) && self::vltStr($name, 2, 50, 1, 7);
    }

    public static function isLegend($txt) {
        return strlen($txt) <= 100;
    }
    
    public static function isLetterOnly_($string) {
        return !preg_match('/[^a-zA-Z-]/', $string);
    }

    public static function isMetaDescription($str) {
        return self::vltStr($str, 2, 255, 5);
    }

    public static function isMetaKeywords($str) {
        return self::vltStr($str, 2, 255, 2);
    }

    public static function isNextel($str) {
        return strlen($str) <= 30;
    }

    public static function isNomeFantasia($str) {
        return self::alphaNumeric4($str) && self::vltStr($str, 2, 60);
    }
    
    public static function isNumber($str) {
        return !preg_match('/[^0-9]/', $str);
    }

    public static function isPWD($pwd, $pwd_cpy = false) {
        if ($pwd_cpy && $pwd != $pwd_cpy) {
            return false;
        }
        return self::vltStr($pwd, 6, 20);
    }

    public static function isRazaoSocial($str) {
        return self::alphaNumeric4($str) && self::vltStr($str, 5, 60, 2);
    }

    public static function isRG($str) {
        return self::alphaNumeric3($str) && self::vltStr($str, 4, 15);
    }
    
    public static function isPhoneNumber($str) {
        return self::vltStr($str, 10, 25);
    }

    public static function isStringName($str) {
        return self::alphaNumeric4($str) && self::vltStr($str, 1, 50);
    }

    public static function isTel($tel) {
//        return preg_match('/^[2-9][0-9]{3}[0-9]{4}$/', $tel);
        return self::isNumber($tel) && self::vltStr($tel, 8, 20);
    }

    public static function isText($text) {
        return strlen($text) <= 65535;
    }

    public static function isTitle($title) {
        return self::vltStr($title, 2, 100);
    }

    public static function isURL($url) {
        return preg_match('|^http(s)?://[a-z0-9-]+(\.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url) && strlen($url) <= 200;
    }

    public static function isUsername($username) {
        return self::alphaNumeric($username) && self::vltStr($username, 1, 20);
    }

    public static function isValue($val) {
        return !is_null($val) && $val != "" && ($val < 0 || $val > 0);
    }

    public static function isVarchar($str) {
        return self::vltStr($str, 2, 255);
    }

    public static function isYear($year) {
        return $year > 1900 && $year < 2156;
    }

    public static function mimeType($ext) {
        switch ($ext) {
            case 'bmp': return 'image/bmp';
            case 'doc': return 'application/msword';
            case 'docx': return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            case 'gif': return 'image/gif';
            case 'ico': return 'image/ico';
            case 'jpe': case 'jpg': case 'jpeg': return 'image/jpeg';
            case 'pdf': return 'application/pdf';
            case 'pps': case 'ppt': return 'application/vnd.ms-powerpoint';
            case 'ppsx': return 'application/vnd.openxmlformats-officedocument.presentationml.slideshow';
            case 'pptx': return 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
            case 'xls': return 'application/vnd.ms-excel';
            case 'xlsx': return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            case 'sql': return "text/plan";
            default: die("mime type not found");
        }
    }

    public static function isNameOf($str) {
        return self::alphaNumeric4($str) && strlen($str) < 50;
    }

    public static function range($val, $min, $max) {
        return $val >= $min && $val <= $max;
    }

    public static function timeRange($timeIn, $timeEnd) {
        if (strtotime($timeEnd) < strtotime($timeIn)) {
            return false;
        }
        return true;
    }

    public static function vltFile($file, $ext) {
        return preg_match('/^(' . $ext . ')$/', $file);
    }

    public static function vltStr($str, $minlength, $maxlength, $minwords = 0, $maxwords = 0) {
        $strlen = strlen($str);
        if ($strlen < $minlength) {
            return false;
        }
        if ($maxlength && $strlen > $maxlength) {
            return false;
        }
        if ($minwords || $maxwords) {
            $words = str_word_count((string) $str, 0, 'ZáÁãÃâÂàÀéÉêÊíÍóÓõÕôÔúÚüÜçÇ');
            if ($minwords && $words < $minwords) {
                return false;
            }
            if ($maxwords && $words > $maxwords) {
                return false;
            }
        }
        return true;
    }

}