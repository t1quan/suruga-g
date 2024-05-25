<?php

namespace App\Util;

/**
 * Class UtilStringFormat
 * @package App\Util
 */
class UtilStringFormat
{

//文字列の前後から空白を取り除く
    /**
     * @param $inStr
     * @return mixed
     */
    static public function trimStr($inStr)
    {
        return trim($inStr);
    }

//文字列から HTML および PHPタグを取り除く
    /**
     * @param $inStr
     * @return mixed
     */
    static public function stripTags($inStr)
    {
        return strip_tags($inStr);
    }

//改行文字の前に HTMLの改行タグを挿入する

    /**
     * @param $inStr
     * @return mixed
     */
    static public function n2Br($inStr)
    {
        return nl2br($inStr);
    }

//改行文字を置換

    /**
     * @param $inStr
     * @param $replace
     * @return mixed|null
     */
    static public function newlineToStr($inStr, $replace)
    {
        // nullや空文字のときにエラーを出すので先にエスケープする
        if($inStr == null || $inStr == ''){
            return null;
        }

        $str = $inStr;
        $str = mb_ereg_replace("\r\n", $replace, $str);
        $str = mb_ereg_replace("\n", $replace, $str);
        $str = mb_ereg_replace("\r", $replace, $str);

        return $str;
    }

//全角スペースを半角スペースに置換

    /**
     * @param $inStr
     * @return mixed
     */
    static public function fullSpaceToHalfSpace($inStr)
    {
        return mb_ereg_replace("　", " ", $inStr);
    }

//連続する半角スペースを一つの半角スペースに置換

    /**
     * @param $inStr
     * @return mixed
     */
    static public function halfSpaceContinuousToOne($inStr)
    {
        mb_regex_encoding('UTF-8');
        $str = $inStr;
        $pattern = '/\s+/';
        $singleSpace = ' ';
        $str = preg_replace($pattern, $singleSpace, $str);

        return $str;
    }

//半角文字を全角文字に変換(記号も変換する)

    /**
     * @param $inStr
     * @return null
     */
    static public function customConvertKanaKigo($inStr)
    {
        $str = null;
        $str = $inStr;
        $str = self::convKanahankakuMinToZenkaku($str);
        $str = mb_convert_kana($str, "KVRA");
        return $str;
    }

//小さなカタカナ(半角、全角)を大きなカタカナ(全角)に変換

    /**
     * @param $inStr
     * @return mixed
     */
    static public function convKanahankakuMinToZenkaku($inStr)
    {
        $str = null;

        if($inStr){
            $str = $inStr;

            //（全角）小さい文字を大文字に変更
            $replace_of = array('ァ', 'ィ', 'ゥ', 'ェ', 'ォ', 'ャ', 'ュ', 'ョ', 'ッ');
            $replace_by = array('ア', 'イ', 'ウ', 'エ', 'オ', 'ヤ', 'ユ', 'ヨ', 'ツ');
            $str = str_replace($replace_of, $replace_by, $str);

            //（半角）小さい文字を大文字に変更
            $replace_of = array('ｧ', 'ｨ', 'ｩ', 'ｪ', 'ｫ', 'ｬ', 'ｭ', 'ｮ', 'ｯ');
            $replace_by = array('ア', 'イ', 'ウ', 'エ', 'オ', 'ヤ', 'ユ', 'ヨ', 'ツ');
            $str = str_replace($replace_of, $replace_by, $str);
        }
        return $str;
    }

//記号のゆらぎ文字を統一して変更

    /**
     * @param $inStr
     * @return mixed
     */
    static public function convYuragiKigo($inStr)
    {
        $str = null;

        if($inStr){
            $str = $inStr;

            //マイナスに統一
            $str = mb_ereg_replace("-|ー|‐|―|‐", "－", $str);

            //波形に統一
            $str = mb_ereg_replace("〜|~", "～", $str);

            //シングルクォーテーション置換
            $str = mb_ereg_replace("'", "’", $str);

            //ダブルクォーテーション置換
            $str = mb_ereg_replace("\"", "”", $str);

            //バックスラッシュ(\)のエスケープ \\\\で指定する
            $str = mb_ereg_replace("\\\\", "＼", $str);
        }
        return $str;
    }

//文字列のすべてのアルファベットを大文字にする

    /**
     * @param $inStr
     * @return mixed
     */
    static public function convMbStrtoupper($inStr)
    {
        return mb_strtoupper($inStr, 'UTF-8');
    }

}
