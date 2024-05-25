$(function(){
	//検索ボックス動作制御

	//検索軸の表示タブ切替
	$(function () {
		$(".search-tab__ready").click(function (obj) {
			var date_id = $(obj.currentTarget).data("id");
			var check1 = $('.search-tab__area').hasClass('js-clicked__blue');
			var check2 = $('.search-tab__job').hasClass('js-clicked__blue');
			var check3 = $('.search-tab__employee').hasClass('js-clicked__blue');

			$('.search-form__form input[type="checkbox"]').prop("checked", false);

			if (date_id == 1) {

				$('.search-area').after($('.search-job'), $('.search-employee'));


				if (check2 || check3) {
					$('.search-tab__job, .search-tab__employee').removeClass('js-clicked__blue');
					$('.search-area .area__btn, .search-job .area__btn, .search-employee .area__btn').removeClass('js-clicked__grey');
					$('.search-job').stop(true, true).hide();
					$('.search-employee').stop(true, true).hide();
				}

				$(this).addClass('js-clicked__blue');
				if ($(this).hasClass('js-clicked__blue')) {
					$('.search-area').stop(true, true).fadeIn(1000);
					$('.search-all').stop(true, true).fadeIn(1000);
				} else {
					$('.search-area').stop(true, true).fadeOut('fast');
					$('.search-all').stop(true, true).fadeOut('fast');
				}
			} else if (date_id == 2) {

				$('.search-job').after($('.search-employee'), $('.search-area'));

				if (check1 || check3) {
					$('.search-tab__area, .search-tab__employee').removeClass('js-clicked__blue');
					$('.search-area .area__btn, .search-job .area__btn, .search-employee .area__btn').removeClass('js-clicked__grey');
					$('.search-area').stop(true, true).hide();
					$('.search-employee').stop(true, true).hide();
				}


				$(this).addClass('js-clicked__blue');
				if ($(this).hasClass('js-clicked__blue')) {
					$('.search-job').stop(true, true).fadeIn(1000);
					$('.search-all').stop(true, true).fadeIn(1000);
				} else {
					$('.search-job').stop(true, true).hide().fadeOut('fast');
					$('.search-all').stop(true, true).hide().fadeOut('fast');
				}
			} else if (date_id == 3) {

				$('.search-employee').after($('.search-area'), $('.search-job'));

				if (check1 || check2) {
					$('.search-tab__area, .search-tab__job').removeClass('js-clicked__blue');
					$('.search-area .area__btn, .search-job .area__btn, .search-employee .area__btn').removeClass('js-clicked__grey');
					$('.search-area').stop(true, true).hide();
					$('.search-job').stop(true, true).hide();
				}

				$(this).addClass('js-clicked__blue');
				if ($(this).hasClass('js-clicked__blue')) {
					$('.search-employee').stop(true, true).fadeIn(1000);
					$('.search-all').stop(true, true).fadeIn(1000);
				} else {
					$('.search-employee').stop(true, true).hide().fadeOut('fast');
					$('.search-all').stop(true, true).hide().fadeOut('fast');
				}
			}
		});

		$('.search-area .area__btn,.search-job .area__btn,.search-employee .area__btn').click(function () {
			if ($(this).next('input[type=checkbox]').prop("checked")) {
				$(this).next('input[type=checkbox]').prop("checked", false);
				$(this).removeClass('js-clicked__grey');
			} else {
				$(this).next('input[type=checkbox]').prop("checked", true);
				$(this).addClass('js-clicked__grey');
			}

			if ($('input[name="cityCheckbox"]:checked').length != 0) {
				$('.search-area').next('.search-job').stop(true, true).fadeIn(1000);
			} else {
				$('.search-area').next('.search-job').stop(true, true).hide().fadeOut('fast');
			}

			if ($('input[name="jobCheckbox"]:checked').length != 0) {
				$('.search-job').next('.search-employee').stop(true, true).fadeIn(1000);
			} else {
				$('.search-job').next('.search-employee').stop(true, true).hide().fadeOut('fast');
			}

			if ($('input[name="koyoCheckbox"]:checked').length != 0) {
				$('.search-employee').next('.search-area').stop(true, true).fadeIn(1000);
			} else {
				$('.search-employee').next('.search-area').stop(true, true).hide().fadeOut('fast');
			}

			if(($('input[name="cityCheckbox"]:checked').length + $('input[name="jobCheckbox"]:checked').length + $('input[name="koyoCheckbox"]:checked').length) != 0){
				$('.search-all').stop(true, true).fadeIn(1000);
			}else{
				$('.search-all').stop(true, true).hide().fadeOut('fast');
			}
		});
	});

	//検索ボックス 検索条件生成
	function searchWordBoxSubmit(){
		var val = '';
		if($('#topSearchWord').val()){
			var inputval = $('#topSearchWord').val();
			inputval = encodeURIComponent(inputval);
			val = 'kw='+ inputval;
		}
		var search_url = $("#word_search_url").val();
		location.href=search_url+'?'+val;
		return false;
	}
	//検索ボックス ボタンクリック時
	$('.searchWordBtn').click(function(){
		searchWordBoxSubmit();
		return false;
	});

	//検索ボックス Enterキー押下時
	$("#topSearchWord").on("keypress", function(event) {
		if(event.key === 'Enter' && $('#topSearchWord').val()){
			searchWordBoxSubmit();
			return false;
		}else{
			return true;
		}
	});
});
