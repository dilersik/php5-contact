$(document).ready(function(){    
    jQuery('#form_contact').validate({
        rules: {
            status: { required: true },
            name: {
                required: true,
                alpha: true,
                maxWords: 8,
                rangelength: [2, 70]
            },
            email: {
                required: true,
                email: true,
                maxlength: 100
            },
            fulltel: { phoneNoMask: true },
            msg: { maxlength: 1000 },
            files: {
                required: true,
                accept: "doc|docx|pdf"
            }
        }, messages: {
            files: { accept: "Por favor, arquivo somente em: doc ou pdf" }
        }
    });
});