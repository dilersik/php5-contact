$(document).ready(function() {
    $('.numberFormatCelsius_ptBR').priceFormat({
        prefix: '',
        suffix: '°C',
        centsSeparator: ',',
        thousandsSeparator: '.',
        limit: 4,
        allowNegative: true
    });
    
    $('.numberFormatKg_ptBR').priceFormat({
        prefix: '',
        suffix: ' kg',
        centsSeparator: ',',
        thousandsSeparator: '.',
        limit: 10,
        centsLimit: 3
    });
    
    $('.numberFormatInt_ptBR').priceFormat({
        prefix: '',
        centsSeparator: '',
        thousandsSeparator: '.',
        limit: 8,
        centsLimit: 0
    });
    
    $('.numberFormatCen_ptBR').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.',
        limit: 8,
        centsLimit: 2
    });
    
    $('.numberFormatMil_ptBR').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.',
        limit: 8,
        centsLimit: 3
    });
    
    $('.numberFormatMilNeg_ptBR').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.',
        limit: 8,
        centsLimit: 3,
        allowNegative: true
    });
    
    $('.numberFormatPerCent_ptBR').priceFormat({
        prefix: '-',
        suffix: '%',
        centsSeparator: ',',
        thousandsSeparator: '.',
        limit: 4
    });
    
    function numberFormatPosPerCent_ptBR(elem) {
        $(elem).priceFormat({
            prefix: '',
            suffix: '%',
            centsSeparator: ',',
            thousandsSeparator: '.',
            limit: 4
        });
    }
    numberFormatPosPerCent_ptBR('.numberFormatPosPerCent_ptBR');
    $('.numberFormatPosPerCent_ptBR').live('change focus', function() {
        numberFormatPosPerCent_ptBR(this);
    });

    function numberFormatPosPerCem_ptBR(elem) {
        $(elem).priceFormat({
            prefix: '',
            suffix: '%',
            centsSeparator: ',',
            thousandsSeparator: '.',
            limit: 5
        });
    }
    numberFormatPosPerCem_ptBR('.numberFormatPosPerCem_ptBR');
    $('.numberFormatPosPerCem_ptBR').live('change focus', function(){
        numberFormatPosPerCem_ptBR(this);
    });
    
    $('.metrosFormat_ptBR').priceFormat({
        prefix: '',
        suffix: ' m',
        centsSeparator: ',',
        thousandsSeparator: '.',
        limit: 8
    });
    
    function dollarFormat_ptBR(elem) {
        $(elem).priceFormat({
            prefix: 'U$ ',
            centsSeparator: ',',
            thousandsSeparator: '.',
            limit: 10
        });
    }
    dollarFormat_ptBR('.dollarFormat_ptBR');
    $('.dollarFormat_ptBR').live('change focus', function() {
        dollarFormat_ptBR(this);
    });
    
    function moneyFormat_ptBR(elem) {
        $(elem).priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            thousandsSeparator: '.',
            limit: 10
        });
    }
    moneyFormat_ptBR('.moneyFormat_ptBR');
    $('.moneyFormat_ptBR').live('change focus', function() {
        moneyFormat_ptBR(this);
    });
    
    function moneyFormatNeg_ptBR(elem) {
        $(elem).priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            thousandsSeparator: '.',
            limit: 10,
            allowNegative: true
        });
    }
    moneyFormatNeg_ptBR('.moneyFormatNeg_ptBR');
    $('.moneyFormatNeg_ptBR').live('change focus', function() {
        moneyFormatNeg_ptBR(this);
    });
    
    function numberFormatKgAllBR(elem) {
        $(elem).priceFormat({
            prefix: '',
            suffix: ' kg',
            centsSeparator: ',',
            thousandsSeparator: '.',
            limit: 8,
            centsLimit: 3,
            allowNegative: true
        });
    }
    numberFormatKgAllBR('.numberFormatKgAllBR');
    $('.numberFormatKgAllBR').live('change focus', function(){
        numberFormatKgAllBR(this);
    });
    
});