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
        if (!$(this).hasClass('cl')) {
            if ($(this).children('span').length) {
                $(this).children('span').text(Number($(this).children('span').text()) + 1);
            } else {
                $(this).html($(this).text() + ' <span>1</span>');
            }

            $(this).addClass('cl');
        } else {
            if (Number($(this).children('span').text()) == 1) {
                $(this).text('Подписаться');
            } else {
                $(this).html(Number($(this).children('span').text()) - 1);
            }

            $(this).removeClass('cl');
        }
        // AJAX
    }
})

/*
   Like button
*/
$('.like-btn').on('click', function () {
    if(authCheck()) {
        if (!$(this).hasClass('cl')) {
            if ($(this).children('span').length) {
                $(this).children('span').text(Number($(this).children('span').text()) + 1);
            } else {
                $(this).html($(this).text() + ' <span>1</span>');
            }

            $(this).addClass('cl');
        } else {
            if (Number($(this).children('span').text()) == 1) {
                $(this).text('Подписаться');
            } else {
                $(this).html(Number($(this).children('span').text()) - 1);
            }

            $(this).removeClass('cl');
        }
        // AJAX
    }
})

/*
   Submit comment button
*/