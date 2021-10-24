function error() {
    alert('Oops, something is wrong!');
    location.reload();
}

/*
   Subscribe button
*/
$('.subscribe_tag-btn').on('click', function () {
    let tag_id = ($(this).prop('classList'))[1];
    let button = $(this);

    if (isNaN(tag_id))
        error();

    $.ajax({
        url: '/handler/sub-tag',
        method: 'get',
        dataType: 'html',
        data: {tag_id: tag_id},
        beforeSend: function () {
            button.attr('disabled', true);
        },
        success: function () {
            setTimeout(() => button.attr('disabled', false), 1000);

            if (!button.hasClass('cl')) {
                if (button.children('span').length) {
                    button.children('span').text(Number(button.children('span').text()) + 1);
                } else {
                    button.html(button.text() + ' <span>1</span>');
                }
    
                button.addClass('cl');
            } else {
                if (Number(button.children('span').text()) == 1) {
                    button.text('Подписаться');
                } else {
                    button.html('Подписаться ' + '<span>' +  (Number(button.children('span').text()) - 1) + '</span>');
                }
    
                button.removeClass('cl');
            }
        },
        error: error,
    });
})