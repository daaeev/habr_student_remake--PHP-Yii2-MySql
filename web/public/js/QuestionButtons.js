$(document).ready(function () {
    if ($('.user_have_answer').length) 
        $('.answer_form_block').css('display', 'none');
});

function authCheck(redirect = true) {
    if (!$('.answer_form_block').length && !$('.user_have_answer').length) {
        if (redirect)
            window.location.href = '/login';
        return false;
    }

    return true;
}

function error() {
    alert('Oops, something is wrong!');
    location.reload();
}

/*
   Button for viewing comments
*/
$('.comments-btn').on('click', function () {
    let mainCommentsCount = $(this).parent('.soc_buttons').siblings('.comments_block').children('.comment').length;
    let commentsToAnswerCount = $(this).siblings('.comments_block').children('.comment').length;

    if (!(mainCommentsCount || commentsToAnswerCount)) {
        if (authCheck()) {
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
    }
})

/*
   Subscribe button
*/
$('.subscribe-btn').on('click', function () {
    if(authCheck()) {
        let ques_id = ($(this).prop('classList'))[1];
        let button = $('.subscribe-btn');

        if (isNaN(ques_id))
            error();

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
            error: error,
        });
    }
})

/*
   Like button
*/
$('.like-btn').on('click', function () {
    if(authCheck()) {
        let comm_id = $(this).siblings('.comm_id').val();
        let button = $(this);

        if (isNaN(comm_id))
            error();

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
            error: error,
        });
    }
})

/*
   Delete button
*/
$('.delete-btn').on('click', function () {
    if (confirm('Are you sure?')) {
        let comm_id = $(this).siblings('.comment_id').val();
        let comment_block = $(this).parent('.text_block').parent('.answer');

        if (isNaN(comm_id))
            error();

        $.ajax({
            url: '/handler/delete-comment',
            method: 'get',
            dataType: 'html',
            data: {comment_id: comm_id},
            success: function () {
                comment_block.remove();
                let answersCount = $('.answer').length;
                
                if (answersCount == 0) {
                    $('.answers_container .answers-count').css('display', 'none');
                    $('.answers_block').css('display', 'none');
                }
                else 
                    $('.answers_container .answers-count span').text(answersCount);
                
                $('.user_have_answer').css('display', 'none');
                $('.answer_form_block').css('display', 'flex');
            },
            error: error,
        });
    }
})

/*
   Edit button
*/
$('.edit-btn').on('click', function () {
    if (!$(this).hasClass('editing')) {
        let content = $(this).siblings('.answer_content').children('span').html();
        $(this).siblings('.answer_content').children('span').css('display', 'none');
        $(this).siblings('.comment_form_block').css('display', 'block');
        $(this).siblings('.comment_form_block').children('.form_block').children('.single_form').children('form').children('textarea').html(content);

        $(this).addClass('editing');
    } else {
        $(this).siblings('.comment_form_block').css('display', 'none');
        $(this).siblings('.answer_content').children('span').css('display', 'block');

        $(this).removeClass('editing');
    }
})

/*
   Editing form submit button
*/
$('#edit-form').submit(function (e) {
    e.preventDefault();
    let old_content = $(this).parent('.single_form').parent('.form_block').parent('.comment_form_block').siblings('.answer_content').children('span').html();
    let comment_id = $(this).parent('.single_form').parent('.form_block').parent('.comment_form_block').siblings('.comment_id').val();
    let edited_content = $(this).children('textarea').val();
    let form_element = $(this);

    if (isNaN(comm_id))
        error();

    $.ajax({
        url: '/handler/comment-edit',
        method: 'get',
        dataType: 'html',
        data: {comment_id: comment_id, content: edited_content, old_content: old_content},
        success: function () {
            form_element.parent('.single_form').parent('.form_block').parent('.comment_form_block').css('display', 'none');
            form_element.parent('.single_form').parent('.form_block').parent('.comment_form_block').siblings('.answer_content').children('span').text(edited_content); // шаблонизатор
            form_element.parent('.single_form').parent('.form_block').parent('.comment_form_block').siblings('.answer_content').children('span').css('display', 'block');
            form_element.parent('.single_form').parent('.form_block').parent('.comment_form_block').siblings('.edit-btn').removeClass('editing');
        },
        error: error,
    });
})

/*
   Complaint button
*/
$('.complain-btn').on('click', function () {
    if (authCheck()) {
        let comm_id = $(this).siblings('.comment_id').val();
        let button = $(this);
        
        if (isNaN(comm_id))
            error();
        
        $.ajax({
            url: '/handler/complain',
            method: 'get',
            dataType: 'html',
            data: {comment_id: comm_id},
            beforeSend: function() {
                button.attr('disabled', true);
            },
            success: function () {
                setTimeout(() => button.attr('disabled', false), 1000);
            },
            error: error,
        });
    }
})