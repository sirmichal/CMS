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
    $.post("delete", JSON.stringify(img_selected), function(data) {
        if("OK" === data)
        {
            location.reload();
        }
    });
});

var extract = function (str) {
    return str.split('\\').pop().split('/').pop();
}