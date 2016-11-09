$("#single-img-modal").on('show.bs.modal', function (e) {
    var invoker = $(e.relatedTarget);
    var id = invoker.attr('data-id');

    $.get(Routing.generate('get_modal'), {id: id}, function (view) {
        $('#single-img-modal').html(view);
    });
});

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
