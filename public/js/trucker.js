jQuery(function ($) {
    // userAgent
    const ua = navigator.userAgent;
    const uaLowerCase = navigator.userAgent.toLowerCase();
    const isSp = ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || (ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0);
    const isTablet = ua.indexOf('iPad') > 0 || (ua.indexOf('Android') > 0 && ua.indexOf('Mobile') == -1) || ua.indexOf('A1_07') > 0 || ua.indexOf('SC-01C') > 0 || uaLowerCase.indexOf('macintosh') > 0 && 'ontouchend' in document;
    const isPc = (!isSp && !isTablet);


    // only IE
    if (ua.indexOf('Trident') !== -1) {
        $('#UACJ_work .sizes').each(function () {
            var objElement = $(this);
            var objOmg = new Image();
            objOmg.src = objElement.attr('src');
            if (objOmg.width != 0) {
                objElement.css({'width': objOmg.width / 2});
            }
        });
    }


    // fadein
    // $(window).on('load', function(){
    //     $(window).scroll(function () {
    //         $('#UACJ_work .js-fadein').each(function () {
    //             var ptop = $(this).offset().top;
    //             var scroll = $(window).scrollTop();
    //             var windowHeight = $(window).height();
    //             if (scroll > ptop - windowHeight + 100) {
    //                 $(this).addClass('scroll-in');
    //             }
    //             else if (scroll == 0) {
    //                 $(this).removeClass('scroll-in');
    //             }
    //         });
    //     });
    //
    //     $('#UACJ_work .js-fadein').each(function(){
    //         var ptop = $(this).offset().top;
    //         var firstView = $(window).scrollTop();
    //         var windowHeight = $(window).height();
    //         if (firstView > ptop - windowHeight){
    //             $(this).addClass('scroll-in');
    //         }
    //     });
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
    // $('.top-icon').click(function (e) {
    //     e.preventDefault();
    //     $('html, body').animate({scrollTop:0}, '300');
    // });

    // tab
    // $('.click:first-child').addClass('active');

    $('#UACJ_work .click').click(function(){
        $('#UACJ_work .tab').hide();
        // $('#UACJ_work .click').removeClass('active');
        // $(this).addClass('active');
        var activeTab = $(this).attr('tab');
        var activeur = $(this).attr('ur');
        const url = new URL(window.location);
        url.searchParams.set("work", activeur);
        window.history.pushState({}, "", url);
        $(activeTab).fadeIn(1100);
        $('html, body').animate({scrollTop:0}, '300');
        return false;
    });

    $(document).ready(function() {
        $(".js-fadein").removeClass("scroll-in");
        $href = window.location.href;
        $url = new URL($href);
        $action = $url.searchParams.get("work");
        if($action === "01" || $action === "02" || $action === "03" || $action === "04" || $action === "05" || $action === "06"){
            $('#UACJ_work .tab').hide();
            $('#work' + $action.slice(-1)).show();
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