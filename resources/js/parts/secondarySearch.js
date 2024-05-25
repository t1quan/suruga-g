$(function(){
    //2次検索条件ボックス動作制御

    //2次検索条件ボックス　検索条件生成
	function searchboxSubmit(){
		var stus=0;
		var param_array=[];
		var param='';
		var sep='';
		//エリア
		var Bc = $('input[name="bcCheckbox"]:checked').map(function() { return this.value; });
		if (Bc.length!=0) {
			var val = 'bc='+ encodeURIComponent($.makeArray(Bc).join('[]'));
			param_array.push(val);
		}
		//都道府県
		if($('input[name="areaCheckbox"]:checked').length){
            var Area = $('input[name="areaCheckbox"]:checked').map(function() { return this.value; });
            var val = 'area=' + encodeURIComponent($.makeArray(Area).join('[]'));
            param_array.push(val);
        }
		//市区町村
		var City = $('input[name="cityCheckbox"]:checked').map(function() { return this.value; });
		if (City.length!=0) {
			var val = 'city='+ encodeURIComponent($.makeArray(City).join('[]'));
			param_array.push(val);
		}
		//職種分類
		var Jobbc = $('input[name="jobbcCheckbox"]:checked').map(function() { return this.value; });
		if (Jobbc.length!=0) {
			var val = 'jobbc='+ encodeURIComponent($.makeArray(Jobbc).join('[]'));
			param_array.push(val);
		}
		//職種
		var Job = $('input[name="jobCheckbox"]:checked').map(function() { return this.value; });
		if (Job.length!=0) {
			var val = 'job='+ encodeURIComponent($.makeArray(Job).join('[]'));
			param_array.push(val);
		}
		// // 給与入力チェック
		// var Kyuyo = '';
		// if($('select[name="kyuyo"]').val()){
		// 	Kyuyo = $('select[name="kyuyo"]').val();
		// }
		// if(Kyuyo){
		// 	var kyuyo_param = encodeURI(Kyuyo);
		// 	var kyuyo_param_array = kyuyo_param.split('-');
		// 	if(kyuyo_param_array.length = '2'){
		// 		var val = 'kyuyo='+kyuyo_param_array[0];
		// 		param_array.push(val);
		// 		var val = 'kyuyomin='+kyuyo_param_array[1];
		// 		param_array.push(val);
		// 	}
		// }
		//雇用形態
		var Koyo = $('input[name="koyoCheckbox"]:checked').map(function() { return this.value; });
		if(Koyo.length!=0){
            for(var i = 0;i < Koyo.length;i++){
                var val = Koyo[i]+'=1';
                param_array.push(val);
            }
		}
        // 特徴
        var Tokucho = $('input[name="tokuchoCheckbox"]:checked').map(function() { return this.value; });
        if (Tokucho.length > 0) {
            var val = 'tokucho='+ encodeURIComponent($.makeArray(Tokucho).join('[]'));
            param_array.push(val);
        }

        var Kyuyo = $('#mod-kyuyo-1').val();
        if(parseInt(Kyuyo) > 0){
            var val = 'kyuyo='+ encodeURIComponent(Kyuyo);
            param_array.push(val);
        }
        var KyuyoMin = $('#mod-kyuyo-2').val();
		if(parseInt(KyuyoMin) > 0){
			var val = 'kyuyomin='+ encodeURIComponent(KyuyoMin);
			param_array.push(val);
        }

		// キーワード
		var Keyword = $('input[name="kwCheckbox"]:checked').map(function() { return this.value; });
        if (Keyword.length!=0 || $('#sb-kw').val()) {
            let val = 'kw=';
            if(Keyword.length!=0) {
                val += encodeURIComponent($.makeArray(Keyword).join(' '));
            }
            if($('#sb-kw').val()){
                if(Keyword.length!=0) {
                    val += ' ';
                }
                 val += encodeURI($('#sb-kw').val());
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

	//2次検索条件ボックス　ボタンクリック時
    $(".jobSearchBtn").click(function(){
        searchboxSubmit();
        return false;
    });

    //2次検索条件ボックス　Enterキー押下時
    $("#sb-kw").on("keypress", function(event) {
    	if(event.key === 'Enter' && $('#sb-kw').val()){
            searchboxSubmit();
    		return false;
    	}else{
    		return true;
    	}
    });

    //検索条件欄　toggle制御
    $('.jobSearchFormTgl').click(function(){
        if ($(this).hasClass('open')) {//OPENだったら
            $(this).removeClass('open');
            $(this).addClass('close');
            $(this).parent().find('#jobSearchForm').each(function( index, element ) {
                $(element).slideUp(300);
                return false;
            })
        }else{//閉じていたら
            $(this).removeClass('close');
            $(this).addClass('open');
            $(this).parent().find('#jobSearchForm').each(function( index, element ) {
                $(element).slideDown(300);
                return false;
            })
        }
    });

    //検索条件欄　検索軸一覧アコーディオン動作制御
    $('.searchCondList .searchListLabel').click(function(){
        if ($(this).hasClass('open')) {//OPENだったら
            $(this).removeClass('open');
            $(this).addClass('close');
            $(this).parent().find('.searchListBody').each(function( index, element ) {
              $(element).slideUp(300);
              return false;
            })
        }else{//閉じていたら
            $(this).removeClass('close');
            $(this).addClass('open');
            $(this).parent().find('.searchListBody').each(function( index, element ) {
              $(element).slideDown(300);
              return false;
            })
        }
    });

    //検索条件欄　検索軸一覧チェックボックス制御
    function checkboxClick(id){
        var id_array = id.split('-');
        var searchid = '';
        var parentid = '';
        var chk_ari_flg = false;
        var chk_nashi_flg = false;
        if(id_array.length > 1){
            for(var i=0; i<(id_array.length - 1); i++){
                searchid += id_array[i]+'-';
                if(parentid){
                    parentid += '-';
                }
                parentid += id_array[i];
            }
            $("[id^="+searchid+"]").each(function(){
                var chk_flg = $(this).prop('checked');
                if(chk_flg){
                    chk_ari_flg = true;
                }else{
                    chk_nashi_flg = true;
                }
            });
            var parent_chk = false;
            if(chk_ari_flg && !chk_nashi_flg){
                parent_chk = true;
            }else{
                parent_chk = false;
            }

            //親要素
            var edit_id = '';
            edit_id = parentid;
            $("#"+edit_id).prop('checked',parent_chk);
            //callback
            checkboxClick(edit_id);
        }
    }

    //検索条件欄　検索軸一覧チェックボックスクリック時
    $('#jobSearchForm input:checkbox').click(function(){
        var id = $(this).attr('id');
        var chk = $(this).prop('checked');

        if(id.match(/-/)){
            //配下要素
            $("[id^="+id+"-]").each(function(){
                $(this).prop('checked', chk);
            });

            //callback
            checkboxClick(id);
        }
    });
});