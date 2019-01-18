function getCheckedValue(input) {
    a = "";
    $(input).each(function() {
        if ($(this).is(':checked')) {
            a += $(this).val() + ',';
        }
    });
    return a.substring(0, a.length - 1);
}