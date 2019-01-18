jQuery(function($) {

    var multiTags = $(".clone");

    function handler(e) {
        // get the element who trigged the event
        var jqEl = $(e.currentTarget);
        // get his parent div
        var tag = jqEl.closest(".clone");
        // get the reference clone
        cloneref = parseInt(tag.attr('data-cloneref'));
        // check which action we should perform
        switch (jqEl.attr("data-action")) {
            case "add":
                if (tag.find('textarea').hasClass('tinymceFocus')) {
                    if (typeof tinymce != 'undefined') {
                        tinymce.remove();
                        // $('.tinymceFocus').show();
                        $('.divTiny').show();
                    }
                }
                // clone the tag (div), reset his input text field
                // and place the new tag after the current one
                code = (new Date).getTime();
                clone = tag.clone();
                
                clone.find('.cloneChange').attr('data-ref', 'itm_' + code);
                clone.find('.cloneChangeChange').addClass('itm_' + code);
                clone.find('.cloneChangeChange').attr('ref', 'itm_' + code);
                clone.find('.cloneChangeChange').removeClass('itm_001');
                clone.find('.disableInClones').remove();
                clone.attr('data-cloneref', cloneref + 1);
                tag.after(clone.find("input[type=text]").val("").end());
                tag.after(clone.find("input[type=file]").val("").end());
                tag.after(clone.find("input").removeAttr('checked').end());
                tag.after(clone.find("option").removeAttr('selected').end());
                tag.after(clone.find("textarea").val("").end());
                tag.after(clone.find("textarea").removeClass('tinymce').end());
                tag.after(clone.find(".cloneCleanText").text("").end());
                
                return false;
                break;
                
            case "del":
                // remove the element
                if (cloneref !== 0) {
                    if (confirm("Tem certeza que deseja remover este item?")) {
                        tag.remove();
                    }
                }
                return false;
                break;
        }
    }

    multiTags.find("a").live("click", handler);
});