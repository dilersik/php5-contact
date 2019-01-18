<?php

define('PROJECT_VERSION', '1.0');
date_default_timezone_set('America/Sao_Paulo');
mb_internal_encoding('UTF-8');

define('PROJECT_NAME', 'contactproject');
define('DOMAIN_NAME', PROJECT_NAME . '.com.br');

define('HTTP_REQUEST', $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
// AMBIENTE DESENVOLVIMENTO
if (SystemC::isDevelopmentAmbient()) {
    define('HTTP_SERVER', 'http://' . $_SERVER['HTTP_HOST'] . '/' . PROJECT_NAME);
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'contactproject');
    define('DB_USER', 'root');
    define('DB_PSWD', '');
// AMBIENTE HOMOLOGAÇÃO
} else if (SystemC::isHomologationEnvironment()) {
    define('HTTP_SERVER', 'http://' . $_SERVER['HTTP_HOST'] . '/' . (SystemC::isHomologationEnvironmentOnServer() ? 'novo' : PROJECT_NAME));
    define('DB_HOST', 'localhost');
    define('DB_NAME', '');
    define('DB_USER', '');
    define('DB_PSWD', '');
// AMBIENTE PRODUÇÃO
} else {
    define('HTTP_SERVER', 'http://' . $_SERVER['HTTP_HOST']);
    define('DB_HOST', 'localhost');
    define('DB_NAME', '');
    define('DB_USER', '');
    define('DB_PSWD', '');
}