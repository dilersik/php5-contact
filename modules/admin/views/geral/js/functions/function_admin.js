function cleanInput(elem) {
    $(elem).val('');
}

$(document).ready(function() {
    var HTTP_SERVER = $('#HTTP_SERVER').val();
    
    // help
    $('i.info').each(function(){
        var text = $(this).text();
        $(this).html('<img src="' + HTTP_SERVER + '/modules/system/views/geral/img/help_icon.png" alt="Help" class="this_tooltip help" title="' + text + '" />');
    });
    
    // atualiza contador
    $("body").click(function() {
        $.post(HTTP_SERVER + '/?pag=adminAddVA', {
            funcao: 'updateLogin'
        },
            function(valor) {
                $("#admin_updateDate").val(valor);
                // atualizaContador($("#admin_updateDate").val(), 'resTimer');
            }
        );
    });

    atualizaContador($("#admin_updateDate").val(), 'resTimer');
});