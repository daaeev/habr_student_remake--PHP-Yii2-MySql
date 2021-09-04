$(document).ready(function () {
    const auth_block_width = screen.width * 32 / 100;

    $('#content_container').css('max-width', screen.width);
    $('.header_block').css('max-width', screen.width);

    $('.login_form_block').css('width', auth_block_width);
    $('.registration_link').css('width', auth_block_width);
    $('.authorization_link').css('width', auth_block_width);
    $('.registration_block').css('width', auth_block_width);
});