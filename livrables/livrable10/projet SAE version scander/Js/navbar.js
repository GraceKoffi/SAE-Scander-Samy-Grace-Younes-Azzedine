//transparent lorsqu'il est tout en haut 
$(document).ready(function () {
    $('nav').addClass('navbar-transparent');
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('nav').removeClass('navbar-transparent').addClass('navbar-normal');
        } else {
            $('nav').addClass('navbar-transparent').removeClass('navbar-normal');
        }
    });
    $(window).trigger('scroll');
});