$(document).ready(function() {
    window.onscroll = function () {
        if (window.pageYOffset > 130) {
            $('#scroll-to-top').fadeIn();
        } else {
            $('#scroll-to-top').fadeOut();
        }
    };

    $('#scroll-to-top').click(function() {
        $('html, body').animate({ scrollTop: 0 }, 'smooth');
        return false;
    });
});