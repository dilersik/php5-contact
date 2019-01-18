<?php
SystemC::setErrorMsg('Acesso negado! Este usuário não tem permissão para acessar esta página. Contate o administrador');
include_once DIR_INCLUDES_ADMIN . '/topVA.inc.php';
SystemC::printTitle('A página requisitada não pode ser acessada.');
?>
<div style="text-align: center" class="text">
    <br /><br /><br />
    Você pode clicar no link abaixo para retornar a página anterior:
    <br /><br /><br />
    <div class="voltar" style="margin: 0 auto;">
        <a href="javascript:history.back();">Voltar</a>
    </div>
</div><br /><br />
<?php include_once DIR_INCLUDES_ADMIN . '/rodapeVA.inc.php'; ?>