<?php

namespace App\Models\L1\Msg;

use App\Models\FEnt\FEntJobSearchCriteria;

/**
 * Class MsgL1GetOnlyJobCount
 * @package App\Models\L1\Msg
 */
class MsgL1GetOnlyJobCount extends MsgL1Abstract
{
    // in
    /** @var FEntJobSearchCriteria $fEntJobSearchCriteria */
    public $fEntJobSearchCriteria;

    // out
    /** @var int */
    public $totalCnt;

}
