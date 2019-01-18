$(function() {    
    $('.nav-aba li').click(function() {        
        if (!$(this).hasClass('selected')) {
            hide($('.aba'), $(''));
            var div = $(this).attr('href');
            show($(div), $(''));
        }
        
        $('.nav-aba li').removeAttr('class');
        $(this).attr('class', 'selected');
    });
});