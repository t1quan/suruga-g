<?php

namespace App\Models\L1\Msg;

use App\Models\FEnt\FEntUserApplyInfo;

/**
 * Class MsgL1CreateUserApplyInfo
 * @package App\Models\L1\Msg
 */
class MsgL1CreateUserApplyInfo extends MsgL1Abstract
{
    // in
    public $params;

    // out
    /** @var FEntUserApplyInfo $fEntUserApplyInfo */
    public $fEntUserApplyInfo;

}
