let url = location.pathname;
let splited_url = url.split('/');
let category = splited_url[splited_url.length - 1];

if (category == 'interesting') {
    $('.interesting').addClass('active');
} else if (category == 'noanswer') {
    $('.noanswer').addClass('active');
} else {
    $('.new').addClass('active');
}

