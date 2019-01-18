jQuery.validator.addMethod("accept", function(value, element, param) {
    var typeParam = typeof param === "string" ? param.replace(/,/g, '|') : "image/*",
    optionalValue = this.optional(element),
    i, file;

    if (optionalValue)
        return optionalValue;

    if ($(element).attr("type") === "file") {
        typeParam = typeParam.replace("*", ".*");
        if (element.files && element.files.length) {
            for(i = 0; i < element.files.length; i++) {
                file = element.files[i];
                if (!file.type.match(new RegExp(".?(" + typeParam + ")$", "i"))) {
                    return false;
                }
            }
        }
    }

    return true;
}, jQuery.format("Please enter a value with a valid mimetype."));

jQuery.validator.addMethod('alpha', function(value, element) {
    return this.optional(element) || /^[a-zA-ZáÁãÃâÂàÀéÉêÊíÍóÓõÕôÔúÚüÜçÇ ]+$/i.test(value);
}, 'Letters only please alpha');

jQuery.validator.addMethod('alphaNumeric', function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9-_.]+$/i.test(value);
}, 'Letters, numbers or underscores only please alphaNumeric');

jQuery.validator.addMethod('alphaNumeric2', function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9áÁãÃâÂàÀéÉêÊíÍóÓõÕôÔúÚüÜçÇ ]+$/i.test(value);
}, 'Letters, numbers or underscores only please alphaNumeric2');

jQuery.validator.addMethod('alphaNumeric3', function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9-.]+$/i.test(value);
}, 'Letters, numbers or underscores only please alphaNumeric3');

jQuery.validator.addMethod('alphaNumeric4', function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9áÁãÃâÂàÀéÉêÊíÍóÓõÕôÔúÚüÜçÇ,/&().\-_+ ]+$/i.test(value);
}, 'Letters, numbers or underscores only please alphaNumeric4');

jQuery.validator.addMethod("bigValThan", function(value, element, param) {
    retorno = true;
    value = replaceAllMoneyBR(value);
    paramNew = replaceAllMoneyBR($(param).val());
    if (value < paramNew) {
        retorno = false;
    }

    return this.optional(element) || retorno;
}, "The Value must be lass than Param.");

jQuery.validator.addMethod('cel', function(value, element) {
//    return this.optional(element) || value.match(/^[6-9][0-9]{3}-[0-9]{4,5}$/);
    return this.optional(element) || (/^[0-9-(). ]+$/i.test(value) && value.length >= 10 && value.length <= 20);
}, 'Only cel');

jQuery.validator.addMethod("checkTwoValues", function(value, element, params) {
    retorno = true;
    value = replaceAllMoneyBR(value);
    param0 = replaceAllMoneyBR($(params[0]).val());
    if (param0 != params[1]) {
        retorno = false;
    }

    return this.optional(element) || retorno;
}, "Please, check the values.");

jQuery.validator.addMethod('cnpj', function(cnpj, element) {
    cnpj = jQuery.trim(cnpj.replace(/[^\d]+/g, ''));
    var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais, retorno = true;
    digitos_iguais = 1;
    if (cnpj.length != 14) {
        retorno = false;
    } else {
        for (i = 0; i < cnpj.length - 1; i ++) {
            if (cnpj.charAt(i) != cnpj.charAt(i + 1)) {
                digitos_iguais = 0;
                break;
            }
        }
        if (digitos_iguais) {
            retorno = false;
        } else {
            tamanho = cnpj.length - 2
            numeros = cnpj.substring(0,tamanho);
            digitos = cnpj.substring(tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i --) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2) {
                    pos = 9;
                }
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0)) {
                retorno = false;
            } else {
                tamanho = tamanho + 1;
                numeros = cnpj.substring(0, tamanho);
                soma = 0;
                pos = tamanho - 7;
                for (i = tamanho; i >= 1;  i--) {
                    soma += numeros.charAt(tamanho - i) * pos --;
                    if (pos < 2) {
                        pos = 9;
                    }
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(1))
                    retorno = false;
            }
        }
    }
    return this.optional(element) || retorno;
}, 'Informe um CNPJ válido.');

jQuery.validator.addMethod('cpf', function(value, element) {
    var cpf = jQuery.trim(value.replace(/[^\d]+/g, ''));
    while (cpf.length < 11) {
        cpf = "0" + cpf;
    }
    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
    var a = [];
    var b = new Number;
    var c = 11;
    for (i = 0; i < 11; i ++){
        a[i] = cpf.charAt(i);
        if (i < 9) b += (a[i] * --c);
    }
    if ((x = b % 11) < 2) {
        a[9] = 0;
    } else {
        a[9] = 11-x;
    }
    b = 0;
    c = 11;
    for (y = 0; y < 10; y ++) {
        b += (a[y] * c --);
    }
    if ((x = b % 11) < 2) {
        a[10] = 0;
    } else {
        a[10] = 11 - x;
    }
    var retorno = true;
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) {
        retorno = false;
    }

    return this.optional(element) || retorno;
}, 'Informe um CPF válido.');

