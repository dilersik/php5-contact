$(document).ready(function() {
    jQuery('#form_define').validate({
        rules: {
            status: {
                required: true,
                min: 1
            },
            page_title: {
                required: true,
                rangelength: [2, 255]
            },
            page_meta_keywords: {
                required: true,
                rangelength: [2, 255],
                minWords: [2]
            },
            page_meta_description: {
                required: true,
                rangelength: [2, 255],
                minWords: [5]
            },
            page_nice_url: {
                isLetterOnly_: true,
                rangelength: [1, 50]
            },
            page_analytics_code: { rangelength: [12, 50] },
            company_cnpj: { cnpj: true },
            company_state_registration: {
                alphaNumeric3: true,
                rangelength: [4, 20]
            },
            company_corporate_name: {
                alphaNumeric4: true,
                rangelength: [5, 60],
                minWords: 2
            },
            company_fancy_name: {
                required: true,
                alphaNumeric4: true,
                rangelength: [2, 60]
            },
            company_email: {
                required: true,
                email: true
            },
            company_tel: { rangelength: [10, 15] },
            company_cel: { rangelength: [10, 15] },
            company_tel2: { rangelength: [10, 15] },
            company_cel2: { rangelength: [10, 15] },
            company_whatsapp: { rangelength: [10, 15] },
            company_address: { rangelength: [2, 240] },
            company_address2: { rangelength: [2, 240] },
            company_cep_origem: { required: true },
            company_facebook: {
                url: true,
                maxlength: 200
            },
            company_instagram: {
                url: true,
                maxlength: 200
            },
            company_linkedin: {
                url: true,
                maxlength: 200
            },
            company_twitter: {
                url: true,
                maxlength: 200
            },
            company_youtube: {
                url: true,
                maxlength: 200
            },
            correio_empresa: { rangelength: [2, 20] },
            correio_senha: { rangelength: [2, 20] }
        }
    });
});