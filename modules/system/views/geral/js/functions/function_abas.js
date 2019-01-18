$(function() {
    function abas(boolHide) {
        var elem = "";
        $('.nav-aba input').each(function() {
            if ($(this).is(':checked')) {
                elem = $(this);
            }
        });

        var elemPai = elem.parent("label").parent("li");        
        if (elemPai.hasClass('selected')) {
            return false;
        }
        
        if (boolHide) {
            hide($('.aba'), $('.aba input, .aba select'));
        }
            
        var div = elemPai.attr('href');
        show($(div), $(div + ' input, ' + div + ' select'));

        if (boolHide) {
            $('.nav-aba li input').removeAttr('checked');
        }
        $('.nav-aba li[href="' + div + '"] input').attr('checked', true);

        if (boolHide) {
            $('.nav-aba li').removeAttr('class');
        }
        elemPai.attr('class', 'selected');
    }
    
    abas();
    $('.nav-aba li').click(function() {
        abas(true);
    });
    
});