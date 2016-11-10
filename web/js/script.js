$(function () {
    $("#slides").slidesjs({
        width: 1920,
        height: 500,
        play: {
            active: false,
            auto: true,
            interval: 2000,
            swap: false
        },
        navigation: {
            active: false
        },
        pagination: {
            active: false
        }
    });
});

$('.last-post').hover(function () {
    $(this).stop().animate({backgroundColor: 'rgba(0, 0, 0, 0.8)'}, 200);
}, function () {
    $(this).stop().animate({backgroundColor: 'rgba(0, 0, 0, 0.6)'}, 200);
})