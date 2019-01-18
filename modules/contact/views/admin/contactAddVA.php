<?php
ContactC::controller();
ContactC::addRequireScript();
include_once DIR_INCLUDES_ADMIN . '/topVA.inc.php';
SystemC::printTitle('Contatos - Cadastrar');
?>
<form id="form_contact" action="" method="post">
    <div class="row">
        <div class="form-group col-md-4">
            <label for="selectStatus">Status</label>
            <select name="status" id="selectStatus" class="form-control">
                <option></option>
                <?php
                foreach (SystemVO::getArray_status() as $key => $value) {
                    echo '<option value="' . $key . '">' . $value . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
         
    <div class="row">
        <div class="form-group col-md-6">
            <label for="inpTxtName">Nome:</label>
            <input type="text" name="name" id="inpTxtName" class="form-control upper" />
        </div>
    </div>
        
    <div class="row">
        <div class="form-group col-md-6">
            <label for="inpTxtEmail">Email:</label>
           <input type="email" name="email" id="inpTxtEmail" class="form-control lower" />
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-md-4">
            <label for="inpTxtFulltel">DDD + Telefone:</label>
            <input type="tel" name="fulltel" id="inpTxtFulltel" class="form-control" />
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-md-4">           
            <input type="hidden" name="contact_id" id="contact_id" value="0" />
            <input type="hidden" name="funcao" value="Cadastrar" />
            <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i> Cadastrar e Salvar</button>
            <button onclick="javascript:history.back();" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
        </div>
    </div>
</form>

<?php include_once DIR_INCLUDES_ADMIN . '/rodapeVA.inc.php';