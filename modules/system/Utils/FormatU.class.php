<?php

class FormatU {

    public static function breakLine($str) {
        return self::breakLineQ($str);
    }
    
    public static function breakLineQ($str, $quebra = "\r\n") {
        return str_replace('<br />', $quebra, $str);
    }
    
    public static function breakLineNoLine($str) {
        return self::breakLineQ($str, null);
    }

    public static function by2M($size) {
        $filesizename = array(' Bytes', ' KB', ' MB', ' GB', ' TB', ' PB', ' EB', ' ZB', ' YB');
        return $size ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
    }

    public static function createCleanArray($string, $delimiter = ',') {
        $newArray = array();
        foreach (explode($delimiter, $string) as $value) {
            $word = ValidateU::antStr($value);
            if ($word && !in_array($word, $newArray)) {
                $newArray[] = $word;
            }
        }

        return $newArray;
    }

    public static function cryptPwd($pwd) {
        return hash('whirlpool', $pwd);
    }

    public static function cutText($texto, $limite, $quebra = false, $points = ' ...') {
        $texto = trim(self::htmlEntityDecode(strip_tags($texto)));
        if (strlen($texto) <= $limite) {
            return $texto;
        }
        if ($quebra) {
            $texto = trim(substr($texto, 0, $limite)) . $points;
        } else {
            $texto = trim(substr($texto, 0, strrpos(substr($texto, 0, $limite), ' '))) . $points;
        }

        return $texto;
    }
    
    public static function cutTextSemDo($texto, $limite) {
        return self::cutText($texto, $limite, true, null);
    }

    public static function dateBRToIso($date) {
        $date = self::int($date);
        return substr($date, 4, 4) . '-' . substr($date, 2, 2) . '-' . substr($date, 0, 2);
    }
    
    public static function dateFormat_ptBR($strDate, $datetype) {
        $strDateToTime = strtotime($strDate);

	switch ($datetype) {
            case 'd': return date("d", $strDateToTime);
            case 'day': return date("d", $strDateToTime) . " " . SystemVO::getArray_daysOfWeek(date('w', $strDateToTime));
            case 'dateISO': return date('Y-m-d', $strDateToTime);
            case 'iso': return date('Y-m-d H:i:s', $strDateToTime);
            case 'month': return SystemVO::getArray_monthsOfYear(date('n', $strDateToTime));
            case 'year': return date('Y', $strDateToTime);
            case 'date': return date('d/m/Y', $strDateToTime);
            case 'datetime': return date('d/m/Y H:i:s', $strDateToTime);
            case 'datetime2': return date('d/m/Y H:i', $strDateToTime);
            case 'mYear': return date('m', $strDateToTime) . '/' . date('Y', $strDateToTime);
            case 'monthYear': return SystemVO::getArray_monthsOfYear(date('n', $strDateToTime)) . ' de ' . date('Y', $strDateToTime);
            case 'time': return date('H:i:s', $strDateToTime);
            case 'semiFull':
                return date('d', $strDateToTime) . ' de ' . SystemVO::getArray_monthsOfYear(date('n', $strDateToTime)) . ' de ' . date('Y', $strDateToTime) . ' às ' . date('H:i', $strDateToTime);
            case 'full':
                return SystemVO::getArray_daysOfWeek(date('w', $strDateToTime)) . ', ' . date('d', $strDateToTime) . ' de ' . SystemVO::getArray_monthsOfYear(date('n', $strDateToTime)) . ' de ' . date('Y', $strDateToTime) . ' às ' . date('H:i:s', $strDateToTime);
            case 'full2':
                return SystemVO::getArray_daysOfWeek(date('w', $strDateToTime)) . ', ' . date('d', $strDateToTime) . ' de ' . SystemVO::getArray_monthsOfYear(date('n', $strDateToTime)) . ' de ' . date('Y', $strDateToTime);
            case 'dayMonthYear':
                return date('d', $strDateToTime) . " de " . SystemVO::getArray_monthsOfYear(date('n', $strDateToTime)) . " de " . date('Y', $strDateToTime);
            case 'dayMon':
                return date('d', $strDateToTime) . " " . substr(SystemVO::getArray_monthsOfYear(date('n', $strDateToTime)), 0, 3);
            default: return date($datetype, $strDateToTime);
	}
    }

