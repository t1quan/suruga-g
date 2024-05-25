$(function(){
  /* header */
  var scrollpos;
  var winHeight;
  var headerNavHeight;
  function headerMenu() {
    if(window.innerWidth >= (parseInt(import.meta.env.VITE_BREAK_POINT)+1)) {
      $('#headerMenu').parents('body').addClass('PConly');
      $('#headerMenu .sp__menu').css({'display': 'none'});
      $('#headerMenu #hamburger').removeClass('js-hb-active');
      $('#headerMenu .modalMenu').removeClass('modalOn');
      $('#headerMenu .headerNav').removeClass('modalOn');
      $('body').removeClass('nav_fixed modalOn');
    } else {
      $('#headerMenu').parents('body').removeClass('PConly');
      $('#headerMenu .sp__menu').css({'display': 'flex'});
    }
  }
  function headerHeight() {
    if(window.innerWidth >= (parseInt(import.meta.env.VITE_BREAK_POINT)+1)) {
      $('#headerMenu .navItemList').css({'display': '', 'height': 'auto'});
    } else {
      winHeight = window.innerHeight;
      headerNavHeight = $('#headerMenu .headerNav').height();
      $('#headerMenu .navItemList').css({'height': winHeight - headerNavHeight, 'top': headerNavHeight});
    }
  }
  headerMenu();
  headerHeight();
  $(window).on('orientationchange resize', function(){
    headerMenu();
    headerHeight();
  });
  $('#headerMenu .headerLogo').show();
  $('#headerMenu .sp__menu').on('click', function(){
    if($('#headerMenu .modalMenu').hasClass('modalOn')) {
      $('body').removeClass('nav_fixed').css({
        'position': '', 'top': 0
      });
        window.scrollTo(0, scrollpos);
    } else {
      scrollpos = $(window).scrollTop();
      $('body').addClass('nav_fixed').css({
        'position': 'fixed', 'top': -scrollpos
      });
    }
  });

  $('#topLayout #newLight .navItem:not(.navItemSp) a').each(function(){
    var topContentLink = $(this).attr('href').split('/');
    $(this).attr('href', topContentLink[3]);
  });

  /* hamburger */
  $('#headerMenu #hamburger').click(function() {
    $(this).toggleClass('active');
    $('#headerMenu .modalMenu').toggleClass('modalOn');
    $('#headerMenu .modalMenu').parent().toggleClass('modalOn');
    $('#headerMenu .hamburger--collapse').toggleClass('js-hb-active');
    $(this).parents('body').toggleClass('modalOn');//背景要素を止める（スタイル併用）
    $('#headerMenu .navItemList').slideToggle();
  });

  //該当するグロナビのリンクURLを書き換え(TOPページ)
  $(document).ready(function() {
    if($('#topLayout').length !== 0) {
      $('#headerMenu .navItemListInner').children('div').each(function () {
        if($(this).find('a').attr('href').indexOf('#') >= 0) {
          let defaultHref = $(this).find('a').attr('href');
            let startPoint = defaultHref.indexOf('#');
            let replaceHref = defaultHref.slice(startPoint);
            $(this).find('a').attr('href', replaceHref);
        }
      });
    }
  });

  $(document).ready(function() {
    let id_array = ['about', 'oneday']; //任意
    $.each(id_array, function(index, id) {
      if($('#contentLayout #main_wrap').children('#' + id).length !== 0) {
        $('#headerMenu .navItemListInner').children('div').each(function () {
          if($(this).find('a').attr('href').indexOf('#') >= 0) {
            let defaultHref = $(this).find('a').attr('href');
              if(defaultHref.indexOf(id) < 1) {
                let startPoint = defaultHref.indexOf('#');
                let replaceHref = defaultHref.slice(startPoint);
                  $(this).find('a').attr('href', replaceHref);
                }
              }
        });
      }
    });
  });
});
