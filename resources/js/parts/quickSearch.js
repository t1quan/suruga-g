$(function() {
    //quicksearchのSubmit
    function quickSearchSubmit() {
        let val = '';
        let data_arys = [];
        let search_url = $("#quick_search_url").val();
        if($('#quickSearchArea').val() && $('#quickSearchArea').val() != '-1'){
            let quick_area = $('#quickSearchArea').val();
            quick_area = encodeURIComponent(quick_area);
            data_arys.push(quick_area);
        }
        if($('#quickSearchSyksy').val() && $('#quickSearchSyksy').val() != '-1'){
            let quick_syksy = $('#quickSearchSyksy').val();
            quick_syksy = encodeURIComponent(quick_syksy);
            data_arys.push(quick_syksy);
        }
        if($('#quickSearchKoy').val() && $('#quickSearchKoy').val() != '-1'){
            let quick_koy = $('#quickSearchKoy').val();
            quick_koy = encodeURIComponent(quick_koy);
            data_arys.push(quick_koy);
        }
        if($('#quicksearchWord').val()){
            let quick_word = $('#quicksearchWord').val();
            quick_word = 'kw_' + encodeURIComponent(quick_word);
            data_arys.push(quick_word);
        }
        val = data_arys.join('/');
        if(val){
            location.href = search_url + val;
        }else{
            location.href = search_url + 'custom?';
        }
        return false;
    }

    //quicksearchのSubmit(カスタム検索用)
    function quickCustomSearchSubmit() {
        let val = '';
        let data_arys = [];
        let search_url = $("#quick_search_url").val();
        if($('#quickSearchArea').val() && $('#quickSearchArea').val() != '-1'){
            let quick_area = $('#quickSearchArea').val();
            quick_area = encodeURI(quick_area);
            data_arys.push(quick_area);
        }
        if($('#quickSearchSyksy').val() && $('#quickSearchSyksy').val() != '-1'){
            let quick_syksy = $('#quickSearchSyksy').val();
            let type = quick_syksy.substr(0, quick_syksy.indexOf('='));
            if(type !== 'kw') {
                quick_syksy = encodeURI(quick_syksy);
                data_arys.push(quick_syksy);
                if($('#quicksearchWord').val()) {
                    let quick_word = $('#quicksearchWord').val();
                    quick_word = 'kw=' + encodeURIComponent(quick_word);
                    data_arys.push(quick_word);
                }
            }
            else {
                let quick_word = $('#quickSearchSyksy').val();
                if($('#quicksearchWord').val()) {
                    quick_word = quick_word + ' ' + $('#quicksearchWord').val();
                }
                quick_word = encodeURI(quick_word);
                data_arys.push(quick_word);
            }
        }
        else {
            if($('#quicksearchWord').val()) {
                let quick_word = $('#quicksearchWord').val();
                quick_word = 'kw=' + encodeURIComponent(quick_word);
                data_arys.push(quick_word);
            }
        }
        if($('#quickSearchKoy').val() && $('#quickSearchKoy').val() != '-1'){
            let quick_koy = $('#quickSearchKoy').val();
            quick_koy = encodeURI(quick_koy);
            data_arys.push(quick_koy);
        }

        val = data_arys.join('&');
        location.href = search_url + val;
    }

    //quicksearchのSubmitボタン
    $('#quicksearchSubmit').click(function() {
        quickSearchSubmit();
    });

    //quicksearchのSubmitボタン(カスタム検索用)
    $('#quicksearchSubmitCustom').click(function() {
        quickCustomSearchSubmit();
    });

    //quickSearchbox text enter-key
    $("#quicksearchWord").on("keypress", function(event) {
        if(event.key === 'Enter' && $('#quicksearchWord').val()){
            //enter-key
            if(document.getElementById("quicksearchSubmit") != null) {
                quickSearchSubmit(); //通常軸で検索
                return false;
            }
            else if (document.getElementById("quicksearchSubmitCustom") != null) {
                quickCustomSearchSubmit(); //カスタム軸で検索
                return false;
            }
            else {
                return true;
            }
        }else{
            return true;
        }
    });
});





