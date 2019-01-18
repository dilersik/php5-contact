<?php 
DefineC::controller();
include_once DIR_INCLUDES_ADMIN . '/topVA.inc.php';
SystemC::printTitle('Configurações - Buscar / Editar / Excluir');
$control = new DefineC();
$list = $control->defineList();
?>
<form action="" method="post">
    <table width="100%" class="table text">
        <tr>
            <td width="15%" align="right">Page title:</td>
            <td width="35%"><input type="text" name="page_title" class="input-text max" value="<?= $control->getDefineVO()->getPage_title() ?>" /></td>
            
            <td width="15%" align="right">Complemento da URL:</td>
            <td width="35%"><input type="text" name="page_nice_url" class="input-text med" value="<?= $control->getDefineVO()->getPage_nice_url() ?>" /></td>
        </tr>
        
        <tr>
            <td></td>
            <td>
                <input type="hidden" name="funcao" value="Search" />
                <input type="submit" value="Buscar" class="input_submit" />
            </td>

            <td class="link">
                <a href="<?= HTTP_SERVER . '/' . SystemC::getPag() ?>&amp;funcao=CleanSearch">Limpar pesquisa</a>
            </td>
        </tr>
    </table>
</form><br />

<?php if ($list) { ?>
    <form action="" method="post" class="text">
        Ordenar por:
        <select name="order_by" onchange="this.form.submit();" class="select clearFix">
            <option></option>
            <?php
            foreach (SystemVO::getArray_order_default() as $key => $value) {
                echo '<option value="' . $key . '"' . ($key == $control->getOrder_by() ? ' selected="selected"' : '') . '>' . $value . '</option>';
            }
            ?>
        </select>
        <input type="hidden" name="funcao" value="Order_By" />
        <?= FormatU::numberFormatInt_ptBR(DefineC::getRows()) ?> localizado(s)
    </form><br />

    <form action="" method="post" onsubmit="return confirmacao(1);">
        <table width="100%" class="table list text">
            <thead>
                <tr>
                    <th width="35%" align="left">Título / Email</th>
                    <th width="19%" align="left">URL</th>
                    <th width="15%" align="left">Telefone</th>
                    <th width="15%">Cadastrado</th>
                    <th width="6%">Status</th>
                    <th width="6%">Editar</th>
                    <th width="4%"><input type="checkbox" name="check_all" id="check_all" onclick="checkAll('define_id[]', 'check_all', '');" class="pointer this_tooltip" title="Selecionar todos." /></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $x = 0;
                foreach ($list as $value) {
                ?>
                    <tr class="hover<?= ($x % 2 == 0 ? '' : ' zebra') ?>">
                        <td style="text-align: left"><?= $value->getPage_title() . '<br />' . $value->getCompany_email() ?></td>
                        <td style="text-align: left"><?= $value->getPage_nice_url() ?></td>
                        <td style="text-align: left"><?= $value->getCompany_tel() . '<br />' . $value->getCompany_cel() ?></td>
                        <td><?= FormatU::dateFormat_ptBR($value->getDate_post(), 'datetime'); ?></td>
                        <td><?= SystemC::setIconArray_status($value->getStatus()) ?></td>
                        <td>
                            <a href="<?= HTTP_SERVER ?>/defineEditVA/<?= $value->getId(); ?>">
                                <img src="<?= SystemC::imgSrcSys('editar_icon.png') ?>" class="this_tooltip" alt="editar" title="Editar." />
                            </a>
                        </td>
                        <td><input type="checkbox" name="define_id[]" value="<?= $value->getId(); ?>" class="pointer this_tooltip" title="Selecione para aplicar Ações." /></td>
                    </tr>
                <?php $x ++; } ?>
            </tbody>
        </table>
        <p class="text" style="margin: 15px 0; text-align: right;">
            <select name="funcao" class="select clearFix" style="width: 150px;">
                <option>Ações</option>
                <option value="Deletar">Excluir</option>
            </select>
            <input type="submit" value="Aplicar" class="input_submit" />
        </p>
    </form>
<?php
    ToolsT::paginator(DefineC::getRows(), $control->getQtd(), $control->getPagina(), HTTP_SERVER . '/' . SystemC::getPag() . '/order_by/' . $control->getOrder_by());
}
echo '<div class="voltar"><a href="javascript:history.back();">Voltar</a></div>';
include_once DIR_INCLUDES_ADMIN . '/rodapeVA.inc.php';
?>