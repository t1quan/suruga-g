jQuery(function ($) {
    // userAgent
    const ua = navigator.userAgent;
    const uaLowerCase = navigator.userAgent.toLowerCase();
    const isSp = ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || (ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0);
    const isTablet = ua.indexOf('iPad') > 0 || (ua.indexOf('Android') > 0 && ua.indexOf('Mobile') == -1) || ua.indexOf('A1_07') > 0 || ua.indexOf('SC-01C') > 0 || uaLowerCase.indexOf('macintosh') > 0 && 'ontouchend' in document;
    const isPc = (!isSp && !isTablet);

    AOS.init({
        once: true,
        duration: 1000,
        delay: 0,
    });


    // only IE
    if (ua.indexOf('Trident') !== -1) {
        $('#data .sizes').each(function () {
            var objElement = $(this);
            var objOmg = new Image();
            objOmg.src = objElement.attr('src');
            if (objOmg.width != 0) {
                objElement.css({'width': objOmg.width / 2});
            }
        });
    }


    // fadein
    // $(window).on('load', function () {
    //     $(window).scroll(function () {
    //         $('#data .js-fadein').each(function () {
    //             var ptop = $(this).offset().top;
    //             var scroll = $(window).scrollTop();
    //             var windowHeight = $(window).height();
    //             if (scroll > ptop - windowHeight - 50) {
    //                 $(this).addClass('scroll-in');
    //             }
    //         });
    //     });
    //
    //     $('#data .js-fadein').each(function () {
    //         var ptop = $(this).offset().top;
    //         var firstView = $(window).scrollTop();
    //         var windowHeight = $(window).height();
    //         if (scroll > ptop - windowHeight - 50) {
    //             $(this).addClass('scroll-in');
    //         }
    //     });
    // });

    // data
    // $(window).on('load', function () {
    //     $(window).scroll(function () {
    //         $('#data .svg-item').each(function () {
    //             var ptop = $(this).offset().top;
    //             var scroll = $(window).scrollTop();
    //             var windowHeight = $(window).height();
    //             if (scroll > ptop - windowHeight - 50) {
    //                 $(this).addClass('data-run');
    //             }
    //         });
    //     });
    //
    //     $('#data .svg-item').each(function () {
    //         var ptop = $(this).offset().top;
    //         var firstView = $(window).scrollTop();
    //         var windowHeight = $(window).height();
    //         if (scroll > ptop - windowHeight - 50) {
    //             $(this).addClass('data-run');
    //         }
    //     });
    // });

    function dataRun () {
        $('#data .svg-item').each(function () {
            var ptop = $(this).offset().top;
            var firstView = $(window).scrollTop();
            var windowHeight = $(window).height();
            if (scroll > ptop - windowHeight - 50) {
                $(this).addClass('data-run');
            }
        });
    }

    $(document).ready(function() {
        dataRun();

        $(window).scroll(function () {
            dataRun();
        });
    });

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

    $("#data .dataItem.operation-manager .what-is").click(function () {
        $("#boxContent-popup").toggleClass("is-open");
        $(this).parents(".dataItem").toggleClass("is-active");
    });
    $("#data .dataItem #boxContent-popup .close-popup").click(function () {
        $(this).parents("#boxContent-popup").toggleClass("is-open");
        $(this).parents(".dataItem").toggleClass("is-active");
    });



    /*↓jsはここに追記していく↓*/

    /*---chart.js---*/

    var chartEl1 = document.getElementById("chartContainer01");
    var chartEl2 = document.getElementById("chartContainer02");
    var chartEl3 = document.getElementById("chartContainer03");
    var chartEl4 = document.getElementById("chartContainer04");
    var chartEl5 = document.getElementById("chartContainer05");

    var chartEl6 = document.getElementById("dataItem01");
    var chartEl7 = document.getElementById("dataItem03");
    var chartEl8 = document.getElementById("dataItem04");
    var chartEl9 = document.getElementById("dataItem05");
    var chartEl10 = document.getElementById("dataItem06");
    var chartEl11 = document.getElementById("dataItem08");

    var chartFlag1 = false;
    var chartFlag2 = false;
    var chartFlag3 = false;
    var chartFlag4 = false;
    var chartFlag5 = false;

    var chartFlag6 = false;
    var chartFlag7 = false;
    var chartFlag8 = false;
    var chartFlag9 = false;
    var chartFlag10 = false;
    var chartFlag11 = false;


    // 1つ目のグラフ（勤続年数）
    var chartFunc1 = function () {
        var ctx = chartEl1.getContext('2d');
        chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [2.77, 97.23],
                    backgroundColor: [
                        '#665abf',
                        '#B6C5E3',
                    ],
                    borderWidth: 0,
                    hoverBackgroundColor: [
                        '#665abf',
                        '#B6C5E3',
                    ],
                }],
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        enabled: false,
                    },
                },
                pieceLabel: {
                    render: 'label',
                    position: 'outside',
                    arc: 'true',
                },
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
            },
        });

        $("#data .count-up-decimals").each(function(){
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 3000,
                easing: 'swing',
                step: function (now) {
                    // $(this).text(Math.round( now * 100 ) / 100);
                    $(this).text(Math.ceil(now));
                }
            });
        });
    };

    var chartFunc2 = function () {
        var ctx = chartEl2.getContext('2d');
        chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [63, 37],
                    backgroundColor: [
                        '#665abf',
                        '#B6C5E3',
                    ],
                    borderWidth: 0,
                    hoverBackgroundColor: [
                        '#665abf',
                        '#B6C5E3',
                    ],
                }],
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        enabled: false,
                    },
                },
                pieceLabel: {
                    render: 'label',
                    position: 'outside',
                    arc: 'true',
                },
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
            },
        });

        $("#data .count-up07").each(function(){
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 3000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    };

    var chartFunc3 = function () {
        var ctx = chartEl3.getContext('2d');
        chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [17, 83],
                    backgroundColor: [
                        '#665abf',
                        '#B6C5E3',
                    ],
                    borderWidth: 0,
                    hoverBackgroundColor: [
                        '#665abf',
                        '#B6C5E3',
                    ],
                }],
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        enabled: false,
                    },
                },
                pieceLabel: {
                    render: 'label',
                    position: 'outside',
                    arc: 'true',
                },
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
            },
        });
    };

    var chartFunc4 = function () {
        var ctx = chartEl4.getContext('2d');
        chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [24, 76],
                    backgroundColor: [
                        '#665abf',
                        '#B6C5E3',
                    ],
                    borderWidth: 0,
                    hoverBackgroundColor: [
                        '#665abf',
                        '#B6C5E3',
                    ],
                }],
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        enabled: false,
                    },
                },
                pieceLabel: {
                    render: 'label',
                    position: 'outside',
                    arc: 'true',
                },
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
            },
        });
    };

    var chartFunc5 = function () {
        var ctx = chartEl5.getContext('2d');
        chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [21, 79],
                    backgroundColor: [
                        '#665abf',
                        '#B6C5E3',
                    ],
                    borderWidth: 0,
                    hoverBackgroundColor: [
                        '#665abf',
                        '#B6C5E3',
                    ],
                }],
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        enabled: false,
                    },
                },
                pieceLabel: {
                    render: 'label',
                    position: 'outside',
                    arc: 'true',
                },
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
            },
        });
    };

    var chartFunc6 = function () {
        $("#data .count-up01").each(function(){
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 3000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    };

    var chartFunc7 = function () {
        $("#data .count-up03").each(function(){
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 3000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    };

    var chartFunc8 = function () {
        $("#data .count-up04").each(function(){
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 3000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    };

    var chartFunc9 = function () {
        $("#data .count-up05").each(function(){
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 3000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    };

    var chartFunc10 = function () {
        $("#data .count-up06").each(function(){
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 3000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    };

    var chartFunc11 = function () {
        $("#data .count-up08").each(function(){
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 3000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    };


    // スクロール処理
    var graphAnim = function () {
        var wy = window.pageYOffset,
            //wb = wy + screen.height - 300, // スクリーンの最下部位置を取得
            wb = wy + window.innerHeight, // ブラウザの最下部位置を取得

            // チャートの位置を取得
            chartElPos1 = wy + chartEl1.getBoundingClientRect().top,
            chartElPos2 = wy + chartEl2.getBoundingClientRect().top,
            chartElPos3 = wy + chartEl3.getBoundingClientRect().top,
            chartElPos4 = wy + chartEl4.getBoundingClientRect().top,
            chartElPos5 = wy + chartEl5.getBoundingClientRect().top,

            chartElPos6 = wy + chartEl6.getBoundingClientRect().top,
            chartElPos7 = wy + chartEl7.getBoundingClientRect().top,
            chartElPos8 = wy + chartEl8.getBoundingClientRect().top,
            chartElPos9 = wy + chartEl9.getBoundingClientRect().top,
            chartElPos10 = wy + chartEl10.getBoundingClientRect().top,
            chartElPos11 = wy + chartEl11.getBoundingClientRect().top;

        // チャートの位置がウィンドウの最下部位置を超えたら起動
        if (wb > chartElPos1 && chartFlag1 == false) {
            chartFunc1();
            chartFlag1 = true;
        }

        if (wb > chartElPos2 && chartFlag2 == false) {
            chartFunc2();
            chartFlag2 = true;
        }

        if (wb > chartElPos3 && chartFlag3 == false) {
            chartFunc3();
            chartFlag3 = true;
        }

        if (wb > chartElPos4 && chartFlag4 == false) {
            chartFunc4();
            chartFlag4 = true;
        }

        if (wb > chartElPos5 && chartFlag5 == false) {
            chartFunc5();
            chartFlag5 = true;
        }

        if (wb > chartElPos6 && chartFlag6 == false) {
            chartFunc6();
            chartFlag6 = true;
        }

        if (wb > chartElPos7 && chartFlag7 == false) {
            chartFunc7();
            chartFlag7 = true;
        }

        if (wb > chartElPos8 && chartFlag8 == false) {
            chartFunc8();
            chartFlag8 = true;
        }

        if (wb > chartElPos9 && chartFlag9 == false) {
            chartFunc9();
            chartFlag9 = true;
        }

        if (wb > chartElPos10 && chartFlag10 == false) {
            chartFunc10();
            chartFlag10 = true;
        }

        if (wb > chartElPos11 && chartFlag11 == false) {
            chartFunc11();
            chartFlag11 = true;
        }

    };

    $(document).ready(function() {
        graphAnim();

        $(window).scroll(function () {
            graphAnim();
        });
    });


    // window.addEventListener('load', graphAnim);
    // window.addEventListener('scroll', graphAnim);



    // $("#data .count-up07").each(function(){
    //     $(this).prop('Counter',0).animate({
    //         Counter: $(this).text()
    //     }, {
    //         duration: 3000,
    //         easing: 'swing',
    //         step: function (now) {
    //             $(this).text(Math.ceil(now));
    //         }
    //     });
    // });

    // $("#data .count-up-decimals").each(function(){
    //     $(this).prop('Counter',0).animate({
    //         Counter: $(this).text()
    //     }, {
    //         duration: 3000,
    //         easing: 'swing',
    //         step: function (now) {
    //             $(this).text(Math.round( now * 100 ) / 100);
    //         }
    //     });
    // });



    // $("#data .count-up").each(function(){
    //     $(this).prop('Counter',0).animate({
    //         Counter: $(this).text()
    //     }, {
    //         duration: 3500,
    //         easing: 'swing',
    //         step: function (now) {
    //             $(this).text(Math.ceil(now));
    //         }
    //     });
    // });





    if (isSp) {
        // only sp

    } else if (isTablet) {
        // only tablet

    } else if (isPc) {
        // only pc

    }


});