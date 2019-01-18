<?php

// DEFINIR AQUI OS MODULOS/PASTAS INSTALADOS
function _MODULES() {
    return array('admin', 'contact', 'define', 'system',);
}

// DEFINIR AQUI SE TIVER PASTAS DIFERENTES
function _MODULE_FOLDERS() {
    return array('BOs', 'Controllers', 'DAOs', 'Utils', 'VOs');
}

define('GET_PAG_DEFAULT', 'homeVA');

define('DIR_MODULES', 'modules');
define('DIR_UPLOADS', 'uploads');
define('DIR_BACKUPS', 'BACKUPs');
define('DIR_VIEW', 'views');
define('DIR_CSS', DIR_VIEW . '/geral/css');
define('DIR_DOC', DIR_VIEW . '/geral/doc');
define('DIR_IMG', DIR_VIEW . '/geral/img');
define('DIR_JS', DIR_VIEW . '/geral/js');
define('DIR_PHP', DIR_VIEW . '/geral/php');
define('DIR_VIEW_PUBLIC', DIR_VIEW . '/public');
define('DIR_INCLUDES_PUBLIC', DIR_VIEW_PUBLIC . '/includes');