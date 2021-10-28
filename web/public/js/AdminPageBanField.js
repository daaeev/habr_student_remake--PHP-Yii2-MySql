if ($('.btn-set_role').length) {
    $('select').on('change', function () {
        if ($(this).find(':selected').index() == 3) 
            $('.ban_reason-field').css('display', 'block');
        else
            $('.ban_reason-field').css('display', 'none');
    });
}