jQuery.validator.addMethod("creditcard", function (a, b) {
    a = jQuery.trim(a.replace(/[^\d]+/g, ''));
    if (/[^0-9 \-]+/.test(a)) {
        return !1;
    }
    var c, d, e = 0, f = 0, g = !1;
    if (a = a.replace(/\D/g, ""), a.length < 13 || a.length > 19) {
        return !1;
    }
    for (c = a.length - 1; c >= 0; c--) {
        d = a.charAt(c), f = parseInt(d, 10), g && (f *= 2) > 9 && (f -= 9), e += f, g = !g;
    }
    
    return this.optional(b) || e % 10 === 0;    
}, "Please enter a valid credit card number.");

jQuery.validator.addMethod('dateBR', function(value, element) {
    value = value.replace(/[^\d]+/g, '');
    
    var retorno = true;
    if (value.length != 8) {
        retorno = false;
    } else {
        var dia = value.substr(0, 2);        
        var mes = value.substr(2, 2);
        var ano = value.substr(4, 4);
        
        if (isNaN(dia) || isNaN(mes) || isNaN(ano) || dia > 31 || mes > 12 ) {
            retorno = false;
        } else if ((mes == 4 || mes == 6 || mes == 9 || mes == 11) && dia == 31) {
            retorno = false;
        } else if (mes == 2 && (dia > 29 || (dia == 29 && ano % 4 != 0))) {
            retorno = false;
        } else if (ano < 1900) {
            retorno = false;
        }
    }
    return this.optional(element) || retorno;
}, 'Campo exige uma Data válida.');

jQuery.validator.addMethod("dateBRRange", function(value, element, param) {
    value = value.replace(/[^\d]+/g, '');
     
    var dia = value.substr(0, 2);
    var mes = value.substr(2, 2);
    var ano = value.substr(4, 4);

    value2 = $(param).val().replace(/[^\d]+/g, '');
    var dia2 = value2.substr(0, 2);
    var mes2 = value2.substr(2, 2);
    var ano2 = value2.substr(4, 4);

    var date1 = new Date(ano, mes, dia);
    var date2 = new Date(ano2, mes2, dia2);

    return this.optional(element) || date1 <= date2;
}, "Please check your dates. The start date must be before the end date.");

jQuery.validator.addMethod("dateBRMonthYearRange2", function(value, element, params) {
    value = value.replace(/[^\d]+/g, '');
     
    var dia = '01';
    var mes = value.substr(0, 2);
    var ano = value.substr(3, 4);

    var dateMin = params[0].replace(/[^\d]+/g, '');
    var dia2 = '01';
    var mes2 = dateMin.substr(0, 2);
    var ano2 = dateMin.substr(3, 4);
    
    var dateMax = params[1].replace(/[^\d]+/g, '');
    var dia3 = '01';
    var mes3 = dateMax.substr(0, 2);
    var ano3 = dateMax.substr(3, 4);

    var dateValue = new Date(ano, mes, dia);
    dateMin = new Date(ano2, mes2, dia2);
    dateMax = new Date(ano3, mes3, dia3);

    return this.optional(element) || (dateValue >= dateMin && dateValue <= dateMax);
}, "Please check your dates. The start date must be before the end date.");

jQuery.validator.addMethod('ddd', function(value, element) {
    return this.optional(element) || /^([1][0]|[1-9][1-9])+$/i.test(value);
}, 'Campo exige um DDD válido.');

jQuery.validator.addMethod("diferencaDeZero", function(value, element, param) {
    retorno = true;
    value = replaceAllMoneyBR(value);
    paramNew = replaceAllMoneyBR($(param).val());
    if (value < 0 && ((paramNew - value * -1) <= 0)) {
        retorno = false;
    }

    return this.optional(element) || retorno;
}, "The difference value must be different than 0.");

jQuery.validator.addMethod("equalTo", function(value, element, param) {
    return this.optional(element) || (value == $(param).val() ? true : false);
}, "The string must be equal than other.");

jQuery.validator.addMethod("extension", function(value, element, param) {
    param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
    return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
}, jQuery.format("Please enter a value with a valid extension."));

jQuery.validator.addMethod("integer", function(value, element) {
    return this.optional(element) || /^-?\d+$/.test(value);
}, "A positive or negative non-decimal number please");

jQuery.validator.addMethod('isLetterOnly_', function(value, element) {
    return this.optional(element) || /^[a-zA-Z-]+$/i.test(value);
}, 'Letters only no acentos');

jQuery.validator.addMethod('maxVal', function(value, element, param) {
    return this.optional(element) || (replaceAllMoneyBR(value) <= param);
}, jQuery.validator.format('Please enter max {0} value.'));

jQuery.validator.addMethod('minVal', function(value, element, param) {
    return this.optional(element) || (replaceAllMoneyBR(value) >= param);
}, jQuery.validator.format('Please enter min {0} value.'));

