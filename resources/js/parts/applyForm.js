$(function(){
	// 入力欄開閉 for mod_apply
	// .body.close を非表示
	$('.toggleSwitchApply').siblings('.body.close').hide();
	$('.toggleSwitchApply:not(.spLayout)').on('click',function(){
		var self = $(this);
		var target = $(this).siblings('.body');
		target.stop(false, true).slideToggle();
		if(self.hasClass('open')){
			self.removeClass('open').addClass('close');
		} else {
			self.removeClass('close').addClass('open');
		}
	});
    $(window).resize(function() {
    	if($(window).width() <= parseInt(import.meta.env.VITE_BREAK_POINT)) {
            $('.toggleSwitchApply.spLayout').siblings('.body').stop(false, true).slideDown();
            $('.toggleSwitchApply.pcLayout').removeClass('close').addClass('open');
        }
    });

	$((function() {
		// 共通フォームValidation
		$.extend($.validator.messages, {
			minlength: "{0}文字以上入力して下さい。",
			maxlength: "{0}文字以下で入力して下さい。",
			required: "必須項目です。",
			digits: "半角数字で入力してください。",
			email: "Eメールの形式で入力して下さい。",
			number: "数字で入力してください。",
			equalTo: "メールアドレスと確認用メールアドレスが一致しません。"
		});
		$.each({
			katakana: function(e, r) {
				return this.optional(r) || /^[ア-ン゛゜ァ-ォャ-ョー「」、]+$/.test(e)
			},
			tel: function(e, r) {
				return this.optional(r) || /^[0-9\-]+$/.test(e)
			}
		}, (function(e) {
			$.validator.addMethod(e, this)
		})), $(".form01").validate({
			errorElement: "span",
			rules: {
				MailAddress: {email: !0},
				telNumber: {tel: !0, maxlength: 13},
				zipCode: {digits: !0, maxlength: 7},
				lastKana: {katakana: !0},
				firstKana: {katakana: !0},
				mailAddress: {email: !0},
				otherPCSkill: {maxlength: 1e3},
				qualification: {maxlength: 1e3},
				jobDescriptionA: {maxlength: 5e3},
				jobDescriptionB: {maxlength: 5e3},
				jobDescriptionC: {maxlength: 5e3},
				jobDescriptionD: {maxlength: 5e3},
				jobDescriptionE: {maxlength: 5e3},
				toeflScore: {number: !0, digits: !0},
				toeicScore: {number: !0, digits: !0},
				message: {maxlength: 1e3}
			},
			messages: {
				telNumber: {tel: "半角英数字とハイフンのみご入力ください。"},
				lastKana: {katakana: "全角カタカナでご入力ください。"},
				firstKana: {katakana: "全角カタカナでご入力ください。"},
			}
		})
	}));

	// 職務経歴追加
	$('.add > a').click(function(){

		var Cnt = $('#open').val();

		if (Cnt == '1') {
			$('#winB').removeClass('close').addClass('open');
			$('#open').val('2');
			$('#delA > a').css('display','inline');
		} else if (Cnt == '2') {
			$('#winC').removeClass('close').addClass('open');
			$('#open').val('3');
		} else if (Cnt == '3') {
			$('#winD').removeClass('close').addClass('open');
			$('#open').val('4');
		} else if (Cnt == '4') {
			$('#winE').removeClass('close').addClass('open');
			$('#open').val('5');
			$('.add > a').css('display','none');
		}


	});

	// 職務経歴削除
	$('#delA > a').click(function(){
		var val;
		var Cnt = $('#open').val()-0; Cnt = Cnt - 1;
		if (Cnt == 1) {
			$('#delA > a').css('display','none');
			$('#winB').removeClass('open').addClass('close');
		} else if (Cnt == 2) {
			$('#winC').removeClass('open').addClass('close');
		} else if (Cnt == 3) {
			$('#winD').removeClass('open').addClass('close');
		} else if (Cnt == 4) {
			$('#winE').removeClass('open').addClass('close');
		}
		$('#open').val(Cnt);
		$('.add > a').css('display','inline');
		
		val = $('#companyNameB').val(); $('#companyNameA').val(val);
		val = $('#startYearB').val(); $('#startYearA').val(val);
		val = $('#startMonthB').val(); $('#startMonthA').val(val);
		val = $('#endYearB').val(); $('#endYearA').val(val);
		val = $('#endMonthB').val(); $('#endMonthA').val(val);
		val = $('#employmentStatusB').val(); $('#employmentStatusA').val(val);
		val = $('#jobDescriptionB').val(); $('#jobDescriptionA').val(val);
		
		val = $('#companyNameC').val(); $('#companyNameB').val(val);
		val = $('#startYearC').val(); $('#startYearB').val(val);
		val = $('#startMonthC').val(); $('#startMonthB').val(val);
		val = $('#endYearC').val(); $('#endYearB').val(val);
		val = $('#endMonthC').val(); $('#endMonthB').val(val);
		val = $('#employmentStatusC').val(); $('#employmentStatusB').val(val);
		val = $('#jobDescriptionC').val(); $('#jobDescriptionB').val(val);
		
		val = $('#companyNameD').val(); $('#companyNameC').val(val);
		val = $('#startYearD').val(); $('#startYearC').val(val);
		val = $('#startMonthD').val(); $('#startMonthC').val(val);
		val = $('#endYearD').val(); $('#endYearC').val(val);
		val = $('#endMonthD').val(); $('#endMonthC').val(val);
		val = $('#employmentStatusD').val(); $('#employmentStatusC').val(val);
		val = $('#jobDescriptionD').val(); $('#jobDescriptionC').val(val);
		
		val = $('#companyNameE').val(); $('#companyNameD').val(val);
		val = $('#startYearE').val(); $('#startYearD').val(val);
		val = $('#startMonthE').val(); $('#startMonthD').val(val);
		val = $('#endYearE').val(); $('#endYearD').val(val);
		val = $('#endMonthE').val(); $('#endMonthD').val(val);
		val = $('#employmentStatusE').val(); $('#employmentStatusD').val(val);
		val = $('#jobDescriptionE').val(); $('#jobDescriptionD').val(val);
		
		$('#companyNameE').val('');
		$('#startYearE').val(-1);
		$('#startMonthE').val(-1);
		$('#endYearE').val(-1);
		$('#endMonthE').val(-1);
		$('#employmentStatusE').val(-1);
		$('#jobDescriptionE').val('');
	});
	$('#delB > a').click(function(){
		var val;
		var Cnt = $('#open').val()-0; Cnt = Cnt - 1;
		if (Cnt == 1) {
			$('#delA > a').css('display','none');
			$('#winB').removeClass('open').addClass('close');
		} else if (Cnt == 2) {
			$('#winC').removeClass('open').addClass('close');
		} else if (Cnt == 3) {
			$('#winD').removeClass('open').addClass('close');
		} else if (Cnt == 4) {
			$('#winE').removeClass('open').addClass('close');
		}
		$('#open').val(Cnt);
		$('.add > a').css('display','inline');
		
		val = $('#companyNameC').val(); $('#companyNameB').val(val);
		val = $('#startYearC').val(); $('#startYearB').val(val);
		val = $('#startMonthC').val(); $('#startMonthB').val(val);
		val = $('#endYearC').val(); $('#endYearB').val(val);
		val = $('#endMonthC').val(); $('#endMonthB').val(val);
		val = $('#employmentStatusC').val(); $('#employmentStatusB').val(val);
		val = $('#jobDescriptionC').val(); $('#jobDescriptionB').val(val);
		
		val = $('#companyNameD').val(); $('#companyNameC').val(val);
		val = $('#startYearD').val(); $('#startYearC').val(val);
		val = $('#startMonthD').val(); $('#startMonthC').val(val);
		val = $('#endYearD').val(); $('#endYearC').val(val);
		val = $('#endMonthD').val(); $('#endMonthC').val(val);
		val = $('#employmentStatusD').val(); $('#employmentStatusC').val(val);
		val = $('#jobDescriptionD').val(); $('#jobDescriptionC').val(val);
		
		val = $('#companyNameE').val(); $('#companyNameD').val(val);
		val = $('#startYearE').val(); $('#startYearD').val(val);
		val = $('#startMonthE').val(); $('#startMonthD').val(val);
		val = $('#endYearE').val(); $('#endYearD').val(val);
		val = $('#endMonthE').val(); $('#endMonthD').val(val);
		val = $('#employmentStatusE').val(); $('#employmentStatusD').val(val);
		val = $('#jobDescriptionE').val(); $('#jobDescriptionD').val(val);
		
		$('#companyNameE').val('');
		$('#startYearE').val(-1);
		$('#startMonthE').val(-1);
		$('#endYearE').val(-1);
		$('#endMonthE').val(-1);
		$('#employmentStatusE').val(-1);
		$('#jobDescriptionE').val('');
	});
	$('#delC > a').click(function(){
		var val;
		var Cnt = $('#open').val()-0; Cnt = Cnt - 1;
		if (Cnt == 1) {
			$('#delA > a').css('display','none');
			$('#winB').removeClass('open').addClass('close');
		} else if (Cnt == 2) {
			$('#winC').removeClass('open').addClass('close');
		} else if (Cnt == 3) {
			$('#winD').removeClass('open').addClass('close');
		} else if (Cnt == 4) {
			$('#winE').removeClass('open').addClass('close');
		}
		$('#open').val(Cnt);
		$('.add > a').css('display','inline');
		
		val = $('#companyNameD').val(); $('#companyNameC').val(val);
		val = $('#startYearD').val(); $('#startYearC').val(val);
		val = $('#startMonthD').val(); $('#startMonthC').val(val);
		val = $('#endYearD').val(); $('#endYearC').val(val);
		val = $('#endMonthD').val(); $('#endMonthC').val(val);
		val = $('#employmentStatusD').val(); $('#employmentStatusC').val(val);
		val = $('#jobDescriptionD').val(); $('#jobDescriptionC').val(val);
		
		val = $('#companyNameE').val(); $('#companyNameD').val(val);
		val = $('#startYearE').val(); $('#startYearD').val(val);
		val = $('#startMonthE').val(); $('#startMonthD').val(val);
		val = $('#endYearE').val(); $('#endYearD').val(val);
		val = $('#endMonthE').val(); $('#endMonthD').val(val);
		val = $('#employmentStatusE').val(); $('#employmentStatusD').val(val);
		val = $('#jobDescriptionE').val(); $('#jobDescriptionD').val(val);
		
		$('#companyNameE').val('');
		$('#startYearE').val(-1);
		$('#startMonthE').val(-1);
		$('#endYearE').val(-1);
		$('#endMonthE').val(-1);
		$('#employmentStatusE').val(-1);
		$('#jobDescriptionE').val('');
	});
	$('#delD > a').click(function(){
		var val;
		var Cnt = $('#open').val()-0; Cnt = Cnt - 1;
		if (Cnt == 1) {
			$('#delA > a').css('display','none');
			$('#winB').removeClass('open').addClass('close');
		} else if (Cnt == 2) {
			$('#winC').removeClass('open').addClass('close');
		} else if (Cnt == 3) {
			$('#winD').removeClass('open').addClass('close');
		} else if (Cnt == 4) {
			$('#winE').removeClass('open').addClass('close');
		}
		$('#open').val(Cnt);
		$('.add > a').css('display','inline');
		
		val = $('#companyNameE').val(); $('#companyNameD').val(val);
		val = $('#startYearE').val(); $('#startYearD').val(val);
		val = $('#startMonthE').val(); $('#startMonthD').val(val);
		val = $('#endYearE').val(); $('#endYearD').val(val);
		val = $('#endMonthE').val(); $('#endMonthD').val(val);
		val = $('#employmentStatusE').val(); $('#employmentStatusD').val(val);
		val = $('#jobDescriptionE').val(); $('#jobDescriptionD').val(val);
		
		$('#companyNameE').val('');
		$('#startYearE').val(-1);
		$('#startMonthE').val(-1);
		$('#endYearE').val(-1);
		$('#endMonthE').val(-1);
		$('#employmentStatusE').val(-1);
		$('#jobDescriptionE').val('');
	});
	$('#delE > a').click(function(){
		var val;
		var Cnt = $('#open').val()-0; Cnt = Cnt - 1;
		if (Cnt == 1) {
			$('#delA > a').css('display','none');
			$('#winB').removeClass('open').addClass('close');
		} else if (Cnt == 2) {
			$('#winC').removeClass('open').addClass('close');
		} else if (Cnt == 3) {
			$('#winD').removeClass('open').addClass('close');
		} else if (Cnt == 4) {
			$('#winE').removeClass('open').addClass('close');
		}
		$('#open').val(Cnt);
		$('.add > a').css('display','inline');
		
		$('#companyNameE').val('');
		$('#startYearE').val(-1);
		$('#startMonthE').val(-1);
		$('#endYearE').val(-1);
		$('#endMonthE').val(-1);
		$('#employmentStatusE').val(-1);
		$('#jobDescriptionE').val('');
	});

	// 住所選択
	$('.indicatorZip').on('click', initAddress);
	function initAddress() {
		let z = $('#zipCode');
		let p = $('#prefecture');
		let c = $('#city');
		let s = $('#street');
		if (z.val().length >= 7) {
			let code = z.val().slice(0,3) + z.val().slice(-4);

			let uri = new URL(window.location.href);
			let url = corp_url;

			$.ajaxSetup({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
			});
			$.ajax({
				url: url + '/form/selectZip',
				type: 'POST',
				cache: false,
				data: {
					'zip': code,
				},
			})
				.then((...args) => { // done
					const [data, textStatus, jqXHR] = args;
					// console.log('done', jqXHR.status, data);

					let zip = data[0].zip;
					let ken = data[0].kenCd;
					let key = data[0].shikuCd;
					let val = data[0].shikuMei;
					let town = data[0].tyouiki;
					if (zip != null) {
						// z.val(zip);
						p.val(ken);
						c.children().remove();
						c.append($("<option selected>").html(val).attr({ value: key }));
						s.val(town);
					}
				})
				.catch((...args) => { // fail
					const [jqXHR, textStatus, errorThrown] = args;
					// console.log('fail', jqXHR.status);
				})
		}
	}

	// 市区町村選択
	$('#prefecture').change(function(){
		let t = $(this).val();
		createCityOption(t);
	});
	function createCityOption(t){

		let c = $('#city');
		c.children().remove();
		c.append($("<option>").html('選択してください').attr({ value: '' }));
		if (t && (t !== -1)) {

			let uri = new URL(window.location.href);
			let url = corp_url;

			let key,val;
			$.ajaxSetup({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
			});
			$.ajax({
				url: url + '/form/selectPref',
				type: 'POST',
				cache: false,
				data: {
					'pref': t,
				},
			})
				.then((...args) => { // done
					const [data, textStatus, jqXHR] = args;

					data[0].forEach(function(d){
						let key = d.shikuCd;
						let val = d.shikuMei;
						c.append($("<option>").html(val).attr({ value: key }));
					});
				})
				.catch((...args) => { // fail
					const [jqXHR, textStatus, errorThrown] = args;
				})
		}
	}

});
