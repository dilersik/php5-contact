function calcTotal(subtotal) {
    var total = parseFloat(0);

    $(subtotal).each(function() {
        subtotal = replaceAllMoneyBR($(this).val());
        if (subtotal > 0) {
			total = total + subtotal;
		}
    })
    
    return total;
}