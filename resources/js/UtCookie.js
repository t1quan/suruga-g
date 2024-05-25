
// Cookieの制御

// Cookieから対象の値を取得する
function getCookie(name) {
    let result = null;

    let cookieName = name + '=';
    let cookies = document.cookie;

    // 指定したCookie名の開始位置を取得
    let position = cookies.indexOf(cookieName);

    if(position !== -1){
        let startIndex = position + cookieName.length;

        let endIndex = cookies.indexOf(';', startIndex);
        if(endIndex === -1){
            endIndex = cookies.length;
        }

        result = decodeURIComponent(cookies.substring(startIndex, endIndex));
    }

    return result;
}

// Cookieに対象の値を設定する
function setCookie(name, value, month) {
    let date = new Date();
    date.setMonth(date.getMonth() + month);
    if(name !== '' && name !== null && name !== undefined){
        document.cookie = name + '=' + encodeURIComponent(value) + ';expires=' + date.toUTCString() + ';domain=' + location.hostname + ';path=/';
    }
}

// Cookieから対象の値を削除する
function deleteCookie(name) {
    if(name !== '' && name !== null && name !== undefined){
        let date = new Date();
        date.setTime(0);
        document.cookie = name + '=;expires=' + date.toUTCString() + ';domain=' + location.hostname + ';path=/';
    }
}

// Cookieから対象の値のタイムスタンプを更新する
function setCookieTimestamp(name) {
    let date = new Date();
    // Nヶ月後までの有効期限を設定
    let timestamp = '';
    timestamp += date.getFullYear().toString();
    timestamp += '/';
    timestamp += (date.getMonth() + 1) > 9 ? (date.getMonth() + 1).toString() : '0' + (date.getMonth() + 1).toString();
    timestamp += '/';
    timestamp += date.getDate() > 9 ? date.getDate() : '0' + date.getDate().toString();
    timestamp += ' ';
    timestamp += date.getTime() > 9 ? date.getHours().toString() : '0' + date.getHours().toString();
    timestamp += ':';
    timestamp += date.getMinutes() > 9 ? date.getMinutes().toString() : '0' + date.getMinutes().toString();
    timestamp += ':';
    timestamp += date.getSeconds() > 9 ? date.getSeconds().toString() : '0' + date.getSeconds().toString();
    setCookie(name, timestamp, 6);
}

export default {getCookie, setCookie, deleteCookie, setCookieTimestamp};
