import UtCookie from "../UtCookie";

const COOKIE_TIMESTAMP_EXPIRATION = 6;
const SEPARATE_SYMBOL = ","; // 複数IDの連結子
//TIMESTAMP_JOINT = "[]"; // タイムスタンプ部分の切り出しポイント
// VITE_SUFFIX_SYMBOL = "_"; //接尾辞や固有語尾の切り出しポイント // 案件ごとに仕事番号の付け方が異なるのでenvから取得する

// お気に入りボタンによるCookieの制御を行う
function toggleFavorite(id, $cookieName){
    let $id = id;
    let $cookie = UtCookie.getCookie($cookieName);
    let $newList = [];
    let $delListTarget = [];
    let $targetId = null;
    let $isFavorite = true;
    let date = new Date();
    let $timestamp = date.getTime();

    let $isPrefixMatch = import.meta.env.VITE_PREFIX_MATCH;

    if($cookie){ //既にcookieが存在する場合(更新)
        let $ary = $cookie.split(SEPARATE_SYMBOL);
        let $updListTarget = null;
        if($ary.length > 0) {
            for (let $i = 0; $i < $ary.length; $i++) {
                $targetId = $ary[$i];
                // タイムスタンプ除外
                let $ids = String($targetId).split(import.meta.env.VITE_TIMESTAMP_JOINT);
                if ($ids.length > 0){
                    $targetId = $ids[0];
                }
                // 押された求人がお気に入りに登録されていなかった場合 / 登録されていた場合

                if ($isPrefixMatch === 'true') { //前方一致フラグが立っている場合 (文字列として渡ってくるのでBooleanではなく文字列で判定)
                    if(String($id).startsWith($targetId)) { //押された求人の仕事番号(id)が、targetId(区切り文字で分割されてcookieに保存されている仕事番号)から始まるか
                        $isFavorite = false; // 前方一致したため削除、リストに再追加しない
                        $delListTarget.push($targetId);
                    }
                    else {
                        $updListTarget = ([$targetId, $timestamp]).join(import.meta.env.VITE_TIMESTAMP_JOINT); //お気に入りボタンを押した時点でのタイムスタンプで更新
                        $newList.push($updListTarget); //リストに入っていた仕事番号をタイムスタンプ更新して再追加
                    }
                }
                else { //前方一致フラグが立っていない(完全一致)の場合
                    if ($targetId == $id) {
                        $isFavorite = false; // 完全一致したため削除、リストに再追加しない
                        $delListTarget.push($targetId);
                    } else {
                        $updListTarget = ([$targetId, $timestamp]).join(import.meta.env.VITE_TIMESTAMP_JOINT); //お気に入りボタンを押した時点でのタイムスタンプで更新
                        $newList.push($updListTarget); //リストに入っていた仕事番号をタイムスタンプ更新して再追加
                    }
                }
            }
        }
    }

    // お気に入り件数制御
    let count = 0;
    let badgeElm = $('.header_navitems .badge')[0];
    if (badgeElm) {
        count = $(badgeElm).text();
    }

    if ($isPrefixMatch === 'true') {
        //部分一致なのでクリックで渡ってきた仕事番号も区切り文字で分割する
        let $shavedId = String($id).split(import.meta.env.VITE_SUFFIX_SYMBOL);
        if($shavedId.length < 3) {
            $id = $shavedId[0];
        }
        else {
            $id = $shavedId.slice(0,($shavedId.length - 1)).join(import.meta.env.VITE_SUFFIX_SYMBOL);
        }
    }

    if($isFavorite){ //お気に入りに追加する場合
        let $addListTarget = ([$id, $timestamp]).join(import.meta.env.VITE_TIMESTAMP_JOINT);
        $newList.push($addListTarget); //「お気に入り」ボタンを押された求人の仕事番号をリストに追加

        // 気になるボタンが複数箇所にあるので同期する
        $('.js-favLink').map(function(key,elem){
            let $did = $(elem).attr('data-jmc');

            if ($isPrefixMatch === 'true') { //前方一致の場合
                if(String($did).startsWith($id)) { //対象の求人の仕事番号が「お気に入り」ボタンを押された求人の末尾区切り文字までの仕事番号から始まるか
                    $(elem).addClass('favo');
                    $(elem).removeClass('add');
                }
            }
            else { //完全一致の場合
                if($id == $did){
                    $(elem).addClass('favo');
                    $(elem).removeClass('add');
                }
            }
        });
        count = Number(count) + 1;

    }else{ //お気に入りから削除する場合

        $('.js-favLink').map(function(key,elem){
            let $did = $(elem).attr('data-jmc');

            $.each($delListTarget, function(index, target) {
                if ($isPrefixMatch === 'true') { //前方一致の場合
                    if(String($did).startsWith(target)) { //対象の求人の仕事番号が、target(cookieに保存されている削除対象となった仕事番号)から始まるか
                        $(elem).addClass('add');
                        $(elem).removeClass('favo');
                    }
                }
                else {
                    if(target == $did){ //完全一致の場合
                        $(elem).addClass('add');
                        $(elem).removeClass('favo');
                    }
                }
            })
        });
        count = Number(count) - 1;
        if (count < 0) {
            count = 0;
        }
    }

    if (badgeElm) {
        $(badgeElm).text(String(count));
    } else {
        $('.header_navitems .heartBox').append('<span class="badge">'+String(count)+'</span>');
    }

    $('.header_navitems .badge').map(function(key,elem){
        $(elem).text(String(count));
    });

    if ($newList.length > 0) {
        let $cookie_value = $newList.join(SEPARATE_SYMBOL);
        UtCookie.setCookie($cookieName, $cookie_value, COOKIE_TIMESTAMP_EXPIRATION);
    }else{
        UtCookie.deleteCookie($cookieName);
    }

}

$('.js-favLink').click(function() {
    let $jobManagementCode = $(this).data('jmc');
    // お気に入りのトグルボタン制御
    toggleFavorite($jobManagementCode, import.meta.env.VITE_APP_NAME);
});
