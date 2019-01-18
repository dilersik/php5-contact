$(window).on('load', function() {
    $('#loadingWindow').hide();  
});
$(document).ready(function() {
    $('#loadingWindow').click(function() {
        return false;
    });
});