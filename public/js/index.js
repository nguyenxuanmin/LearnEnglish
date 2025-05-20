$(document).ready(function() {
    const header = $('#header');
    window.onscroll = function () {
        if (window.pageYOffset > 130) {
            header.addClass('header-fixed');
            $('#scrollToTop').fadeIn();
        } else {
            header.removeClass('header-fixed');
            $('#scrollToTop').fadeOut();
        }
    };

    Fancybox.bind("[data-fancybox='gallery']");

    $('#scrollToTop').click(function() {
        $('html, body').animate({ scrollTop: 0 }, 'smooth');
        return false;
    });

    $('#itemDisplayUser').click(function(e) {
        e.preventDefault();
        $('.item-user-header-content').slideToggle(200);
    });

    $('#itemMenuMobile').click(function() {
        $("#menuMobile").addClass("show-menu");
    });

    $('#itemHideMenu').click(function() {
        $("#menuMobile").removeClass("show-menu");
    });

    $('#menuMobile ul li a').click(function() {
        $("#menuMobile").removeClass("show-menu");
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
                    slidesToShow: 2
                }
            },
            {
            breakpoint: 992,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    $(".my-feedback").slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
        arrows: false,
        autoplaySpeed: 3000,
        responsive: [
            {
            breakpoint: 1025,
                settings: {
                    slidesToShow: 2
                }
            },
            {
            breakpoint: 992,
                settings: {
                    slidesToShow: 1
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

    $(".my-blog").slick({
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
                    slidesToShow: 2
                }
            },
            {
            breakpoint: 992,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });
});