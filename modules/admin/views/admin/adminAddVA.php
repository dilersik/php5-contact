<?php
AdminC::controller();
AdminC::addRequireScript();
include_once DIR_INCLUDES_ADMIN . '/topVA.inc.php';
SystemC::printTitle('Usuários admin - Cadastrar');
?>
<form id="form_admin" action="" method="post">
    <table width="100%" class="table text">
        <tr>
            <td width="15%" align="right">Status:</td>
            <td>
                <select name="status" class="select" style="width: 150px;">
                    <option></option>
                    <?php
                    foreach (SystemVO::getArray_status() as $key => $value) {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <td style="vertical-align: top;" align="right">Permissão: </td>
            <td>
                <label for="check_all">
                    <input type="checkbox" name="check_all" id="check_all" onclick="checkAll('admin_area_id[]', 'check_all', 'selec_all');" />
                    <span id="selec_all">Selecionar todos</span>
                </label><br />
                <?php
                foreach (Admin_AreaDAO::select() as $value) {
                    echo '<label for="admin_area_id' . $value->getId() . '">
                            <input type="checkbox" name="admin_area_id[]" id="admin_area_id' . $value->getId() . '" value="' . $value->getId() . '" />
                            ' . $value->getName() . '
                            </label> ';
                }
                ?>
            </td>
        </tr>

        <tr>
            <td align="right">Nome:</td>
            <td><input type="text" name="name" class="input-text med upper" /></td>
        </tr>
        
        <tr>
            <td align="right">Sobrenome:</td>
            <td><input type="text" name="lastname" class="input-text med upper" /></td>
        </tr>

        <tr>
            <td align="right">Email:</td>
            <td><input type="text" name="email" class="input-text med lower" /></td>
        </tr>

        <tr>
            <td align="right">Login:</td>
            <td><input type="text" name="username" class="input-text min" /></td>
        </tr>

        <tr>
            <td align="right">Senha:</td>
            <td><div style="width: 257px;">
                <input type="password" name="pwd" id="pwd" size="20" class="input-text max pstrength" />
            </div></td>
        </tr>

        <tr>
            <td align="right">Repita a senha:</td>
            <td><input type="password" name="pwd_copy" id="pwd_copy" size="20" class="input-text min" /></td>
        </tr>

        <tr>
            <td align="right">Senha atual de administrador:</td>
            <td><input type="password" name="pwd_atual" id="pwd_atual" size="20" class="input-text min" /></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <input type="hidden" name="admin_id" id="admin_id" value="0" />
                <input type="hidden" name="funcao" value="Cadastrar" />
                <input type="submit" value="Cadastrar" class="input-submitAdd" />
                <input type="button" onclick="javascript:history.back();" value="Cancelar" class="input-submitX" />
            </td>
        </tr>
    </table>
</form>
<?php
echo '<div class="voltar"><a href="javascript:history.back();">Voltar</a></div>';
include_once DIR_INCLUDES_ADMIN . '/rodapeVA.inc.php';
?>