    public static function extractDate($date, $dateType, $extract) {
        if ($dateType == 'dmY') {
            $day = substr($date, 0, 2);
            $month = substr($date, 3, 2);
            $year = substr($date, 6, 4);
            $hour = substr($date, 11, 2);
            $minut = substr($date, 14, 2);
            $second = substr($date, 17, 2);
        } else if ($dateType == 'dM') {
            $day = substr($date, 0, 2);
            $month = substr($date, 3, 2);
        }

        switch ($extract) {
            case 'd': return $day;
            case 'm': return $month;
            case 'Y': return $year;
            case 'H': return $hour;
            case 'i': return $minut;
            case 's': return $second;
        }
    }

    public static function extractDomain($domain) {
        $matches = null;
	if (preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $domain, $matches)) {
            return $matches['domain'];
	}
        return $domain;
    }

    public static function float($str, $decimals = 2, $moeda = 'real') {
        if ($moeda == 'real') {
            $str = str_replace('.', '', $str);
            $str = str_replace(',', '.', $str);
        } else if ($moeda == 'dolar') {
            $str = str_replace(',', '', $str);
        }
        $str = preg_replace('/[^-.0-9]/', '', $str);

        return (float) number_format((float) $str, $decimals, '.', '');
    }

    public static function formatStr($string, $tipo) {
	$string = self::int($string);
        $length = strlen($string);
	switch ($tipo) {
            case 'fone': $string = '(' . substr($string, 0, 2) . ') ' . substr($string, 2, ($length > 10 ? 5 : 4)) . '.' . substr($string, ($length > 10 ? 7 : 6)); break;
            case 'cep': $string = substr($string, 0, 5) . '-' . substr($string, 5, 3); break;
            case 'cpf': $string = substr($string, 0, 3) . '.' . substr($string, 3, 3) . '.' . substr($string, 6, 3) . '-' . substr($string, 9, 2); break;
            case 'cnpj': $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) . '.' . substr($string, 5, 3) . '/' . substr($string, 8, 4) . '-' . substr($string, 12, 2); break;
            case 'rg': $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) . '.' . substr($string, 5, 3); break;
	}
	return $string;
    }

    public static function getEmbedYoutube($url) {
        $output = null;
        if (preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $output)) {
            return $output[0];
        }
        return false;
    }

    public static function getYouTubeID($str) {
        $matches = null;
        preg_match_all("/youtu(be.com|.b)(\/embed\/|\/v\/|\/watch\\?v=|e\/)(.{11})/", $str, $matches);
        if (!empty($matches[3])) {
            $codigos_unicos = array();
            $quantidade_videos = count($matches[3]);
            foreach ($matches[3] as $code) {
                if (!in_array($code, $codigos_unicos)) {
                    array_push($codigos_unicos, $code);
                }
            }
            return $codigos_unicos[0];
        }

        return false;
    }

    public static function getExt($file) {
        $file = explode(".", $file);
        $ext = strtolower(end($file));
        $file = explode('?', $ext);
        if ($file) {
            return $file[0];
        }
        return $ext;
    }
    
    public static function getHttpProtocolStr($str) {
        return strpos($str, 'https') === false ? 'http' : 'https';
    }

    public static function hexToRGB($hex) {
        $hex = str_replace("#", "", $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return array($r, $g, $b);
    }

    public static function htmlEntityDecode($str) {
        return html_entity_decode($str, ENT_QUOTES);
    }

    public static function int($str) {
        return preg_replace('/[^0-9]/', '', $str);
    }

    public static function invertDate($date, $sep = '/', $junt = '-') {
        return implode($junt, array_reverse(explode($sep, $date)));
    }

    public static function numberFloatCen($number, $decimals = 2) {
        return number_format($number, $decimals, '.', '');
    }

    public static function moneyFormat_ptBR($number) {
        return 'R$ ' . number_format($number, 2, ',', '.');
    }

    public static function numberFormatDec_ptBR($number, $prefix = '', $suffix = '', $boolDec0 = false) {
        $dec = ($boolDec0 && (int) $number == $number ? 0 : 1);
        return $prefix . number_format($number, $dec, ',', '.') . $suffix;
    }

    public static function numberFormatCen_ptBR($number, $prefix = '', $suffix = '', $boolDec0 = false) {
        $dec = ($boolDec0 && (int) $number == $number ? 0 : 2);
        return $prefix . number_format($number, $dec, ',', '.') . $suffix;
    }

    public static function numberFormatInt_ptBR($n) {
        return number_format($n, 0, '', '.');
    }

    public static function numberFormatMil_ptBR($number, $prefix = '', $suffix = '', $boolDec0 = false) {
        $dec = ($boolDec0 && (int) $number == $number ? 0 : 3);
        return $prefix . number_format($number, $dec, ',', '.') . $suffix;
    }

    public static function pre($obj) {
        echo "<pre>";
        print_r($obj);
        echo "</pre>";
    }
    
    public static function putVirgulaAndE(array $names, $lastChar = '.') {
        $_names = array_pop($names);
        if (count($names) > 0) {
            return implode(', ', $names) . ' e ' . $_names . $lastChar;
        }

        return $_names . $lastChar;
    }
    
    public static function removeHttp($str) {
        return str_replace('http://', '', str_replace('https://', '', $str));
    }
    
    public static function tucWords($str) {
        return $str ? ucwords(self::tlower($str)) : null;
    }

    public static function tupper($str) {
        return $str ? mb_strtoupper($str, 'utf-8') : null;
    }
    
    public static function tlower($str) {
        return $str ? mb_strtolower($str, 'utf-8') : null;
    }
    
    public static function toAlphaNumeric($str) {
        $clear_array = array(
            "," => "", "!" => "", "#" => "", "%" => "", "¬" => "", "{" => "", "}" => "",
            "^" => "", "´" => "", "`" => "", "" => "", "/" => "", ";" => "", ":" => "", "?" => "",
            "¹" => "1", "²" => "2", "³" => "3", "ª" => "a", "º" => "o", "ü" => "u",
            "ä" => "a", "ï" => "i", "ö" => "o", "ë" => "e", "$" => "s", "ÿ" => "y", "<" => "",
            ">" => "", "[" => "", "]" => "", "&" => "e", " " => "-", "+" => "-", "?" => '', '"' => "",

            'á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'â' => 'a', 'Â' => 'A', 'ã' => 'a', 'Ã' => 'A',
            'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ê' => 'e', 'Ê' => 'E',
            'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I',
            'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ô' => 'o', 'Ô' => 'O',
            'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'û' => 'u', 'Û' => 'U',
            'ç' => 'c', 'Ç' => 'C'
        );

        foreach ($clear_array as $key => $val) {
            $str = str_replace($key, $val, $str);
        }

        return preg_replace('/[^a-zA-Z0-9-+]/', '', $str);
    }
    
    public static function toAlphaNumericOnly($str) {
        return preg_replace('/[^a-zA-Z0-9]/', '', $str);
    }

    public static function toCm($medida, $type) {
        switch ($type) {
            case SystemVO::MEASURE_M: return $medida / 100;
            case SystemVO::MEASURE_CM: return $medida;
            case null: return ;
            default: die('Type not allowed'); break;
        }
    }

    public static function toKg($weight, $type) {
        switch ($type) {
            case SystemVO::WEIGHT_G: return $weight / 1000;
            case SystemVO::WEIGHT_MG: return $weight / 1000000;
            case SystemVO::WEIGHT_KG: return $weight;
            case null: return ;
            default: die('Type not allowed'); break;
        }
    }

    public static function uniqStr() {
        return md5(uniqid(time()));
    }

}