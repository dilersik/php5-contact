$(document).ready(function() {
    $('.mask_cep').mask('99999-999');
    $('.mask_cnpj').mask('99.999.999/9999-99');
    $('.mask_cnpjOpt').mask('?99.999.999/9999-99');
    $('.mask_cpf').mask('999.999.999-99');
    $('.mask_cpfOpt').mask('?999.999.999-99');
    $('.mask_ddd').mask('99');
    $('.mask_date').live('focus', function() {
        $(this).mask('99/99/9999');
    });
    $('.mask_dayMonth').mask('99/99');
//    $('.mask_tel').mask('9999-9999?9');
//    $('.mask_cel').mask('9999-9999?9');
    $('.mask_time').mask('99:99:99');
});