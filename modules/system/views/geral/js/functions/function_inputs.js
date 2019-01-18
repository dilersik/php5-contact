$(document).ready(function(){
    $('input.thisBlur, textarea.thisBlur').focus(function() {
        if ($(this).val() == $(this).attr('title')) {
            $(this).val('');
        }
        
        if ($(this).attr('rel') == 'password') {
            $(this).prop('type', 'password');
        }
    });
    
    $('input.thisBlur, textarea.thisBlur').blur(function() {
        if ($(this).val() == '') {
            $(this).val($(this).attr('title'));
        }
        
        if ($(this).val() == $(this).attr('title') && $(this).attr('rel') == 'password') {
            $(this).prop('type', 'text');
        }
    });
    
    $('input.thisBlur, textarea.thisBlur').each(function() {
        if ($(this).val() == '') {
            $(this).val($(this).attr('title'));
        }
        
        if ($(this).val() == $(this).attr('title') && $(this).attr('rel') == 'password') {
            $(this).prop('type', 'text');
        }
    });
    
    $('.this_CPY').on("click", function () {
        $(this).select();
    });
    $('.this_CPY').on("focus", function () {
        $(this).select();
    });
});