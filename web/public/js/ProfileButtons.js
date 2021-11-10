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