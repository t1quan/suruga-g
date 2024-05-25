<?php

namespace App\Models\L2\Msg;

abstract class MsgL2Abstract
{

    //out
    /** @var boolean 処理結果 */
    public $isSuccess;

    /** @var string 結果コード */
    public $rtnCd;

    /** @var string 結果メッセージ */
    public $rtnMessage;
}
