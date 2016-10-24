var img_selected = [];

$("img.media-library-img").click(function () {
    $(this).toggleClass("media-library-selected");
    var filename = extract($(this).attr("src"));
    var index = img_selected.indexOf(filename);
    if (-1 === index) {
        img_selected.push(filename);
    } else {
        img_selected.splice(index, 1);
    }

});

$("#btn-delete-img").click(function () {
    
    $.post("delete", {'data': JSON.stringify(img_selected)}, function(data) {
        if("OK" === data)
        {
            location.reload();
        }
    });
});

var extract = function (str) {
    return str.split('\\').pop().split('/').pop();
}

$(".add-post-img").click(function () {
    $(this).siblings().removeClass("add-post-img-selected");
    if($(this).hasClass('add-post-img-selected')) {
        $(this).removeClass("add-post-img-selected");
        $("#add-post-select-img-btn").attr("disabled", true);
    } else {
        $(this).addClass("add-post-img-selected");
        $("#add-post-select-img-btn").attr("disabled", false);
    }
});


$("#showImagesModal").on('hide.bs.modal', function () {
    var thumbSrc = null;
    var thumbId = null;

    $(".add-post-img").each(function () {
        if($(this).hasClass("add-post-img-selected")) {
            thumbSrc = $(this).attr("src");
            thumbId = $(this).attr("data-id");
        }
    });

    $('#thumbnailIdField').val(thumbId);
    $('#post-thumb-img').attr("src", thumbSrc);
});

