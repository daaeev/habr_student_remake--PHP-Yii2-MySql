function error() {
    alert('Oops, something is wrong!');
    location.reload();
}

/*
   View description form button 
*/
$('.edit_description_btn').on('click', function () {
    if (!$(this).hasClass('view')) {
        $('#profile .profile_stats .chapter_block form').css('display', 'block');
        $(this).addClass('view');
    } else {
        $('#profile .profile_stats .chapter_block form').css('display', 'none');
        $(this).removeClass('view');
    }
})

/*
   Description form submit
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