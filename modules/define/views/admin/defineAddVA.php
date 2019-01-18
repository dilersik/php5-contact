<?php
DefineC::controller();
DefineC::addRequireScript();
include_once DIR_INCLUDES_ADMIN . '/topVA.inc.php';
SystemC::printTitle('Configurações - Cadastrar');
?>
<form id="form_define" action="" method="post">
    <table width="100%" class="table text">
        <tr>
            <td width="15%" align="right">Status:</td>
            <td width="35%">
                <select name="status" class="select min">
                    <option></option>
                    <?php
                    foreach (SystemVO::getArray_status() as $key => $value) {
                        echo '<option value="' . $key . '">' . $value . '</option>';
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
            <td><input type="text" name="page_title" class="input-text max" /></td>
            
            <td align="right">Page meta keywords:</td>
            <td><input type="text" name="page_meta_keywords" class="input-text max" /></td>
        </tr>
        <tr>
            <td align="right">Page meta description:</td>
            <td><input type="text" name="page_meta_description" class="input-text max" /></td>
            
            <td align="right">Complemento da URL:</td>
            <td><input type="text" name="page_nice_url" class="input-text max lower" /></td>
        </tr>
        <tr>
            <td align="right">Page analytics code:</td>
            <td><input type="text" name="page_analytics_code" class="input-text med upper" /></td>
        </tr>
        
        <tr><td colspan="2"><h2 class="subTitle">Dados da Empresa</h2></td></tr>
        <tr>
            <td align="right">Nome Fantasia:</td>
            <td><input type="text" name="company_fancy_name" class="input-text max" /></td>
            
            <td align="right">Email:</td>
            <td><input type="text" name="company_email" class="input-text max lower" /></td>
        </tr>
        
        <tr>
            <td align="right">CEP de origem (utilizado para cálculo de frete):</td>
            <td><input type="text" name="company_cep_origem" class="input-text min mask_cep" /></td>
            
            <td align="right">CNPJ:</td>
            <td><input type="text" name="company_cnpj" class="input-text med mask_cnpj" /></td>
        </tr>
        
        <tr> 
            <td align="right">Inscrição Estadual:</td>
            <td><input type="text" name="company_state_registration" class="input-text med" /></td>
        
            <td align="right">Razão Social:</td>
            <td><input type="text" name="company_corporate_name" class="input-text max" /></td>
        </tr>
        
        <tr>
            <td align="right">Telefone:</td>
            <td><input type="text" name="company_tel" class="input-text med" /></td>
        
            <td align="right">Celular:</td>
            <td><input type="text" name="company_cel" class="input-text med" /></td>
        </tr>
        
        <tr>
            <td align="right">Telefone 2:</td>
            <td><input type="text" name="company_tel2" class="input-text med" /></td>
        
            <td align="right">Celular 2:</td>
            <td><input type="text" name="company_cel2" class="input-text med" /></td>
        </tr>
        
        <tr>
            <td align="right">Whatsapp:</td>
            <td><input type="text" name="company_whatsapp" class="input-text med" /></td>
        
            <td align="right">Facebook:</td>
            <td><input type="text" name="company_facebook" class="input-text max" /></td>
        </tr>
        
        <tr>
            <td align="right">Instagram:</td>
            <td><input type="text" name="company_instagram" class="input-text max" /></td>
        
            <td align="right">Linked In:</td>
            <td><input type="text" name="company_linkedin" class="input-text max" /></td>
        </tr>
        
        <tr>
            <td align="right">Twitter:</td>
            <td><input type="text" name="company_twitter" class="input-text max" /></td>
        
            <td align="right">Youtube:</td>
            <td><input type="text" name="company_youtube" class="input-text max" /></td>
        </tr>
        
        <tr>
            <td align="right">Endereço:</td>
            <td><textarea name="company_address" cols="2" rows="3" class="textarea"></textarea></td>
       
            <td align="right">Endereço 2:</td>
            <td><textarea name="company_address2" cols="2" rows="3" class="textarea"></textarea></td>
        </tr>
        
        <tr><td colspan="2"><h2 class="subTitle">Frete Correios</h2></td></tr>
        <tr>
            <td align="right">Código de Empresa:</td>
            <td><input type="text" name="correio_empresa" class="input-text med" /></td>
            
            <td align="right">Senha de Empresa:</td>
            <td><input type="text" name="correio_senha" class="input-text med" /></td>
        </tr>

        <tr>
            <td></td>
            <td>
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