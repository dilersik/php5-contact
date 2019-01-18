$(document).ready(function() {
    var CHECK_REMOTE = $('#HTTP_SERVER').val() + '/?pag=adminAddVA&funcao=existAdmin&admin_id=' + $('#admin_id').val();
    
    jQuery('#form_admin').validate({
        rules: {
            status: {
                required: true,
                min: 1
            },
            'admin_area_id[]': { required: true },
            name: {
                required: true,
                alpha: true,
                rangelength: [2, 20],
                maxWords: 1
            },
            lastname: {
                alpha: true,
                rangelength: [2, 50],
                maxWords: 7
            },
            email: {
                required: true,
                email: true,
                maxlength: 100,
                remote: CHECK_REMOTE
            },
            username: {
                required: true,
                alphaNumeric: true,
                maxlength: 20,
                remote: CHECK_REMOTE
            },
            pwd: {
                required: true,
                notEqualTo: 'input[name=username]',
                rangelength: [6, 20]
            },
            pwd_copy:{
                required: true,
                equalTo: '#pwd'
            },
            pwd_atual: { required: true }
        },
        messages: {
            pwd: { notEqualTo: 'Por favor, não utilize o Login como senha.' },
            pwd_copy:{ equalTo: 'Por favor, repita a mesma Senha digitada.' }
        }
    });
});