<?php 
AdminC::controller();
include_once DIR_INCLUDES_ADMIN . '/topVA.inc.php';
SystemC::printTitle('Usuários admin - Buscar / Editar / Excluir');
$adminC = new AdminC();
$listAdmin = $adminC->adminList();
?>
<form action="" method="post">
    <table width="100%" class="table text">
        <tr>
            <td width="15%" align="right">Nome / Login / Email:</td>
            <td width="35%"><input type="text" name="name" class="input-text max" value="<?= $adminC->getAdminVO()->getName() ?>" /></td>
            
            <td width="15%" align="right">Permissão:</td>
            <td width="35%">
                <select name="admin_area_id" class="select med">
                    <option></option>
                    <?php
                    foreach (Admin_AreaDAO::select() as $value) {
                        echo '<option value="' . $value->getId() . '" ' . 
                                ($adminC->getAdminVO()->getListAdmin_Area_UnVO() && $value->getId() == $adminC->getAdminVO()->getListAdmin_Area_UnVO(0)->getAdmin_AreaVO()->getId() ? 'selected="selected"' : "") . '>'
                                . $value->getName() . '</option>';
                    }
                    ?>
                </select>
            </td>
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

<?php if ($listAdmin) { ?>
    <form action="" method="post" class="text">
        Ordenar por:
        <select name="order_by" onchange="this.form.submit();" class="select clearFix">
            <option></option>
            <?php
            foreach (SystemVO::getArray_order_default() as $key => $value) {
                echo '<option value="' . $key . '"' . ($key == $adminC->getOrder_by() ? ' selected="selected"' : '') . '>' . $value . '</option>';
            }
            ?>
        </select>
        <input type="hidden" name="funcao" value="Order_By" />
        <?= FormatU::numberFormatInt_ptBR(AdminC::getRows()) ?> Admin(s) localizado(s)
    </form><br />

    <form action="" method="post" onsubmit="return confirmacao(1);">
        <table width="100%" class="table list text">
            <thead>
                <tr>
                    <th width="24%" align="left">Nome</th>
                    <th width="15%" align="left">Login</th>
                    <th width="15%">Cadastrado</th>
                    <th width="15%">Alterado</th>
                    <th width="15%">Último login</th>
                    <th width="6%">Status</th>
                    <th width="6%">Editar</th>
                    <th width="4%">
                        <input type="checkbox" name="check_all" id="check_all" onclick="checkAll('admin_id[]', 'check_all', '');" class="pointer this_tooltip" title="Selecionar todos." />
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $x = 0;
                foreach ($listAdmin as $value) {
                    $list = $value->getListAdmin_LoginVO();
                ?>
                    <tr class="hover<?= ($x % 2 == 0 ? '' : ' zebra') ?>">
                        <td style="text-align:left"><?= $value->getFullName(); ?></td>
                        <td style="text-align:left"><?= $value->getUsername(); ?></td>
                        <td><?= FormatU::dateFormat_ptBR($value->getDate_post(), 'datetime'); ?></td>
                        <td><?= $value->getDate_update() ? FormatU::dateFormat_ptBR($value->getDate_update(), 'datetime') : 'Nunca'; ?></td>
                        <td><?= $list[0]->getDate_post() ? FormatU::dateFormat_ptBR($list[0]->getDate_post(), 'datetime') : 'Nunca' ?></td>
                        <td><?= SystemC::setIconArray_status($value->getStatus()) ?></td>
                        <td>
                            <a href="<?= HTTP_SERVER . '/adminEditVA/' . $value->getId(); ?>">
                                <img src="<?= SystemC::imgSrcSys('editar_icon.png') ?>" class="this_tooltip" alt="editar" title="Editar." />
                            </a>
                        </td>
                        <td><input type="checkbox" name="admin_id[]" value="<?= $value->getId(); ?>" class="pointer this_tooltip" title="Selecione para aplicar Ações." /></td>
                    </tr>
                <?php $x ++; } ?>
            </tbody>
        </table>
        <p class="text" style="margin: 15px 0; text-align: right;">
            Senha atual de administrador:
            <input type="password" name="pwd_atual" size="20" class="input-text clearFix" />

            <select name="funcao" class="select clearFix" style="width: 150px;">
                <option>Ações</option>
                <option value="Deletar">Excluir</option>
            </select>
            <input type="submit" value="Aplicar" class="input_submit" />
        </p>
    </form>
<?php
    ToolsT::paginator(AdminC::getRows(), $adminC->getQtd(), $adminC->getPagina(), HTTP_SERVER . '/' . SystemC::getPag() . '/order_by/' . $adminC->getOrder_by());
}
echo '<div class="voltar"><a href="javascript:history.back();">Voltar</a></div>';
include_once DIR_INCLUDES_ADMIN . '/rodapeVA.inc.php';
?>