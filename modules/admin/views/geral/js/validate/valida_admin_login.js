$(document).ready(function(){	
    jQuery('#form_admin_login').validate({
        rules: {
            username: { required: true },
            pwd: { required: true }
        }
    });
});