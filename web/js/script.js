$("#single-img-modal").on('show.bs.modal', function (e) {
    var invoker = $(e.relatedTarget);
    var id = invoker.attr('data-id');

    $.get(Routing.generate('get_modal'), {id: id}, function (view) {
        $('#single-img-modal').html(view);
    });
});

$("#all-img-modal").on('show.bs.modal', function () {
    var modal = $(this);
    $.get(Routing.generate('modal_post'), null, function (view) {
        modal.html(view);
    });
});


$("#all-img-modal").on('click', '.add-post-img', function () {
    $(this).siblings().removeClass("add-post-img-selected");
    if($(this).hasClass('add-post-img-selected')) {
        $(this).removeClass("add-post-img-selected");
        $("#add-post-select-img-btn").attr("disabled", true);
    } else {
        $(this).addClass("add-post-img-selected");
        $("#add-post-select-img-btn").attr("disabled", false);
    }
});


$("#all-img-modal").on('hide.bs.modal', function () {
    var mediaId = null;

    $(".add-post-img").each(function () {
        if($(this).hasClass("add-post-img-selected")) {
            mediaId = $(this).attr("data-id");
        }
    });

    $('#thumbnail-field').val(mediaId);

    $.get(Routing.generate('get_media_specific_cache'), {id: mediaId, filter: 'thumbnails_large'}, function (src) {
        $('#post-thumb-img').attr("src", src);
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

$(document).ready(function () {
    $('#show-posts-table').dataTable({
        lengthMenu: [ 5, 10, 25, 50],
        bLengthChange: false,
        order: [[ 3, "asc" ]],
        language: {
            "processing": "Przetwarzanie...",
            "search": "Szukaj:",
            "lengthMenu": "Pokaż _MENU_ pozycji",
            "info": "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",
            "infoEmpty": "Pozycji 0 z 0 dostępnych",
            "infoFiltered": "(filtrowanie spośród _MAX_ dostępnych pozycji)",
            "infoPostFix": "",
            "loadingRecords": "Wczytywanie...",
            "zeroRecords": "Nie znaleziono pasujących pozycji",
            "emptyTable": "Brak danych",
            "paginate": {
                "first": "Pierwsza",
                "previous": "Poprzednia",
                "next": "Następna",
                "last": "Ostatnia"
            },
            "aria": {
                "sortAscending": ": aktywuj, by posortować kolumnę rosnąco",
                "sortDescending": ": aktywuj, by posortować kolumnę malejąco"
            }
        }
    });
    
    
});

$('#file_upload_form_file').change(function () {
    var name = $(this)[0].files[0]['name'];
    $('#filename-upload').html(name);
});
