<?php $getAdmin_name = AdminC::getName(); ?>
<!DOCTYPE HTML>
 <html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
        <meta name="Author" content="Dilermando Augusto Sikora" />
        <title><?= DefineC::d()->getCompany_fancy_name() ?> - Administração</title>
        <link rel="shortcut icon" href="<?= AdminC::imgSrc('favicon_vra.ico') ?>" type="image/x-icon" />
        <link rel="icon" href="<?= AdminC::imgSrc('favicon_vra.ico') ?>" type="image/x-icon" />
        <?php
        SystemC::addStyle(array('bootstrap.min', 'admin', "utils"), true);
        SystemC::addScript(array('jquery.min', 'bootstrap.min', 'jquery.validate.min', 'function_loadWindow', 'function_checkAll',
                                  'function_confirmacao', 'function_upper-lower', 'function_show-hide', 'function_atualizaContador', 'function_inputs', 'function_admin',
                                  'methods_jQuery'), true);
        ?>
    </head>
    <body>
        <input type="hidden" id="admin_updateDate" value="<?= AdminC::expireDateLogin($getAdmin_name->getListAdmin_LoginVO(0)->getDate_update()) ?>" />
        <input type="hidden" id="HTTP_SERVER" value="<?= HTTP_SERVER ?>" />
        
        <div id="loadingWindow"><div>Espere por favor. Carregando a página...</div></div>
        
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= HTTP_SERVER ?>">Home</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <div id="descTimer">
                                <div id="resTimer">
                                    <div id="resTimerDIAS"></div>
                                    <div id="resTimerHORAS"></div>
                                    <div id="resTimerMINUTOS"></div>
                                    <div id="resTimerSEGUNDOS"></div>
                                </div>
                                <p>Olá, <b><?= $getAdmin_name->getName(); ?></b> <a href="<?= HTTP_SERVER ?>/admin_loginVP&amp;funcao=logout">[ Sair ] </a> | 
                                    Sessão expira em: </p>
                            </div> <!-- #descTimer -->
                        </li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <?php AdminC::includeTopNav() ?>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <div id="main" class="container">
            <?php SystemC::return_msg() ?>