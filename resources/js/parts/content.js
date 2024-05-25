$(function(){
  
  // member
  function contentMember() {
    var orientation = window.orientation;
    if(isSp && orientation == 90) {
      $('#member .contentMemberInterview').addClass('landscape');
    } else {
      $('#member .contentMemberInterview').removeClass('landscape');
    }
  }
  contentMember();
  $(window).on('orientationchange resize', function() {
    contentMember();
  });
  
  // welfare
  $('#welfare .js-contentWelfareButton').on('click', function() {
    if ($(this).hasClass('isOpen')) {
      $('#welfare .contentWelfareBox').slideUp();
      $('#welfare .contentWelfareButton').removeClass('isOpen');
      $(this).removeClass('isOpen');
    }
    else {
      $('#welfare .contentWelfareBox').slideUp();
      $('#welfare .contentWelfareButton').removeClass('isOpen');
      $(this).toggleClass('isOpen');
      $(this).next('.contentWelfareBox').slideToggle();
    }
  });
  
  // oneday
  var contentOnedayIndex = $('#oneday .contentOnedayWrapper').length;
  for (var i = 1; i <= contentOnedayIndex; i++) {
    $('#oneday0' + i + ' .textStart').appendTo('#oneday0' + i + ' .contentOnedayItem:first-of-type .contentOnedayPicture');
    $('#oneday0' + i + ' .textGorl').appendTo('#oneday0' + i + ' .contentOnedayItem:last-of-type .contentOnedayPicture');
  }

  // workplace
  function contentWorkplace() {
    if (parseInt($(window).width()) >= parseInt(import.meta.env.VITE_BREAK_POINT) && parseInt($(window).width()) <= 1024) {
      $('#workplace').addClass('tablet');
    } else {
      $('#workplace').removeClass('tablet');
    }
  }
  contentWorkplace();
  $(window).on('orientationchange resize', function() {
    contentWorkplace();
  });
  
  // faq
  $('#faq .contentFaqButton').next().hide();
  $('#faq .contentFaqButton.active').next().show();
  $('#faq .contentFaqButton').on('click', function() {
    $(this).next().slideToggle();
    $(this).toggleClass('active');
  });

});
