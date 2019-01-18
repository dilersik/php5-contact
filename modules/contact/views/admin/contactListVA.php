<?php
ContactC::controller();
include_once DIR_INCLUDES_ADMIN . '/topVA.inc.php';
SystemC::printTitle('Contatos - Buscar / Editar / Excluir');
$control = new ContactC();
$listContact = $control->contactList();
?>
<form action="" class="form-horizontal row" method="post">
    <div class="form-group col-sm-6">
        <label class="control-label col-sm-3" for="inpTxtName">Nome:</label>
        <div class="col-sm-9"><input type="text" name="name" id="inpTxtName" class="form-control" value="<?= $control->getContactVO()->getName() ?>" /></div>
    </div>     

    <div class="form-group col-sm-6">
        <label class="control-label col-sm-3" for="inpTxtContactinfo">Email/Tel:</label>
        <div class="col-sm-9"><input type="text" name="contactinfo" id="inpTxtContactinfo" class="form-control" value="<?= $control->getContactInfo() ?>" /></div>
    </div>
    
    <div class="form-group col-sm-6">
        <div class="col-sm-10 col-sm-offset-3">
            <input type="hidden" name="funcao" value="Search" />
            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar registros</button>

            <a href="<?= HTTP_SERVER . '/' . SystemC::getPag() ?>&amp;funcao=CleanSearch" class="btn btn-default"><i class="glyphicon glyphicon-trash"></i> Limpar</a>
        </div>
    </div>
</form>

<?php if ($listContact) { ?>
    <form action="" method="post">
        <div class="row">
            <div class="form-group col-sm-6 col-md-4">
                <select name="order_by" id="selectOrder_by" onchange="this.form.submit();" class="form-control">
                    <option></option>
                    <?php
                    foreach (SystemVO::getArray_order_default() as $key => $value) {
                        echo '<option value="' . $key . '"' . ($key == $control->getOrder_by() ? ' selected="selected"' : '') . '>Ordenar por: ' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-lg-3">
                <?= FormatU::numberFormatInt_ptBR(ContactC::getRows()) ?> localizado(s)
            </div>
            <input type="hidden" name="funcao" value="Order_By" />
        </div>
    </form>

    <form action="" method="post" onsubmit="return confirmacao(1);">
        <div class="table-responsive">          
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="40%">Nome</th>
                        <th width="20%">Contatos</th>
                        <th width="15%">Cadastrado</th>
                        <th width="15%">Alterado</th>
                        <th width="6%">Editar</th>
                        <th width="4%"><input type="checkbox" name="check_all" id="check_all" onclick="checkAll('contact_id[]', 'check_all', '');" class="pointer this_tooltip" title="Selecionar todos." /></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $x = 0;
                    foreach ($listContact as $value) {
                    ?>
                        <tr>
                            <td><?= $value->getName() ?></td>
                            <td><?= FormatU::formatStr($value->getFullTel(), 'fone') . '<br />' . $value->getEmail() ?></td>
                            <td><?= FormatU::dateFormat_ptBR($value->getDate_post(), 'datetime'); ?></td>
                            <td><?= $value->getDate_update() ? FormatU::dateFormat_ptBR($value->getDate_update(), 'datetime') : 'Nunca'; ?></td>
                            <td>
                                <a href="<?= HTTP_SERVER . '/contactEditVA/' . $value->getId(); ?>" class="btn btn-primary">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </a>
                            </td>
                            <td><input type="checkbox" name="contact_id[]" value="<?= $value->getId(); ?>"  title="Selecione para aplicar Ações." /></td>
                        </tr>
                    <?php $x ++; } ?>
                </tbody>
            </table>
        </div>
                    
        <div class="row">
            <div class="col-lg-2 pull-right">
                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-ok-circle"></i> Aplicar</button>
            </div>
            <div class="col-lg-2 pull-right">
                <select name="funcao" class="form-control">
                    <option>Ações</option>
                    <option value="seen">Marcar como Lido</option>
                    <option value="notseen">Marcar como Não Lido</option>
                    <option value="Deletar">Excluir</option>
                </select>
            </div>
        </div>
    </form>
<?php
    ToolsT::paginator(ContactC::getRows(), $control->getQtd(), $control->getPagina(), HTTP_SERVER . '/' . SystemC::getPag() . '/order_by/' . $control->getOrder_by());
}
echo '<div class="row"><a href="javascript:history.back();" class="btn btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Voltar</a></div>';
include_once DIR_INCLUDES_ADMIN . '/rodapeVA.inc.php';
?>