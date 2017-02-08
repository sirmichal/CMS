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

$('#footer-arrow').click(function () {
    var body = $('body');
    body.stop().animate({ scrollTop: 0 }, '400', 'swing');
});

$('.sidebar-single-entry').hover(
    function () {
        $(this).children('.sidebar-single-entry-arrow,.categories-single-entry-counter').stop().animate({'background-color': '#447097'}, 150);
        $(this).children('.single-entry-content').stop().animate({'color': '#447097'}, 150);
    },
    function () {
        $(this).children('.sidebar-single-entry-arrow,.categories-single-entry-counter').stop().animate({'background-color': 'gray'}, 150);
        $(this).children('.single-entry-content').stop().animate({'color': 'gray'}, 150);

    }
);

$('.big-post').hover(function() {
    $(this).find('.big-post-thumbnail-img').addClass('enlarge-big-post-img');
    $(this).find('.big-post-title').css({'color': '#447097'});
    $(this).find('.big-post-content').css({'color': '#447097'});
}, function() {
    $(this).find('.big-post-thumbnail-img').removeClass('enlarge-big-post-img');
    $(this).find('.big-post-title').css({'color': 'black'});
    $(this).find('.big-post-content').css({'color': 'black'});
});


$(function(){
    $('#menu').slicknav({
        label: '',
        brand: 'Michał Turemka - nowy blog'
    });
});


$(function(){
    $('nav').data('size','big');
    $(window).scrollTop(0);
});

$(window).scroll(function () {
    var scrollTop = $(window).scrollTop();
    var animationTime = 150;
    var nav = $("nav");
    var title = nav.find("#nav-title-wrapper");
    if (nav.data("size") == "big" && scrollTop > 100) {
        nav.data("size", "small");
        nav.stop().animate({"height": 80}, animationTime);
        title.stop().fadeOut(animationTime);
        console.log("Minified navbar");
    }
    else if (nav.data("size") == "small" && scrollTop <= 100) {
        nav.data("size", "big");
        nav.stop().animate({"height": 150}, animationTime);
        title.stop().fadeIn(animationTime);
        console.log("Maxified navbar");
    }
});

