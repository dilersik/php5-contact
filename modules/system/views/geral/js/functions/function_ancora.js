$(document).ready(function () {
    $('.this_ancora').click(function () {
        $('html,body').animate({
            scrollTop: $($(this).data('vai')).offset().top
        }, 1000);
        return false;
    });

    // redes
    var $sidebar = $("#sidebar_redes"),
            $window = $(window),
            offset = $sidebar.offset(),
            topPadding = 15,
            $scroll = $(window).scrollTop();

    $window.scroll(function () {
        if ($window.scrollTop() > offset.top) {
            $sidebar.stop().animate({
                marginTop: $window.scrollTop() - offset.top + topPadding
            });
        } else {
            $sidebar.stop().animate({
                marginTop: 0
            });
        }
    });

    
});