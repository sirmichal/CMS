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
    var mediaId = null;

    $(".add-post-img").each(function () {
        if($(this).hasClass("add-post-img-selected")) {
            mediaId = $(this).attr("data-id");
        }
    });

    $('#thumbnailIdField').val(mediaId);
    
    $.get('../getThumbSrc', {id: mediaId, filter: 'thumbnails_large'}, function (src) {
        $('#post-thumb-img').attr("src", src);
    });
});


$('.edit-post-row').hover(
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