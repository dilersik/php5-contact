<?php
CustomerPartnerC::checkPartnerToken();
CustomerC::isLogado();
?>
<!DOCTYPE HTML>
 <html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
        <meta name="Author" content="Dilermando Augusto Sikora" />
        <meta name="description" content="<?= SystemVO::getPageMeta_description() ?>" />
        <meta name="keywords" content="<?= SystemVO::getPageMeta_keywords() ?>" />
        <title><?= SystemVO::getPageTitle() ?></title>
        <link rel="shortcut icon" href="<?= SystemC::imgSrc('favicon.ico') ?>" type="image/x-icon" />
        <link rel="icon" href="<?= SystemC::imgSrc('favicon.ico') ?>" type="image/x-icon" />
        <?php
        SystemC::addStyle(array(/* 'reset', */ 'utils', 'stylesimport'), true);
        SystemC::addScript(array('jquery.min'), true);
        include_once DIR_INCLUDES_PUBLIC . '/html5.php';
        ?>
    </head>
    <body id="body">
        <input type="hidden" id="HTTP_SERVER" value="<?= HTTP_SERVER ?>" />
        
        <?php SystemC::return_msg(); ?>