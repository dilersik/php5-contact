<?php
DefineC::controller();
$getByID = DefineC::defineEdit();
include_once DIR_INCLUDES_ADMIN . '/topVA.inc.php';
SystemC::printTitle('Configurações - Editar');
?>
<form id="form_define" action="" method="post">
    <table width="100%" class="table text">
        <tr>
            <td width="15%" align="right">Status:</td>
            <td width="35%">
                <select name="status" class="select" style="width: 150px;">
                    <option></option>
                    <?php
                    foreach (SystemVO::getArray_status() as $key => $value) {
                        echo '<option value="' . $key . '"' . ($key == $getByID->getStatus() ? ' selected="selected"' : '') . '>'
                                . $value . '</option>';
                    }
                    ?>
                </select>
            </td>
            
            <td width="15%" align="right"></td>
            <td width="35%"></td>
        </tr>
        
        <tr><td colspan="2"><h2 class="subTitle">Otimização</h2></td></tr>
        <tr>
            <td align="right">Page title:</td>
            <td><input type="text" name="page_title" class="input-text max" value="<?= $getByID->getPage_title() ?>" /></td>
            
            <td align="right">Page meta keywords:</td>
            <td><input type="text" name="page_meta_keywords" class="input-text max" value="<?= $getByID->getPage_meta_keywords() ?>" /></td>
        </tr>
        <tr>
            <td align="right">Page meta description:</td>
            <td><input type="text" name="page_meta_description" class="input-text max" value="<?= $getByID->getPage_meta_description() ?>" /></td>
            
            <td align="right">Complemento da URL:</td>
            <td><input type="text" name="page_nice_url" class="input-text max lower" value="<?= $getByID->getPage_nice_url() ?>" /></td>
        </tr>
        <tr>
            <td align="right">Page analytics code:</td>
            <td><input type="text" name="page_analytics_code" class="input-text med upper" value="<?= $getByID->getPage_analytics_code() ?>" /></td>
        </tr>
        
        <tr><td colspan="2"><h2 class="subTitle">Dados da Empresa</h2></td></tr>
        <tr>
            <td align="right">Nome Fantasia:</td>
            <td><input type="text" name="company_fancy_name" class="input-text max" value="<?= $getByID->getCompany_fancy_name() ?>" /></td>
            
            <td align="right">Email:</td>
            <td><input type="text" name="company_email" class="input-text max lower" value="<?= $getByID->getCompany_email() ?>" /></td>
        </tr>
        
        <tr>
            <td align="right">CEP de origem (utilizado para cálculo de frete):</td>
            <td><input type="text" name="company_cep_origem" class="input-text min mask_cep" value="<?= $getByID->getCompany_cep_origem() ?>" /></td>
            
            <td align="right">CNPJ:</td>
            <td><input type="text" name="company_cnpj" class="input-text med mask_cnpj" value="<?= $getByID->getCompany_cnpj() ?>" /></td>
        </tr>
        
        <tr> 
            <td align="right">Inscrição Estadual:</td>
            <td><input type="text" name="company_state_registration" class="input-text med" value="<?= $getByID->getCompany_state_registration() ?>" /></td>
        
            <td align="right">Razão Social:</td>
            <td><input type="text" name="company_corporate_name" class="input-text max" value="<?= $getByID->getCompany_corporate_name() ?>" /></td>
        </tr>
        
        <tr>
            <td align="right">Telefone:</td>
            <td><input type="text" name="company_tel" class="input-text med" value="<?= $getByID->getCompany_tel() ?>" /></td>
        
            <td align="right">Celular:</td>
            <td><input type="text" name="company_cel" class="input-text med" value="<?= $getByID->getCompany_cel() ?>" /></td>
        </tr>
        
        <tr>
            <td align="right">Telefone 2:</td>
            <td><input type="text" name="company_tel2" class="input-text med" value="<?= $getByID->getCompany_tel2() ?>" /></td>
        
            <td align="right">Celular 2:</td>
            <td><input type="text" name="company_cel2" class="input-text med" value="<?= $getByID->getCompany_cel2() ?>" /></td>
        </tr>
        
        <tr>
            <td align="right">Whatsapp:</td>
            <td><input type="text" name="company_whatsapp" class="input-text med" value="<?= $getByID->getCompany_whatsapp() ?>" /></td>
        
            <td align="right">Facebook:</td>
            <td><input type="text" name="company_facebook" class="input-text max" value="<?= $getByID->getCompany_facebook() ?>" /></td>
        </tr>
        
        <tr>
            <td align="right">Instagram:</td>
            <td><input type="text" name="company_instagram" class="input-text max" value="<?= $getByID->getCompany_instagram() ?>" /></td>
        
            <td align="right">Linked In:</td>
            <td><input type="text" name="company_linkedin" class="input-text max" value="<?= $getByID->getCompany_linkedin() ?>" /></td>
        </tr>
        
        <tr>
            <td align="right">Twitter:</td>
            <td><input type="text" name="company_twitter" class="input-text max" value="<?= $getByID->getCompany_twitter() ?>" /></td>
        
            <td align="right">Youtube:</td>
            <td><input type="text" name="company_youtube" class="input-text max" value="<?= $getByID->getCompany_youtube() ?>" /></td>
        </tr>
        
        <tr>
            <td align="right">Endereço:</td>
            <td><textarea name="company_address" cols="2" rows="3" class="textarea"><?= FormatU::breakLineNoLine($getByID->getCompany_address()) ?></textarea></td>
       
            <td align="right">Endereço 2:</td>
            <td><textarea name="company_address2" cols="2" rows="3" class="textarea"><?= FormatU::breakLineNoLine($getByID->getCompany_address2()) ?></textarea></td>
        </tr>
        
        <tr><td colspan="2"><h2 class="subTitle">Frete Correios</h2></td></tr>
        <tr>
            <td align="right">Código de Empresa:</td>
            <td><input type="text" name="correio_empresa" class="input-text med" value="<?= $getByID->getCorreio_empresa() ?>" /></td>
            
            <td align="right">Senha de Empresa:</td>
            <td><input type="text" name="correio_senha" class="input-text med" value="<?= $getByID->getCorreio_senha() ?>" /></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <input type="hidden" id="define_id" name="define_id" value="<?= $getByID->getId() ?>" />
                <input type="hidden" name="funcao" value="Alterar" />
                <input type="submit" value="Alterar" class="input-submitAdd" />
                <input type="button" onclick="javascript:history.back();" value="Cancelar" class="input-submitX" />
            </td>
        </tr>
    </table>
</form>

<?= DefineC::showPostUpdateText($getByID) ?>
<?php
echo '<div class="voltar"><a href="javascript:history.back();">Voltar</a></div>';
include_once DIR_INCLUDES_ADMIN . '/rodapeVA.inc.php';
?>