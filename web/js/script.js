$(function () {
    $("#slides").slidesjs({
        width: 1920,
        height: 500,
        play: {
            active: false,
            auto: false,
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
    $(this).stop().animate({backgroundColor: 'rgba(79, 188, 132, 0.9)', fontWeight: '400'}, 200);
}, function () {
    $(this).stop().animate({backgroundColor: 'rgba(79, 188, 132, 0.75)', }, 200);
})


$('.big-post-content').each(function () {
    var width = $(this).width();
    var shortenedText = $(this).text().substring(0, width / 2);
    $(this).text(shortenedText);
})