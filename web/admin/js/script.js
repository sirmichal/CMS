$('.edit-row').hover(
        function () {
            $(this).find('a').css('visibility', 'visible');
        },
        function () {
            $(this).find('a').css('visibility', 'hidden');
        }
);

var enlarge_anim_time = 250;
$('#label-upload').hover(
    function(){
        $(this).children("img").stop().animate({width: "+=30", height: "+=30"}, enlarge_anim_time);
        $(this).stop().animate({ top: "-=15", width: "+=30"}, enlarge_anim_time);
    },
    function(){
        $(this).children("img").stop().animate({width: "-=30", height: "-=30"}, enlarge_anim_time);
        $(this).stop().animate({top: "+=15", width: "-=30"}, enlarge_anim_time);
});
