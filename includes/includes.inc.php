<?php

if (!session_id()) {
    session_start();
}

require_once 'includes/defineModules.inc.php';

// funcação de buscar nas pastas
function autoloadSearchInModules($module, $pasta, $classe) {
    if (file_exists(DIR_MODULES . '/' . $module . '/' . $pasta . '/' . $classe . '.class.php')) {
        require_once DIR_MODULES . '/' . $module . '/' . $pasta . '/' . $classe . '.class.php';
        return true;
    } else if (file_exists(DIR_MODULES . '/' . $module . '/' . $pasta . '/' . $classe . '.php')) {
        require_once DIR_MODULES . '/' . $module . '/' . $pasta . '/' . $classe . '.php';
        return true;
    } else if (file_exists(DIR_MODULES . '/' . $module . '/' . $classe . '.class.php')) {
        require_once DIR_MODULES . '/' . $module . '/' . $classe . '.class.php';
        return true;
    } else if (file_exists(DIR_MODULES . '/' . $module . '/' . $classe . '.php')) {
        require_once DIR_MODULES . '/' . $module . '/' . $classe . '.php';
        return true;
    } else if (file_exists(DIR_MODULES . '/' . $module . '/class.' . $classe . '.php')) {
        require_once DIR_MODULES . '/' . $module . '/class.' . $classe . '.php';
        return true;
    }
}

// autload de classes para o Define
function autoloadInitialClassProject($classe) {
    foreach (array("admin", "define", "system") as $module) {
        foreach (_MODULE_FOLDERS() as $pasta) {
            if (autoloadSearchInModules($module, $pasta, $classe)) {
                break;
            }
        }
    }
}
spl_autoload_register("autoloadInitialClassProject");

// incluir todos defines
require_once 'includes/define.inc.php';
foreach (_MODULES() as $module) {
    if (file_exists(DIR_MODULES . '/' . $module . '/includes/define.inc.php')) {
        require_once DIR_MODULES . '/' . $module . '/includes/define.inc.php';
    }
}

// autload de todas outras classes
function autoloadAllClassProject($classe) {
    foreach (_MODULES() as $module) {
        foreach (_MODULE_FOLDERS() as $pasta) {
            if (autoloadSearchInModules($module, $pasta, $classe)) {
                break;
            }
        }
    }
}
spl_autoload_register("autoloadAllClassProject");

// pegar pag e incluir todas as index.php
SystemC::setPag();
foreach (_MODULES() as $module) {
    if (file_exists(DIR_MODULES . '/' . $module . '/index.php')) {
        require_once DIR_MODULES . '/' . $module . '/index.php';
    }
}