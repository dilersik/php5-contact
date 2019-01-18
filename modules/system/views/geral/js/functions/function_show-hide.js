function show(div, div_all) {
    div.fadeIn(900);
    div_all.removeAttr('disabled');
}
function hide(div, div_all, cleanAll) {
    div.hide();
    div_all.attr('disabled', true);
    
    if (cleanAll) {
        div_all.attr('value', '');
        div_all.removeAttr('checked');
    }
}

$(document).ready(function() {
    $('.thisShowHide').click(function() {
        var input = '#' + $(this).attr('id');
        var div = '#' + $(input).attr('rel');

        if ($(input).attr('checked')) {
            show($(div), $(div + ' input, ' + div + ' select'));
        } else {
            hide($(div), $(div + ' input, ' + div + ' select'));
        }
    });
});