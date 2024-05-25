jQuery(function ($) {
    // userAgent
    const ua = navigator.userAgent;
    const uaLowerCase = navigator.userAgent.toLowerCase();
    const isSp = ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || (ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0);
    const isTablet = ua.indexOf('iPad') > 0 || (ua.indexOf('Android') > 0 && ua.indexOf('Mobile') == -1) || ua.indexOf('A1_07') > 0 || ua.indexOf('SC-01C') > 0 || uaLowerCase.indexOf('macintosh') > 0 && 'ontouchend' in document;
    const isPc = (!isSp && !isTablet);

    // AOS.init({
    //     once: true,
    //     duration: 1000,
    //     delay: 0,
    // });


    // only IE
    if (ua.indexOf('Trident') !== -1) {
        $('#member .sizes').each(function () {
            var objElement = $(this);
            var objOmg = new Image();
            objOmg.src = objElement.attr('src');
            if (objOmg.width != 0) {
                objElement.css({'width': objOmg.width / 2});
            }
        });
    }


    // fadein
    // $(window).scroll(function () {
    //     $('#member .js-fadein').each(function () {
    //         var ptop = $(this).offset().top;
    //         var scroll = $(window).scrollTop();
    //         var windowHeight = $(window).height();
    //         if (scroll > ptop - windowHeight) {
    //             $(this).addClass('scroll-in');
    //         }
    //     });
    // });
    //
    // $('#member .js-fadein').each(function () {
    //     var ptop = $(this).offset().top;
    //     var firstView = $(window).scrollTop();
    //     var windowHeight = $(window).height();
    //     if (firstView > ptop - windowHeight) {
    //         $(this).addClass('scroll-in');
    //     }
    // });

    //scroll
    $(function(){
        $('.scroll').click(function(event){event.preventDefault();
            var url = $(this).attr('href');
            var dest = url.split('#');var target = dest[1];
            var target_offset = $('#'+target).offset();
            var target_top = target_offset.top;
            $('html, body').animate({scrollTop:target_top}, 500, 'swing');
            return false;});
    });

    $("#member .dataItem.operation-manager .what-is").click(function () {
        $("#boxContent-popup").toggleClass("is-open");
        $(this).parents(".dataItem").toggleClass("is-active");
    });
    $("#member .dataItem #boxContent-popup .close-popup").click(function () {
        $(this).parents("#boxContent-popup").toggleClass("is-open");
        $(this).parents(".dataItem").toggleClass("is-active");
    });

    //connect page member
    $(function () {
        $('.memberItem a').click(function (event) {
            event.preventDefault();
            $member = $(this).data("member");
            window.history.replaceState(null, null, '?member=' + $member);
            $(".member-container").removeClass("is-active");
            $(".js-fadein").removeClass("scroll-in");
            var url = $(this).attr('href');
            var dest = url.split('#');
            var target = dest[1];
            $('#' + target).addClass("is-active");

            var speed = 0;
            var href = $(this).attr("href");
            var target = $(href == "#" || href == "" ? 'html' : href);
            var position = target.offset().top;
            $("html, body").animate({scrollTop: position}, 1000, "swing");
            setTimeout(function(){
                $(".js-fadein").removeClass("scroll-in");
            },1100);
            return false;
        });
    });

    $(document).ready(function() {
        $href = window.location.href;
        $url = new URL($href);
        $action = $url.searchParams.get("member");
        if($action === "01" || $action === "02" || $action === "03" || $action === "04" || $action === "05" || $action === "06"){
            $(".js-fadein").removeClass("scroll-in");
            $(".member-container").removeClass("is-active");
            $('#member-' + $action).addClass("is-active");

            var speed = 0;
            var href = $(this).attr("href");
            var target = $(href == "#" || href == "" ? 'html' : href);
            var position = target.offset().top;
            $("html, body").animate({scrollTop: position}, 1000, "swing");
            return false;
        }
    });

    if (isSp) {
        // only sp

    } else if (isTablet) {
        // only tablet

    } else if (isPc) {
        // only pc

    }


});