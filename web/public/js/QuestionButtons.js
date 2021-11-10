$(document).ready(function () {
    if ($('.user_have_answer').length) 
        $('.answer_form_block').css('display', 'none');
});

function authCheck(redirect = true) {
    if (!$('.field_for_auth').length) {
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
    let mainCommentsCount = $(this).parent('.info-buttons').parent('.soc_buttons').siblings('.comments_block').children('.comment').length;
    let commentsToAnswerCount = $(this).siblings('.comments_block').children('.comment').length;

    if (mainCommentsCount || commentsToAnswerCount || authCheck()) {
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
$('.subscribe_ques-btn').on('click', function () {
    if(authCheck()) {
        let ques_id = ($(this).prop('classList'))[1];
        let button = $(this);

        if (isNaN(ques_id))
            error();

        $.ajax({
            url: '/handler/sub-question',
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
        let comm_id = $(this).siblings('.object').val();
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
                    if (button.children('span').length)
                        button.children('span').text(Number(button.children('span').text()) + 1);
                    else 
                        button.html(button.text() + ' <span>1</span>');
                    
        
                    button.addClass('cl');
                } else {
                    if (Number(button.children('span').text()) == 1)
                        button.text('Нравится');
                    else 
                        button.html('Нравится ' + '<span>' +  (Number(button.children('span').text()) - 1) + '</span>');
                    
        
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
        let object_type = $(this).siblings('.object').attr('id');
        let splited_type = object_type.split('\\');
        let object_id = $(this).siblings('.object').val();
        let comment_block = $(this).parent('.text_block').parent('.answer');

        if (isNaN(object_id))
            error();

        $.ajax({
            url: '/handler/delete-comment',
            method: 'get',
            dataType: 'html',
            data: {object_type: object_type, object_id: object_id},
            success: function () {
                if (splited_type[splited_type.length - 1] == "Question")
                    window.location.href = "/";
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
        $(this).siblings('.comment_form_block').children('.form_block').children('.single_form').children('form').children('.form-group').children('textarea').html(content);

        $(this).addClass('editing');
    } else {
        $(this).siblings('.comment_form_block').css('display', 'none');
        $(this).siblings('.answer_content').children('span').css('display', 'block');

        $(this).removeClass('editing');
    }
})

/*
   Complaint button
*/
$('.complain-btn').on('click', function () {
    if (authCheck()) {
        let comm_id = $(this).siblings('.object').val();
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

/*
   Approve button
*/
$('.approve_ques-btn').on('click', function () {
    let comm_id = $(this).siblings('.object').val();
    let button = $(this);
    let mark_position = $(this).parent().siblings('.answer_left_block');
    let mark = $('<i class="bi bi-check"></i>');

    if (isNaN(comm_id))
        error();

    $.ajax({
        url: '/handler/approve-answer',
        method: 'get',
        dataType: 'html',
        data: {comment_id: comm_id},
        success: function () {
            button.remove();
            mark_position.append(mark);
        },
        error: error,
    });
})

/*
   Answer button
*/
$('.answer-btn').on('click', function () {
    let author_name = $(this).siblings('.author_name').text();
    let textarea = $(this).parent().parent().siblings('.comment_form_block').children('.form_block').children('.single_form').children('form').children('.form-group').children('textarea');

    textarea.text(author_name + ', ' + textarea.text());
})