$(function () {
    // Messages
    $('.message').hide().append('<span class="close" title="Close Message"></span>').fadeIn('slow');
    $('.message .close').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
        );
    $('.message .close').click(function() {
        $(this).parent().fadeOut('slow', function() {
            $(this).remove();
        });
    });
})