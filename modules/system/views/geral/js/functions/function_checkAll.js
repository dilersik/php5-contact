cont = 0;

function checkAll(input_name, check_all, selec_all){
    var inputs = document.getElementsByName(input_name);
    for (var i = 0; i < inputs.length; i++) {
        var x = inputs[i];
        if (x.name == input_name) {
            x.checked = document.getElementById(check_all).checked;
        }
    }

    if (selec_all != '') {
        var elem = '';
        if (cont == 0) {
            elem = document.getElementById(selec_all);
            elem.innerHTML = "Deselecionar todos";
            cont = 1;
        } else {
            elem = document.getElementById(selec_all);
            elem.innerHTML = "Selecionar todos";
            cont = 0;
        }
    }
}