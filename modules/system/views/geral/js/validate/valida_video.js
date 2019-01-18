$(document).ready(function() {
    jQuery('#form_video').validate({
        rules: {
            local: { required: true },
            url: {
                required: true,
                url: true
            },
            legend: {
                required: true,
                rangelength: [2, 100]
            }
        }
    });
});