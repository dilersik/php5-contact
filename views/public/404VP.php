<?php
SystemVO::setPageTitle('Erro 404 - Página não encontrada.');
SystemC::setWarningMsg('Erro 404! Página não encontrada, favor verifique se a URL requisitada realmente existe');
include_once DIR_INCLUDES_PUBLIC . '/topVP.inc.php';
?>
<div class="titleG">
    <div class="titleG_left"></div>
    <div class="titleG_center">Página não encontrada</div>
    <div class="titleG_right"></div>
</div>

<div style="text-align: center" class="text">
    <br /><br /><br />
    Você pode clicar no link abaixo para retornar a página anterior:
    <br /><br /><br />
</div>
<div class="voltar" style="margin: 0 auto;">
    <a href="javascript:history.back();">Voltar</a>
</div>
<?php include_once DIR_INCLUDES_PUBLIC . '/rodapeVP.inc.php'; ?>