function addTagToTextarea(tag, button) {
    let textarea = button.parent('.form_helper').siblings('#form').children('.form-group').children('textarea');
    textarea.val(textarea.val() + tag);
}

$('.form_bold-btn').on('click', function () {
    addTagToTextarea('<b></b>', $(this));
});

$('.form_italic-btn').on('click', function () {
    addTagToTextarea('<i></i>', $(this));
});

$('.form_underline-btn').on('click', function () {
    addTagToTextarea('<u></u>', $(this));
});

$('.form_crossed-btn').on('click', function () {
    addTagToTextarea('<s></s>', $(this));
});

$('.form_code-btn').on('click', function () {
    addTagToTextarea('<code></code>', $(this));
});