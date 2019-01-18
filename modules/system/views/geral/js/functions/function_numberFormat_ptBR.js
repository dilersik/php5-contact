function numberFormat_ptBR(num, prefix, suffix) {
    x = 0;
    if (num < 0) {
        num = Math.abs(num);
        x = 1;
    }
    if(isNaN(num)) num = '0';
    cents = Math.floor((num * 100 + 0.5) % 100);
    num = Math.floor((num * 100 + 0.5) / 100).toString();
    if (cents < 10) 
        cents = '0' + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
    ret = num + ',' + cents;
    if (x == 1)
        ret = ' - ' + ret;
    return (prefix != undefined ? prefix : '') + ret + (suffix != undefined ? suffix : '');
}

function numFmrt(valor, casas, separdor_decimal, separador_milhar) {
    if (!casas) {
        casas = 2;
    }
    if (!separdor_decimal) {
        separdor_decimal = ',';
    }
    if (!separador_milhar) {
        separador_milhar = '.';
    }
    
    var valor_total = parseInt(valor * (Math.pow(10, casas)));
    var inteiros = parseInt(parseInt(valor * (Math.pow(10, casas))) / parseFloat(Math.pow(10, casas)));
    var centavos = parseInt(parseInt(valor * (Math.pow(10, casas))) % parseFloat(Math.pow(10, casas)));

    if (centavos % 10 == 0 && centavos + "".length < 2) {
        centavos = centavos + "0";
    } else if (centavos < 10) {
        centavos = "0" + centavos;
    }

    var milhares = parseInt(inteiros / 1000);
    inteiros = inteiros % 1000;

    var retorno = "";

    if (milhares > 0) {
        retorno = milhares + "" + separador_milhar + "" + retorno
        if (inteiros == 0) {
            inteiros = "000";
        } else if (inteiros < 10) {
            inteiros = "00" + inteiros;
        } else if (inteiros < 100) {
            inteiros = "0" + inteiros;
        }
    }
    retorno += inteiros + "" + separdor_decimal + "" + centavos;


    return retorno;
}

function numberFmtFixBR(num, decimals) {
    if (!decimals || decimals == undefined) {
        decimals = 2;
    }
    
    return replaceAll(num.toFixed(decimals), '.', ',');
}