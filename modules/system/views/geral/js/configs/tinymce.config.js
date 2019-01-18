$(document).ready(function() {
    function tinymceInit(selector) {
        tinymce.init({
            language: "pt_BR",
            selector: selector,
            convert_urls: false,
            relative_urls: false,
            remove_script_host: false,
            document_base_url: $('#HTTP_SERVER').val(),
            paste_word_valid_elements: "a,b,i,u,br,p,b,div,strong,em,li,ul,h1,h2,h3,h4,h5,h6,span,a,pre,table,tbody,tfoot,thead,tr,td,th,tt",
            plugins: [
                "advlist autolink lists textcolor link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "newdocument,|,pasteword,|,code,cleanup,|,bold,italic,underline,|,forecolor,backcolor,|,link,unlink,|,fontsizeselect,|,alignleft,aligncenter,alignright,alignjustify,|,formatselect,|,image,media,|,tablecontrols,|,fullscreen"
        });
    }
    
    tinymceInit("textarea.tinymce");
    
    $('.tinymceFocus').live('click', function(){
        $(this).removeProp('aria-hidden');
        $(this).removeAttr('id');
        
        tinymceInit('textarea[ref=' + $(this).attr('ref') + ']');
    });
});