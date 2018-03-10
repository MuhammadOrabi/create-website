require('jquery');
require('materialize-css');

$(document).ready(function () {
    $(".button-collapse").sideNav();
    $('.slider').slider();
    $("li").click(function () {
        // remove classes from all
        $("li").removeClass("active");
        // add class to the one we clicked
        $(this).addClass("active");
    });

    /*
        Load more content with jQuery - May 21, 2013
        (c) 2013 @ElmahdiMahmoud
    */
    //load more
    $(function () {
        $(".load").slice(0, 1).show();
        $("#loadMore").on('click', function (e) {
            e.preventDefault();
            $(".load:hidden").slice(0, 1).slideDown();
            if ($(".load:hidden").length == 0) {
                $("#load").fadeOut('slow');
            }
            $('html,body').animate({
                scrollTop: $(this).offset().top
            }, 1500);
        });
    });
    $('a[href=#top]').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 600);
        return false;
    });
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('.totop a').fadeIn();
        } else {
            $('.totop a').fadeOut();
        }
    });
});