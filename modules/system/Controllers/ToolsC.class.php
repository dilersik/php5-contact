<?php

class ToolsC {

    public static function downloadFromServer() {
        ToolsT::downloadForce(ValidateU::antStr(@$_GET['src']), ValidateU::antStr(@$_GET['name']));
    }
    
    public static function downloadFromHttp() {
        $url = (isset($_REQUEST['protocol']) ? ValidateU::antStr($_REQUEST['protocol']) : 'http') . '://'
                . SystemC::setREQUEST_URI(@$_GET['src'], false);
        $content = file_get_contents($url);
        if (!$content) {
            die("file_get_contents not found");
        }
        $filename = isset($_REQUEST['name']) ? ValidateU::antStr($_REQUEST['name']) : 'arquivo_' . DOMAIN_NAME . time();
        $dir = explode('?', DIR_TMP . "/" . $filename . '.' . FormatU::getExt($url));
        $dir = $dir[0];
        file_put_contents($dir, $content);
        
        ToolsT::downloadForce($dir, $filename, true);
    }

}