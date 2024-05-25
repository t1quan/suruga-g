$(function(){
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
