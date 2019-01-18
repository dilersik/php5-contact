<?php
ContactC::controller();
$content = ContentC::getOByNav(ContentBO::NAV_CONTACT);
SystemVO::setPageMeta_description($content->getMeta_description());
SystemVO::setPageMeta_keywords($content->getMeta_keywords());
SystemVO::setPageTitle($content->getPage_title());
SystemC::addStyle(array('contact'));
SystemC::addScript(array('jquery.validate.min', 'methods_jQuery', 'valida_contact', 'messages_pt-BR'));
include_once DIR_INCLUDES_PUBLIC . '/topVP.inc.php';
?>
<h1 class="title">Trabalhe conosco</h1>

<form action="" id="form_contact" class="form text" method="post" enctype="multipart/form-data">
    <h2 class="subTitle"><?= DefineC::d()->getCompany_tel() ?></h2>
    <h2 class="subTitle"><?= DefineC::d()->getCompany_email() ?></h2>
    
    <label for="name" class="lbl">
        <span>Nome:</span>
        <input type="text" name="name" id="name" placeholder="Nome" class="input-text max" />
    </label>
    <label for="fulltel" class="lbl">
        <span>DDD + Telefone:</span>
        <input type="tel" name="fulltel" id="fulltel" placeholder="DDD + Telefone" class="input-text med" />
    </label>
    <label for="email" class="lbl">
        <span>Email:</span>
        <input type="email" name="email" id="email" placeholder="Email" class="input-text max" />
    </label>
    <label for="files" class="lbl">
        <span>Currículo (<?= ContactBO::ANEXO_EXT ?> até <?= FormatU::by2M(ContactBO::ANEXO_SIZE) ?>):</span>
        <input type="file" name="files" id="files" size="40" placeholder="Arquivo" class="input-file max" /> 
    </label>
    <label for="msg" class="lbl">
        <span>Mensagem:</span>
        <textarea name="msg" id="msg" placeholder="Mensagem" class="textarea max" cols="5" rows="5"></textarea>
    </label>

    <input type="hidden" name="funcao" value="cadastrarTrabalheConosco" />
    <input type="submit" value="Enviar Mensagem" class="input-submitFinal" />
</form>

<div id="contactRight" class="text"><?= $content->getText() ?></div>

<?php include_once DIR_INCLUDES_PUBLIC . '/rodapeVP.inc.php';