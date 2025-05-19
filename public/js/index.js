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

    $('#item-show-user').click(function(e) {
        e.preventDefault();
        $('.item-user-header-content').slideToggle(200);
    });

    $('.my-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        nextArrow:
            '<div class="slick-arrow slick-next"><i class="fa-solid fa-right-long"></i></div>',
        prevArrow:
            '<div class="slick-arrow slick-prev"><i class="fa-solid fa-left-long"></i></div>',
        autoplay: true,
        arrows: true,
        autoplaySpeed: 3000
    });

    $(".my-course").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        nextArrow:
            '<div class="slick-arrow slick-next"><i class="fa fa-chevron-right" aria-hidden="true"></i></div>',
        prevArrow:
            '<div class="slick-arrow slick-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>',
        autoplay: true,
        arrows: true,
        autoplaySpeed: 3000,
        responsive: [
            {
            breakpoint: 1025,
                settings: {
                    slidesToShow: 3
                }
            },
            {
            breakpoint: 992,
                settings: {
                    slidesToShow: 2
                }
            },
            {
            breakpoint: 600,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });
});