jQuery.validator.addMethod('miniValThen', function(value, element, param) {
    return this.optional(element) || (replaceAllMoneyBR(value) < replaceAllMoneyBR($(param).val()));
}, jQuery.validator.format('Please enter max {0} value.'));

jQuery.validator.addMethod('moreValThen', function(value, element, param) {
    return this.optional(element) || (replaceAllMoneyBR(value) > replaceAllMoneyBR($(param).val()));
}, jQuery.validator.format('Please enter max {0} value.'));

function getWordCount(wordString) {
    var words = wordString.split(" ");
    words = words.filter(function (words) {
        return words.length > 0;
    }).length;
    return words;
}
//add the custom validation method
jQuery.validator.addMethod("minWords",
        function (value, element, params) {
            return this.optional(element) || getWordCount(value) >= params;
        },
        jQuery.validator.format("A minimum of {0} words is required here.")
        );
jQuery.validator.addMethod("maxWords",
        function (value, element, params) {
            return this.optional(element) || getWordCount(value) <= params;
        },
        jQuery.validator.format("A maximum of {0} words is required here.")
        );
jQuery.validator.addMethod("rangeWords",
        function (value, element, params) {
            var count = getWordCount(value);
            return this.optional(element) || (count >= params[0] && count <= params[1]);
        },
        jQuery.validator.format("A range of {0} and {1} words is required here.")
        );

jQuery.validator.addMethod("notEqual", function(value, element, param) {
    return this.optional(element) || (value == param ? false : true);
}, "The string must be different than other.");

jQuery.validator.addMethod("notEqualTo", function(value, element, param) {
    return this.optional(element) || (value == $(param).val() ? false : true);
}, "The string must be different than other.");

jQuery.validator.addMethod('noSpace', function(value, element) {
    return this.optional(element) || (value.indexOf(' ') < 0 && value != '');
}, 'No space please and don\'t leave it empty.');

jQuery.validator.addMethod('phoneNoMask', function(value, element) {
    return this.optional(element) || (/^[0-9-(). ]+$/i.test(value) && value.length >= 10 && value.length <= 25);
}, 'Only phone number');

jQuery.validator.addMethod('rangeVal', function(value, element, params) {
    value = replaceAllMoneyBR(value);
    return this.optional(element) || (value >= params[0] && value <= params[1]);
}, jQuery.validator.format('Please enter min {0} value.'));

jQuery.validator.addMethod('rangeValThan', function(value, element, params) {
    value = replaceAllMoneyBR(value);
    return this.optional(element) || (value >= replaceAllMoneyBR($(params[0]).val()) && value <= replaceAllMoneyBR($(params[1]).val()));
}, jQuery.validator.format('Please enter min {0} value.'));

jQuery.validator.addMethod('tel', function(value, element) {
//    return this.optional(element) || value.match(/^[2-9][0-9]{3}-[0-9]{4}$/);
    return this.optional(element) || (/^[0-9-(). ]+$/i.test(value) && value.length >= 10 && value.length <= 20);
}, 'Only tel');

jQuery.validator.addMethod('time', function(value, element) {
    var retorno = true;
    if(value.length != 8) {
        retorno = false;
    }
    var horario = value;
    var hora = horario.substr(0, 2);
    var barra1 = horario.substr(2, 1);
    var minuto = horario.substr(3, 2);
    var barra2 = horario.substr(5, 1);
    var segundo = horario.substr(6, 2);

    if (horario.length != 8 || barra1 != ':' || barra2 != ':' || isNaN(hora) || isNaN(minuto) || isNaN(segundo) || hora > 23 || minuto > 59 || segundo > 59) {
        retorno = false;
    }
    
    return this.optional(element) || retorno;
}, 'Campo exige um Horário válido.');

jQuery.validator.addMethod("timeRange", function(value, element, param) {
    var hora = value.substr(0, 2);
    var minuto = value.substr(3, 2);
    var segundo = value.substr(6, 2);

    var hora2 = $(param).val().substr(0, 2);
    var minuto2 = $(param).val().substr(3, 2);
    var segundo2 = $(param).val().substr(6, 2);

    var date1 = new Date(2013, 01, 01, hora, minuto, segundo);
    var date2 = new Date(2013, 01, 01, hora2, minuto2, segundo2);

    return this.optional(element) || date1 <= date2;
}, "Please check your dates. The start date must be before the end date.");

jQuery.validator.addMethod('urlYoutube', function(value, element) {
    return this.optional(element) || value.match(/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/);
}, 'Links from Youtube only');

jQuery.validator.addMethod('year', function(value, element) {
    return this.optional(element) || (value > 1900 && value < 2156);
}, 'Campo exige um Ano válido.');

jQuery.validator.addMethod('oneRequired', function(value, element, param) {
    return this.optional(element) || $(param).val() == '';
}, jQuery.validator.format('Please enter max {0} value.'));