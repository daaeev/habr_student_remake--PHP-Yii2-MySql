function authCheck() {
    if (!$('.answer_form_block').length) {
        window.location.href = '/login';
        return false;
    }

    return true;
}

/*
   Button for viewing comments
*/
$('.comments-btn').on('click', function () {
    if(authCheck()) { 
        if (!$(this).hasClass('view')) {
            if ($(this).hasClass('main_comments-btn')) {
                $('.main_comments').css('display', 'block');
            } else {
                $(this).siblings('.comments_block').css('display', 'block');
            }

            $(this).addClass('view');
        } else {
            if ($(this).hasClass('main_comments-btn')) {
                $('.main_comments').css('display', 'none');
            } else {
                $(this).siblings('.comments_block').css('display', 'none');
            }

            $(this).removeClass('view');
        }
    }
})

/*
   Subscribe button
*/
$('.subscribe-btn').on('click', function () {
    if(authCheck()) {
        let ques_id = ($(this).prop('classList'))[1];
        let button = $('.subscribe-btn');
        $.ajax({
            url: '/handler/sub',
            method: 'get',
            dataType: 'html',
            data: {question_id: ques_id},
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
            error: function() {
                alert('Oops, something is wrong!');
                setTimeout(() => button.attr('disabled', false), 1000);
            }
        });
    }
})

/*
   Like button
*/
$('.like-btn').on('click', function () {
    if(authCheck()) {
        let comm_id = ($(this).prop("classList"))[1];
        let button = $($(this).parent()).children('.like-btn');
        $.ajax({
            url: '/handler/like',
            method: 'get',
            dataType: 'html',
            data: {comment_id: comm_id},
            beforeSend: function() {
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
                        button.text('Нравится');
                    } else {
                        button.html('Нравится ' + '<span>' +  (Number(button.children('span').text()) - 1) + '</span>');
                    }
        
                    button.removeClass('cl');
                }
            },
            error: function () {
                alert('Oops, something is wrong!');
                location.reload();
            }
        });
    }
})