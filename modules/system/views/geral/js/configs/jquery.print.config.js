//<![CDATA[
$(function () {
    $("#ele2").find('.print-link').on('click', function () {
        //Print ele2 with default options
        $.print("#ele2");
    });
    $("#ele4").find('button').on('click', function () {
        //Print ele4 with custom options
        $("#ele4").print({
            globalStyles: false,
            mediaPrint: false,
            // stylesheet: "http://fonts.googleapis.com/css?family=Inconsolata",
            iframe: false,
            noPrintSelector: ".avoid-this"
            // prepend: "Hello World!!!<br/>",
            // append: "<br/>Buh Bye!"
        });
    });
});
//]]>