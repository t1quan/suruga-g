$(function(){
  //固定位置の「Search Jobs」ボタンおよび「Page Top」ボタン
	
  $(window).on('scroll', function() {
    if ($(document).scrollTop() < 500) {
      $('#pageTop').not(':animated').fadeOut(300);
		} else {
			$('#pageTop').not(':animated').fadeIn(300);
		}
  });

  $('#pageTop a[href^="#"]').click(function() {
      var speed = 500; // 好みに応じて変更
      var href= $(this).attr("href");
      var target = $(href == "#" || href == "" ? 'html' : href);
      var position = target.offset().top;
      $('body,html').animate({
          scrollTop:(position - $('#headerMenu .headerNav').height())
      }, speed, 'swing');
      return false;
  });

  // $(window).on('scroll', function() {
  //   var winW = $(window).width();
  //   if(winW <= parseInt(import.meta.env.VITE_BREAK_POINT)){
  //       if ($(document).scrollTop() < 500 || $(document).scrollTop() + $(window).height() >= $('#cmnFooter').offset().top - 100) {
  //           $('#searchJobsBtn').fadeOut();
  //       } else if ( $(this).scrollTop() > 500) {
  //           $('#searchJobsBtn').not(':animated').fadeIn(300);
  //           $('#searchJobsBtn').removeClass('fixed');
  //           $('#apply #searchJobsBtn, #concier #searchJobsBtn').hide();
  //       } else {
  //           $('#searchJobsBtn').not(':animated').fadeOut(300);
  //           // $('#searchJobsBtn').addClass('fixed');
  //           // $('#searchJobsBtn').fadeIn();
  //       }
  //   }
  // });
  //
  // if (parseInt($(window).width()) >= (parseInt(import.meta.env.VITE_BREAK_POINT)+1)) {
  //   $('#searchJobsBtn').hide();
  // }
  // $(window).on('orientationchange resize', function(){
  //   if (parseInt($(window).width()) >= (parseInt(import.meta.env.VITE_BREAK_POINT)+1)) {
  //     $('#searchJobsBtn').hide();
  //   }
  // });
  //
  // $(window).resize(function() {
  //   if ($(this).width() >= (parseInt(import.meta.env.VITE_BREAK_POINT)+1)) {
  //       $('#searchJobsBtn').css("display","none");
  //   } else {
  //       $('#searchJobsBtn').css("display","block");
  //   }
  // })

});
