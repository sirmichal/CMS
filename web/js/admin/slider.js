var selected_img = [];

$('.slider-img').click(function() {
    var id = $(this).attr('data-id');
    
    if($(this).hasClass('slider-img-selected')) {
        $(this).removeClass('slider-img-selected');
        var index = selected_img.indexOf(id);
        if (index > -1) {
            selected_img.splice(index, 1);
        }
    } else {
        $(this).addClass('slider-img-selected');
        selected_img.push(id);
    }
});

$('#slider-submit-btn').click(function(e) {
    e.preventDefault();
    
    
    $.post(Routing.generate('save_slider'), {ids: JSON.stringify(selected_img)}, function(e) {
        console.log(e);
    });
});