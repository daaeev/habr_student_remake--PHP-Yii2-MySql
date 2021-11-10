$(document).ready(function () {
    if (document.documentElement.clientWidth > 685) {
        const asideOffset = $('#left').offset().top;
        $('#left').css('height', document.documentElement.clientHeight - asideOffset);
        $(window).scroll(function () { 
            const scrollOffset = $(this).scrollTop();

            if ($('#left').css('display') != 'none' && scrollOffset <= asideOffset) {
                $('#content_container').removeClass('fixed');
                $('#left').css('height', document.documentElement.clientHeight - (asideOffset - scrollOffset));
            } else if ($('#left').css('display') != 'none' && scrollOffset >= asideOffset) {
                $('#content_container').addClass('fixed');
                $('#left').css('height', document.documentElement.clientHeight);
            }

            window.onresize = function () {
                if (scrollOffset <= asideOffset) {
                    $('#left').css('height', document.documentElement.clientHeight - (asideOffset - scrollOffset));
                } else if (scrollOffset >= asideOffset) {
                    $('#left').css('height', document.documentElement.clientHeight);
                }
            };
        });
    }

    $(window).scrollTop(0);
});

$('.menu-btn').on('click', function () {
    if ($('#left').css('display') == 'none')
        $('#left').css('display', 'flex');
    else 
        $('#left').css('display', 'none');
});