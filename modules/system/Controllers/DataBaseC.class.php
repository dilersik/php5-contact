<?php

class DataBaseC {
    
    public static function executeModulesSQL() {
        if (!isset($_REQUEST['token'])) {
            die("token invalido");
        } else if ($_REQUEST['token'] != 'K1283-KLASP57-MCPQPOO-44KJSJKDA8-MCP554NASJ490') {
            die("token invalido2");
        }
        
        $x = 0;
        foreach (_MODULES() as $module) {
            $file = 'modules/' . $module . '/1_README/' . strtolower($module) . '.sql';
            if (file_exists($file)) {
                $fp = fopen($file, 'r');
                $sql = fread($fp, filesize($file));

                $pstmt = DAO::newPDO()->prepare("SET FOREIGN_KEY_CHECKS=0; " . $sql);
                $pstmt->execute() or die(print_r($pstmt->errorInfo()) . ' <br />' . $sql);

                fclose($fp);
                $x ++;
            }
        }
        
        echo $x . ' SQL executado com sucesso!';
    }
    
}
