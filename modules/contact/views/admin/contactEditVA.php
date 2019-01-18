<?php
ContactC::controller();
$getByID = ContactC::contactEdit();
include_once DIR_INCLUDES_ADMIN . '/topVA.inc.php';
SystemC::printTitle('Contato - Editar');
?>
<form id="form_contact" action="" method="post">
    <div class="row">
        <div class="form-group col-md-4">
            <label for="selectStatus">Status</label>
            <select name="status" id="selectStatus" class="form-control">
                <option></option>
                <?php
                foreach (SystemVO::getArray_status() as $key => $value) {
                    echo '<option value="' . $key . '" ' . ($key == $getByID->getStatus() ? 'selected="selected"' : "") .'>' . $value . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
         
    <div class="row">
        <div class="form-group col-md-6">
            <label for="inpTxtName">Nome:</label>
            <input type="text" name="name" id="inpTxtName" class="form-control upper" value="<?= $getByID->getName() ?>" />
        </div>
    </div>
        
    <div class="row">
        <div class="form-group col-md-6">
            <label for="inpTxtEmail">Email:</label>
            <input type="email" name="email" id="inpTxtEmail" class="form-control lower" value="<?= $getByID->getEmail() ?>" />
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-md-4">
            <label for="inpTxtFulltel">DDD + Telefone:</label>
            <input type="tel" name="fulltel" id="inpTxtFulltel" class="form-control" value="<?= $getByID->getFullTel() ?>" />
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-md-4">           
            <input type="hidden" name="contact_id" id="contact_id" value="<?= $getByID->getId() ?>" />
            <input type="hidden" name="funcao" value="Alterar" />
            <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i> Alterar e Salvar</button>
            <button onclick="javascript:history.back();" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
        </div>
    </div>
</form>

<?php
echo ContactC::showPostUpdateText($getByID);

include_once DIR_INCLUDES_ADMIN . '/rodapeVA.inc.php';
