var selected_img_2_add = [];

$('#add-img-modal').on('click', '.slider-img', function() {
    var id = $(this).attr('data-id');
    
    if($(this).hasClass('slider-img-selected')) {
        $(this).removeClass('slider-img-selected');
        var index = selected_img_2_add.indexOf(id);
        if (index > -1) {
            selected_img_2_add.splice(index, 1);
        }
    } else {
        $(this).addClass('slider-img-selected');
        selected_img_2_add.push(id);
    }
});

var selected_img_2_delete = [];

$('.slider-img').click(function () {
    var id = $(this).attr('data-id');

    if ($(this).hasClass('slider-img-selected')) {
        $(this).removeClass('slider-img-selected');
        var index = selected_img_2_delete.indexOf(id);
        if (index > -1) {
            selected_img_2_delete.splice(index, 1);
        }
    } else {
        $(this).addClass('slider-img-selected');
        selected_img_2_delete.push(id);
    }
});


// handle click on submit btn in modal dialog
$('#add-img-modal').on('click', '#add-img-modal-btn', function () {
    $.post(Routing.generate('slider_modal_add_img_submit'), {ids: JSON.stringify(selected_img_2_add)}, function() {
        location.reload();
    });
});

// handle click on delete btn
$('#delete-img-btn').click(function () {
    $.post(Routing.generate('slider_delete_img'), {ids: JSON.stringify(selected_img_2_delete)}, function () {
        location.reload();
    });
});

// render view of modal dialog
$("#add-img-modal").on('show.bs.modal', function () {
    var modal = $(this);
    $.get(Routing.generate('slider_modal_add_img_render'), null, function (view) {
        modal.html(view);
    });
});
