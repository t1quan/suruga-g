$(function(){

	function initModal() {

		$("#searchBox #modal-1 .parentBox, #searchBox .childrenBox").each(function() {
			$(this).css({'display': 'none'});
		});

		$("#searchBox .grandParent, #searchBox .parent").each(function() {
			$(this).removeClass('active');
			$(this).removeClass('selected');
		});

		let locationGrandParent = $('#modal-1 .grandParent').first();
		locationGrandParent.addClass('active');

		//エリア選択
		let locationParentId = "area-" + locationGrandParent.data('id');
		let locationParentBox = $('#'+locationParentId);
		locationParentBox.css({'display': 'flex'});
		let locationParent = locationParentBox.find('.parent').first();
		locationParent.addClass('active');

		let locationChildId = "pref-" + locationParent.data('id');
		let locationChildBox = $('#'+locationChildId);
		locationChildBox.css({'display': 'block'});

		//職種選択
		let jobParent = $('#modal-2 .parent').first();
		jobParent.addClass('active');

		let jobChildId = "job-" + jobParent.data('id');
		let jobChildBox = $('#'+jobChildId);
		jobChildBox.css({'display': 'block'});

		//こだわり選択
		$("#searchBox #modal-3 .childrenBox").css({'display': 'block'});

		//給与選択
		let salaryParent = $('#modal-4 .parent').first();
		salaryParent.addClass('active');

		let salaryChildId = "salary-" + salaryParent.data('id');
		let salaryChildBox = $('#'+salaryChildId);
		salaryChildBox.css({'display': 'block'});

		$('#searchBox .child input[type=checkbox]').removeAttr('checked').prop('checked', false).change(); //選択状態初期化
	}

	//モーダル内要素初期表示処理
	$(document).ready(function() {
		initModal();
	});

	//検索ボックス　モーダル表示切替制御
	$('.openModal, .guide-content').click(function(){

		if(window.innerWidth < (parseInt(import.meta.env.VITE_BREAK_POINT)+1)) {
			$('#headerMenu .headerNav').css({'display': 'none'});
		}

		let targetId = $(this).data('id');
		let modalId = "modal-" + targetId;
		let guideId = "modal-guide-" + targetId;
		$('#modalArea').fadeIn();
		$('.modalAxis').each(function() {
			$(this).css({'display': 'none'});
		});
		$('.guide-content').each(function() {
			$(this).removeClass('active');
		});
		let targetModal = $('#'+modalId);
		let targetGuide = $('#'+guideId);
		targetModal.css({'display': 'block'});
		targetGuide.addClass('active');
		$(this).parents('body').addClass('modalOn');//背景要素を固定
	});

	//モーダルクローズ時
	$('#closeModal , #modalBg').click(function(){

		if(window.innerWidth < (parseInt(import.meta.env.VITE_BREAK_POINT)+1)) {
			$('#headerMenu .headerNav').css({'display': ''});
		}

		$(this).parents('body').removeClass('modalOn');//背景要素固定を解除
		$('#modalArea').fadeOut();
		setTimeout(function(){
			initModal();
		},500);
	});

	//PC版モーダル start

	//エリア選択　地域要素クリック時
	$('#searchBox #modal-1 .grandParent').click(function(){
		let targetId = $(this).data('id');
		let areaId = "area-" + targetId;
		$('#searchBox #modal-1 .grandParent, .parent').each(function() {
			$(this).removeClass('active');
		});
		$('#searchBox #modal-1 .parentBox, #searchBox #modal-1 .childrenBox').each(function() {
			$(this).css({'display': 'none'});
		});
		let targetBox = $('#'+areaId);
		let targetChildrenId = targetBox.find('.parent').first().data('id');
		let targetChildrenBox = $('#pref-'+targetChildrenId);
		targetBox.css({'display': 'flex'});
		targetChildrenBox.css({'display': 'block'});
		$(this).addClass('active');
		targetBox.find('.parent').first().addClass('active');
	});

	//エリア選択　都道府県要素クリック時
	$('#searchBox #modal-1 .parent').click(function(){
		let targetId = $(this).data('id');
		let prefId = "pref-" + targetId;
		$('#searchBox #modal-1 .parent').each(function() {
			$(this).removeClass('active');
		});
		$('#searchBox #modal-1 .childrenBox').each(function() {
			$(this).css({'display': 'none'});
			$(this).removeClass('active');
		});
		let targetBox = $('#'+prefId);
		targetBox.css({'display': 'block'});
		$(this).addClass('active');
	});

	//エリア選択 市区町村要素クリック時
	$('#searchBox #modal-1 .child input[type=checkbox]').change(function() {

		$(this).closest('.child').removeClass('selected'); //初期化
		if($(this).prop('checked')) {
			$(this).closest('.child').addClass('selected');
		}

		let targetId = $(this).attr('id');
		let targetIdSp = targetId + '-sp'; //末尾"-sp"を追加
		let target = $('#' + targetIdSp);

		if(target.prop('checked') !== $(this).prop('checked'))  {
			target.prop('checked', $(this).prop('checked')).change(); //チェック状態を連動
		}

		//都道府県単位の表示制御 start
		let parentId = $(this).closest('.child').data('id');

		let expression = '#modal-1 .parent[data-id=' + parentId +']';
		let targetParent = $(expression);
		targetParent.removeClass('selected'); //初期化

		$('#modal-guide-1').removeClass('selected');

		let targetChildrenBox =$(this).closest('.childrenBox');

		let isSelectedParent = false;

		targetChildrenBox.find('.child input').each(function() {
			if($(this).prop('checked')) {
				isSelectedParent = true;
				return false;
			}
		});

		if(isSelectedParent) {
			targetParent.addClass('selected');
		}
		//都道府県単位の表示制御 end

		//地域単位の表示制御 start
		let targetParentsBox = targetParent.closest('.parentBox');
		let grandParentId = targetParentsBox.data('id');

		expression = '#modal-1 .grandParent[data-id=' + grandParentId +']';
		let targetGrandParent = $(expression);
		targetGrandParent.removeClass('selected'); //初期化

		let isSelectedGrandParent = false;

		targetParentsBox.find('.parent').each(function() {
			if($(this).hasClass('selected')) {
				isSelectedGrandParent = true;
				return false;
			}
		});

		if(isSelectedGrandParent) {
			targetGrandParent.addClass('selected');
		}
		//エリア単位の表示制御 end


		//エリア検索軸全体の選択状態表示制御 start
		let grandParentBox = $('#modal-1 .grandParentBox');
		grandParentBox.find('.grandParent').each(function() {
			if($(this).hasClass('selected')) {
				$('#modal-guide-1').addClass('selected');
				return false;
			}
		});
		//エリア検索軸全体の選択状態表示制御 end

	});

	//職種選択　職種分類要素クリック時
	$('#searchBox #modal-2 .parent').click(function(){
		let targetId = $(this).data('id');
		$(this).addClass('active');
		let jobId = "job-" + targetId;
		$('#searchBox #modal-2 .parent').each(function() {
			$(this).removeClass('active');
		});
		$('#searchBox #modal-2 .childrenBox').each(function() {
			$(this).css({'display': 'none'});
			$(this).removeClass('active');
		});
		let targetBox = $('#'+jobId);
		targetBox.css({'display': 'block'});
		$(this).addClass('active');
	});

	//職種選択 職種要素クリック時
	$('#searchBox #modal-2 .child input[type=checkbox]').change(function() {

		$(this).closest('.child').removeClass('selected'); //初期化
		if($(this).prop('checked')) {
			$(this).closest('.child').addClass('selected');
		}

		let targetId = $(this).attr('id');
		let targetIdSp = targetId + '-sp'; //末尾"-sp"を追加
		let target = $('#' + targetIdSp);

		if(target.prop('checked') !== $(this).prop('checked'))  {
			target.prop('checked', $(this).prop('checked')).change(); //チェック状態を連動
		}

		let parentId = $(this).closest('.child').data('id');

		let expression = '#modal-2 .parent[data-id=' + parentId +']';
		let targetParent = $(expression);
		targetParent.removeClass('selected'); //初期化
		$('#modal-guide-2').removeClass('selected');

		let targetChildrenBox =$(this).closest('.childrenBox');

		let isSelectedParent = false;

		targetChildrenBox.find('.child input').each(function() {
			if($(this).prop('checked')) {
				isSelectedParent = true;
				return false;
			}
		});

		if(isSelectedParent) {
			targetParent.addClass('selected');
		}

		//職種検索軸全体の選択状態表示制御 start
		let parentBox = $('#modal-2 .parentBox');
		parentBox.find('.parent').each(function() {
			if($(this).hasClass('selected')) {
				$('#modal-guide-2').addClass('selected');
				return false;
			}
		});
		//職種検索軸全体の選択状態表示制御 end
	});

	//こだわり選択 要素クリック時
	$('#searchBox #modal-3 .child input[type=checkbox]').change(function() {

		$(this).closest('.child').removeClass('selected'); //初期化
		if($(this).prop('checked')) {
			$(this).closest('.child').addClass('selected');
		}

		let targetId = $(this).attr('id');
		let targetIdSp = targetId + '-sp'; //末尾"-sp"を追加
		let target = $('#' + targetIdSp);

		if(target.prop('checked') !== $(this).prop('checked'))  {
			target.prop('checked', $(this).prop('checked')).change(); //チェック状態を連動
		}

		$('#modal-guide-3').removeClass('selected');
		let targetChildrenBox =$(this).closest('.childrenBox');

		targetChildrenBox.find('.child input').each(function() {
			if($(this).prop('checked')) {
				$('#modal-guide-3').addClass('selected');
				return false;
			}
		});
	});

	//給与選択　給与分類要素クリック時
	$('#searchBox #modal-4 .parent').click(function(){
		let targetId = $(this).data('id');
		$(this).addClass('active');
		let salaryTypeId = "salary-" + targetId;
		$('#searchBox #modal-4 .parent').each(function() {
			$(this).removeClass('active');
		});
		$('#searchBox #modal-4 .childrenBox').each(function() {
			$(this).css({'display': 'none'});
			$(this).removeClass('active');
		});
		let targetBox = $('#'+salaryTypeId);
		targetBox.css({'display': 'block'});
		$(this).addClass('active');
	});

	//給与選択 給与要素クリック時
	$('#searchBox #modal-4 .child input[type=checkbox]').change(function() {

		let targetId = $(this).attr('id');
		let targetIdSp = targetId + '-sp'; //末尾"-sp"を追加
		let target = $('#' + targetIdSp);

		if(target.prop('checked') !== $(this).prop('checked'))  {
			target.prop('checked', $(this).prop('checked')).change(); //チェック状態を連動
		}

		if(!$(this).prop('checked')) {
			$(this).closest('.child').removeClass('selected'); //初期化

			$('#modal-4 .parent').each(function() {
				$(this).removeClass('selected'); //初期化
			});

			$('#modal-guide-4').removeClass('selected');　//初期化

			return false;
		}

		let currentId = $(this).attr('id');
		$(this).closest('.child').addClass('selected');


		let parentId = $(this).closest('.child').data('id');

		let expression = '#modal-4 .parent[data-id=' + parentId +']';
		let targetParent = $(expression);

		let targetChildrenBox =$(this).closest('.childrenBox');
		let otherChidrenBox = targetChildrenBox.next(); //次の隣接要素を検索

		if(otherChidrenBox.length === 0) {
			otherChidrenBox = targetChildrenBox.prev(); //前の隣接要素を検索
		}

		targetChildrenBox.find('.child input').each(function() {
			if($(this).prop('checked')) {
				if($(this).attr('id') !== currentId) {
					$(this).prop('checked', false).change();
				}
			}
		});

		otherChidrenBox.find('.child input').each(function() {
			if($(this).prop('checked')) {
				$(this).prop('checked', false).change();
			}
		});

		targetParent.addClass('selected');

		//給与検索軸全体の選択状態表示制御 start
		let parentBox = $('#modal-4 .parentBox');
		parentBox.find('.parent').each(function() {
			if($(this).hasClass('selected')) {
				$('#modal-guide-4').addClass('selected');
				return false;
			}
		});
		//給与検索軸全体の選択状態表示制御 end

	});

	//中分類内要素 全選択ボタンクリック時
	$('#searchBox .childrenBox .select-all').click(function(){
		let targetChildrenBox = $(this).parent('.childrenBox');

		targetChildrenBox.find('.child input').each(function() {
			$(this).prop('checked', true).change();
		});
	});

	//モーダル間共通 「すべての条件をクリア」ボタンクリック時
	$('#searchBox .searchBtns .reset-all').click(function(){
		$('#searchBox .child input[type=checkbox]').removeAttr('checked').prop('checked', false).change();
	});

	//PC版モーダル end

	//-----------------------------------------------------

	//SP版アコーディオン start
	//エリア選択時
	$('#searchBox #modal-1 .grandParentSP >label input[type=checkbox]').change(function() {
		//開閉状態制御
		if($(this).closest('.grandParentSP').hasClass('close')) {
			$(this).closest('.grandParentSP').removeClass('close');
			$(this).closest('.grandParentSP').addClass('open');
		}
		else {
			$(this).closest('.grandParentSP').removeClass('open');
			$(this).closest('.grandParentSP').addClass('close');
		}

		$(this).parent('label').next('ul').slideToggle();
	});

	//SP版アコーディオン　都道府県ラベルクリック時
	$('#searchBox #modal-1 .parentSP').click(function(e) {
		if(e.target.closest('.spCheckParent')){
			return false;
		}

		if(e.target.closest('.childSP')){
			return false;
		}

		//開閉状態制御
		if($(this).hasClass('close')) {
			$(this).removeClass('close');
			$(this).addClass('open');
		}
		else {
			$(this).removeClass('open');
			$(this).addClass('close');
		}

		$(this).children('ul').slideToggle();
	});

	//SP版アコーディオン　都道府県チェックボックスクリック時
	$('#searchBox #modal-1 .parentSP .spCheckParent').click(function(){
		if($(this).next('input[type=checkbox]').prop('checked')) { //選択済の場合
			$(this).parent('.parentSP').removeClass('selected');
			$(this).next('input[type=checkbox]').prop('checked', false).change();
			$(this).parent('.parentSP').find('.childSP').each(function() {
				$(this).removeClass('selected');
				$(this).children('label').children('input').prop('checked', false).change();
			});
		}
		else { //選択されていない場合
			$(this).parent('.parentSP').addClass('selected');
			$(this).next('input[type=checkbox]').prop('checked', true).change();
			$(this).parent('.parentSP').find('.childSP').each(function() {
				$(this).addClass('selected');
				$(this).children('label').children('input').prop('checked', true).change();
			});
		}
	});

	//SP版アコーディオン　市区町村クリック時
	$('#searchBox #modal-1 .childSP label').click(function(){
		if($(this).children('input').prop('checked') === true) {
			$(this).children('input').prop('checked', false).change();
		}
		else {
			$(this).children('input').prop('checked', true).change();
		}
	});

	// //checked属性変更時
	$('#searchBox #modal-1 .childSP input[type=checkbox]').change(function() {

		let targetIdSp = $(this).attr('id');
		let targetId = targetIdSp.replace('-sp', ''); //末尾"-sp"を削除
		let target = $('#' + targetId);

		if(target.prop('checked') !== $(this).prop('checked'))  {
			target.prop('checked', $(this).prop('checked')).change(); //チェック状態を連動
		}

		$(this).closest('.childSP').removeClass('selected'); //初期化
		if($(this).prop('checked')) {
			$(this).closest('.childSP').addClass('selected');
		}

		//都道府県要素表示制御 start
		let targetParent = $(this).closest('.parentSP');

		targetParent.removeClass('selected'); //初期化
		targetParent.children('input[type=checkbox]').prop('checked', false).change(); //初期化

		targetParent.children('ul').find('.childSP input[type=checkbox]').each(function() {
			if($(this).prop('checked')) {
				targetParent.addClass('selected');
				targetParent.children('input[type=checkbox]').prop('checked', true).change();
				return false;
			}
		});
		//都道府県要素表示制御 start
	});


	//SP版アコーディオン　職種分類ラベルクリック時
	$('#searchBox #modal-2 .parentSP').click(function(e) {
		if(e.target.closest('.spCheckParent')){
			return false;
		}

		if(e.target.closest('.childSP')){
			return false;
		}

		//開閉状態制御
		if($(this).hasClass('close')) {
			$(this).removeClass('close');
			$(this).addClass('open');
		}
		else {
			$(this).removeClass('open');
			$(this).addClass('close');
		}

		$(this).children('ul').slideToggle();
	});

	//SP版アコーディオン　職種分類チェックボックスクリック時
	$('#searchBox #modal-2 .parentSP .spCheckParent').click(function(){
		if($(this).next('input[type=checkbox]').prop('checked')) { //選択済の場合
			$(this).parent('.parentSP').removeClass('selected');
			$(this).next('input[type=checkbox]').prop('checked', false).change();
			$(this).parent('.parentSP').find('.childSP').each(function() {
				$(this).removeClass('selected');
				$(this).children('label').children('input').prop('checked', false).change();
			});
		}
		else { //選択されていない場合
			$(this).parent('.parentSP').addClass('selected');
			$(this).next('input[type=checkbox]').prop('checked', true).change();
			$(this).parent('.parentSP').find('.childSP').each(function() {
				$(this).addClass('selected');
				$(this).children('label').children('input').prop('checked', true).change();
			});
		}
	});

	//SP版アコーディオン　職種クリック時
	$('#searchBox #modal-2 .childSP label').click(function(){
		if($(this).children('input').prop('checked') === true) {
			$(this).children('input').prop('checked', false).change();
		}
		else {
			$(this).children('input').prop('checked', true).change();
		}
	});

	// //checked属性変更時
	$('#searchBox #modal-2 .childSP input[type=checkbox]').change(function() {

		let targetIdSp = $(this).attr('id');
		let targetId = targetIdSp.replace('-sp', ''); //末尾"-sp"を削除
		let target = $('#' + targetId);

		if(target.prop('checked') !== $(this).prop('checked'))  {
			target.prop('checked', $(this).prop('checked')).change(); //チェック状態を連動
		}

		$(this).closest('.childSP').removeClass('selected'); //初期化
		if($(this).prop('checked')) {
			$(this).closest('.childSP').addClass('selected');
		}

		//職種分類要素表示制御 start
		let targetParent = $(this).closest('.parentSP');

		targetParent.removeClass('selected'); //初期化
		targetParent.children('input[type=checkbox]').prop('checked', false).change(); //初期化

		targetParent.children('ul').find('.childSP input[type=checkbox]').each(function() {
			if($(this).prop('checked')) {
				targetParent.addClass('selected');
				targetParent.children('input[type=checkbox]').prop('checked', true).change();
				return false;
			}
		});
		//職種分類要素表示制御 start
	});


	//SP版アコーディオン　こだわりクリック時
	$('#searchBox #modal-3 .childSP label').click(function(){
		if($(this).children('input').prop('checked') === true) {
			$(this).children('input').prop('checked', false).change();
		}
		else {
			$(this).children('input').prop('checked', true).change();
		}
	});

	// //checked属性変更時
	$('#searchBox #modal-3 .childSP input[type=checkbox]').change(function() {

		let targetIdSp = $(this).attr('id');
		let targetId = targetIdSp.replace('-sp', ''); //末尾"-sp"を削除
		let target = $('#' + targetId);

		if(target.prop('checked') !== $(this).prop('checked'))  {
			target.prop('checked', $(this).prop('checked')).change(); //チェック状態を連動
		}

		$(this).closest('.childSP').removeClass('selected'); //初期化
		if($(this).prop('checked')) {
			$(this).closest('.childSP').addClass('selected');
		}
	});


	//SP版アコーディオン　給与分類ラベルクリック時
	$('#searchBox #modal-4 .parentSP').click(function(e) {

		if(e.target.closest('.childSP')){
			return false;
		}

		//開閉状態制御
		if($(this).hasClass('close')) {
			$(this).removeClass('close');
			$(this).addClass('open');
		}
		else {
			$(this).removeClass('open');
			$(this).addClass('close');
		}

		$(this).children('ul').slideToggle();
	});

	//SP版アコーディオン　給与クリック時
	$('#searchBox #modal-4 .childSP label').click(function(){
		if($(this).children('input').prop('checked') === true) {
			$(this).children('input').prop('checked', false).change();
		}
		else {
			$(this).children('input').prop('checked', true).change();
		}
	});

	// //checked属性変更時
	$('#searchBox #modal-4 .childSP input[type=checkbox]').change(function() {

		let targetIdSp = $(this).attr('id');
		let targetId = targetIdSp.replace('-sp', ''); //末尾"-sp"を削除
		let target = $('#' + targetId);

		if(target.prop('checked') !== $(this).prop('checked'))  {
			target.prop('checked', $(this).prop('checked')).change(); //チェック状態を連動
		}

		$(this).closest('.childSP').removeClass('selected'); //初期化
		if($(this).prop('checked')) {
			$(this).closest('.childSP').addClass('selected');
		}
	});


	// //検索ボックス 検索条件生成
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

	//モーダル検索ボックス　検索条件生成
	function searchboxModalSubmit(){
		var stus=0;
		var param_array=[];
		var param='';
		var sep='';

		//都道府県
		if($('#modal-1 .parent.selected').length) {
			let arr = [];
			$('#modal-1 .parent.selected').each(function() {
				let targetId = $(this).data('id');
				let targetChildrenBox = $('#pref-'+targetId);

				let isSelectAll = true;

				targetChildrenBox.find('.child input').each(function() {
					if(!$(this).prop('checked')) {
						isSelectAll = false;
						return false;
					}
				});

				if(isSelectAll) {
					arr.push(targetId);
				}
			});

			if(arr.length) {
				var val = 'area=' + encodeURIComponent($.makeArray(arr).join('[]'));
				param_array.push(val);
			}
		}

		//市区町村
		var City = $('#modal-1 input[name="modal-cityCheckbox"]:checked').map(function() { return this.value; });
		if (City.length!=0) {
			var val = 'city='+ encodeURIComponent($.makeArray(City).join('[]'));
			param_array.push(val);
		}

		//給与
		var kyuyo = $('input[name="modal-salaryCheckbox"]:checked').map(function() { return this.value; });
		if (kyuyo.length!=0) {
			let val = kyuyo[0];
			param_array.push(val);
		}

		// キーワード
		var Keyword = $('input[name="modal-kwCheckbox"]:checked').map(function() { return this.value; });
		if (Keyword.length!=0) {
			let val = 'kw=';
			if(Keyword.length!=0) {
				val += encodeURIComponent($.makeArray(Keyword).join(' '));
			}
			param_array.push(val);
		}

		// 備考欄
		var Biko = $('input[name="modal-bkCheckbox"]:checked').map(function() { return this.value; });
		if (Biko.length!=0) {
			let val = 'bk=';
			if(Biko.length!=0) {
				val += encodeURIComponent($.makeArray(Biko).join(' '));
			}
			param_array.push(val);
		}

		//query
		if(param_array){
			param = param_array.join("&");
		}

		//URL
		var search_url = $("#search_url").val();
		location.href=search_url+'?'+param;
		return false;
	}

	//検索ボックス　ボタンクリック時
	$(".search-exec").click(function(){
		searchboxModalSubmit();
		return false;
	});
});
