let url = location.pathname;

if (url == '/questions/interesting' || url == '/my/interesting') {
    $('.interesting').addClass('active');
} else if (url == '/questions/noanswer' || url == '/my/noanswer') {
    $('.noanswer').addClass('active');
} else {
    $('.new').addClass('active');
}

