$(document).ready(function(){
    $('.upper').keyup(function(){
        $(this).val($(this).val().toUpperCase());
    }).focus(function() {
        $(this).val($(this).val().toUpperCase());
    }).blur(function() {
        $(this).val($(this).val().toUpperCase());
    }).keyup(function() {
        $(this).val($(this).val().toUpperCase());
    });

    $('.lower').keyup(function(){
        $(this).val($(this).val().toLowerCase());
    }).focus(function() {
        $(this).val($(this).val().toLowerCase());
    }).blur(function() {
        $(this).val($(this).val().toLowerCase());
    }).keyup(function() {
        $(this).val($(this).val().toLowerCase());
    });
});