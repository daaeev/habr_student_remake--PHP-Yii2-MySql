let url = location.pathname;
let splited_url = url.split('/');
let category = splited_url[splited_url.length - 1];
let page = splited_url[2];

if (page != 'profile') {
    if (category == 'interesting') {
        $('.interesting').addClass('active');
    } else if (category == 'noanswer') {
        $('.noanswer').addClass('active');
    } else {
        $('.new').addClass('active');
    }
}

if (page == 'profile') {
    $('.' + category + '-btn').addClass('active');
}