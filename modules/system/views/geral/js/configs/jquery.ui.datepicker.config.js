jQuery(document).ready(function() {
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
    $.datepicker.setDefaults({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        prevText: '',
        nextText: ''
    });
    
    $('.datepicker').live('focus', function() {
        $(this).datepicker();
    });        
    
    $('.datepickerNasc').datepicker({
        minDate: '-100Y',
        maxDate: '-18Y'
    });
    
    $('.datepickerFut').datepicker({
        minDate: '+1D'
    });
    
    $('.datepickerPas').live('focus', function() {
        $(this).datepicker({
            maxDate: '0D'
        });
    });
    
    var dates = $('.datepickerFrom, .datepickerTo').datepicker({
        onSelect: function(selectedDate) {
            var option = $(this).hasClass('datepickerFrom') ? 'minDate' : 'maxDate';
            var instance = $(this).data('datepicker');
            var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates.not(this).datepicker('option', option, date);
        }
    });
    
    var dates1 = $('.datepickerFrom1, .datepickerTo1').datepicker({
        maxDate: '0Y',
        onSelect: function(selectedDate) {
            var option = $(this).hasClass('datepickerFrom1') ? 'minDate' : 'maxDate';
            var instance = $(this).data('datepicker');
            var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates1.not(this).datepicker('option', option, date);
        }
    });
    
    var dates2 = $('.datepickerFrom2, .datepickerTo2').datepicker({
        minDate: '0Y',
        maxDate: '+10Y',
        onSelect: function(selectedDate) {
            var option = $(this).hasClass('datepickerFrom2') ? 'minDate' : 'maxDate';
            var instance = $(this).data('datepicker');
            var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates2.not(this).datepicker('option', option, date);
        }
    });
    
    var dates3 = $('.datepickerFrom3, .datepickerTo3').datepicker({
        minDate: '0Y',
        maxDate: '+10Y',
        onSelect: function(selectedDate) {
            var option = this.id == 'from3' ? 'minDate' : 'maxDate';
            var instance = $(this).data('datepicker');
            var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates3.not(this).datepicker('option', option, date);
        }
    });
    
    var dates5 = $('.datepickerFrom5, .datepickerTo5').datepicker({
        dateFormat: 'dd/mm',
        onSelect: function(selectedDate) {
            var option = this.id == 'from5' ? 'minDate' : 'maxDate';
            var instance = $(this).data('datepicker');
            var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates5.not(this).datepicker('option', option, date);
        }
    });
    
});