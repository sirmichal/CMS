$(function () {
    if ($(".sidebar").length === 0) {
        $(".content").css("padding-left", "0px");
    }


    $(".topitem").click(function () {
        if ($(this).siblings().length > 0) {
            $(this).nextUntil(".topitem").slideToggle(200);

            var arrow = $(this).find("span");
            var text = arrow.text();
            arrow.text(text === "\u25C4" ? "\u25BD" : "\u25C4");
        }
    });


});