$('.edit-row').hover(
        function () {
            $(this).find('a').css('visibility', 'visible');
        },
        function () {
            $(this).find('a').css('visibility', 'hidden');
        }
);

$('#file_upload_form_file').change(function () {
    var name = $(this)[0].files[0]['name'];
    $('#filename-upload').html(name);
});

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
