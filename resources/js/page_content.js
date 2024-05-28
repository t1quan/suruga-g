//共通使用
import './parts/headerMenu';
import './parts/sideBar';
import './parts/favorite';

//コンテンツページ使用
// import './parts/content';
$(document).ready(function () {
    $('.scroll').click(function (event) {
        event.preventDefault();
        var url = $(this).attr('href');
        var dest = url.split('#'); var target = dest[1];
        var target_offset = $('#' + target).offset();
        var target_top = target_offset.top;
        $('html, body').animate({ scrollTop: target_top }, 500, 'swing');
        return false;
    });
})