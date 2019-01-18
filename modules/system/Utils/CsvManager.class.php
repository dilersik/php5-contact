<?php

class CsvManager {
    
    public static function importCSV2Array($filename) {
        $row = 0;
        $col = 0;

        $handle = @fopen($filename, "r");
        $fields = null;
        $results = array();
        if ($handle) {
            while (($row = fgetcsv($handle, 4096)) !== false) {
                if (!$fields) {
                    $fields = $row;
                    continue;
                }

                foreach ($row as $k => $value) {
                    $results[$col][FormatU::tlower(FormatU::toAlphaNumericOnly($fields[$k]))] = $value; // indice por nome
//                    $results[$col][$k] = $value; // indice Int
                }
                $col++;
                unset($row);
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() failn";
            }
            fclose($handle);
        }

        return $results;
    }

}
