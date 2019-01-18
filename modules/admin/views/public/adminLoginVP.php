<?php AdminC::controller(); ?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
        <meta name="Author" content="Dilermando Augusto Sikora" />
        <title><?= DefineC::d()->getCompany_fancy_name() ?> - Login</title>
        <link rel="shortcut icon" href="<?= AdminC::imgSrc('favicon_val.ico') ?>" type="image/x-icon" />
        <link rel="icon" href="<?= AdminC::imgSrc('favicon_val.ico') ?>" type="image/x-icon" />
        <?php
        SystemC::addStyle(array('bootstrap.min', 'admin', 'utils'), true);
        SystemC::addScript(array('jquery.min', 'bootstrap.min', 'jquery.validate.min', 'valida_admin_login', 'messages_pt-BR'), true);
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('input[name=username]').focus();
            });
        </script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-centered">
                    <h1 class="page-header">Login - Gerenciamento</h1>
                    <?php SystemC::return_msg(); ?>
                    <form id="form_admin_login" action="" class="col-md-12" method="post">
                        <div class="row">
                            <div class="form-group">
                                <label for="inpTxtUsername">Usuário</label>
                                <input type="text" name="username" id="inpTxtUsername" autocomplete="off" class="form-control" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="inpTxtPwd">Senha</label>
                                <input type="password" name="pwd" id="inpTxtPwd" size="20" class="form-control" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <input type="hidden" name="url_return" value="<?= (isset($_GET['url_return']) ? $_GET['url_return'] : ''); ?>" />
                                <input type="hidden" name="funcao" value="logar" />
                                <input type="submit" value="Entrar" class="btn btn-primary" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>