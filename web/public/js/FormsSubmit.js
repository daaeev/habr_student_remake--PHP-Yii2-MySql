function error() {
    alert('Oops, something is wrong!');
    location.reload();
}

/*
   Profile description form submit
*/
$('#profile .profile_stats .chapter_block form').on('submit', function (e) {
    e.preventDefault();
    let description = $(this).children('input').val();
    let author = $(this).children('.author').val();
    $.ajax({
        url: '/handler/set-description',
        method: 'get',
        dataType: 'html',
        data: {description: description, author_id: author},
        success: function () {
            $('#profile .profile_stats .chapter_block .user-description').text(description);
            $('#profile .profile_stats .chapter_block form').css('display', 'none');
            $('.edit_description_btn').removeClass('view');
        },
        error: error,
    });
})

/*
   Editing form submit (single.php)
*/
$('#edit-form').submit(function (e) {
    e.preventDefault();
    let old_content = $(this).parent('.single_form').parent('.form_block').parent('.comment_form_block').siblings('.answer_content').children('span').html();
    let comment_id = $(this).parent('.single_form').parent('.form_block').parent('.comment_form_block').siblings('.object').val();
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

$('.forgot_form_block form').on('submit', function (e) {
    e.preventDefault();

    let username = $(this).children('.field').children('.username').val();
    let email = $(this).children('.field').children('.email').val();

    $.ajax({
        url: '/handler/forgot-password',
        method: 'get',
        dataType: 'html',
        data: {username: username, email: email},
        success: function () {
            window.location.href = '/';
        },
        error: error,
    });
})

// Change password form
$('.change_form_block form').on('beforeSubmit', function () {
    let old_password = $(this).children('.field').children('.old_pass').children('input').val();
    let new_password = $(this).children('.field').children('.new_pass').children('input').val();

    $.ajax({
        url: '/handler/change-password',
        method: 'get',
        dataType: 'html',
        data: {old_pass: old_password, new_pass: new_password},
        success: function () {
            window.location.href = '/';
        },
        error: function () {
            alert('Password mismatch');
            error();
        },
    });
})
$('.change_form_block form').on('submit', function (e) {
    e.preventDefault();
})