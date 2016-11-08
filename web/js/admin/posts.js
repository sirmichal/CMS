$("#add-img-modal").on('show.bs.modal', function () {
    var modal = $(this);
    $.get(Routing.generate('posts_modal_add_img_render'), null, function (view) {
        modal.html(view);
    });
});


$("#add-img-modal").on('click', '.add-post-img', function () {
    $(this).siblings().removeClass("add-post-img-selected");
    if ($(this).hasClass('add-post-img-selected')) {
        $(this).removeClass("add-post-img-selected");
        $("#add-post-select-img-btn").attr("disabled", true);
    } else {
        $(this).addClass("add-post-img-selected");
        $("#add-post-select-img-btn").attr("disabled", false);
    }
});


$("#add-img-modal").on('hide.bs.modal', function () {
    var mediaId = null;

    $(".add-post-img").each(function () {
        if ($(this).hasClass("add-post-img-selected")) {
            mediaId = $(this).attr("data-id");
        }
    });

    $('#thumbnail-field').val(mediaId);

    $.get(Routing.generate('get_media_specific_cache'), {id: mediaId, filter: 'thumbnails_large'}, function (src) {
        $('#post-thumb-img').attr("src", src);
    });
});
