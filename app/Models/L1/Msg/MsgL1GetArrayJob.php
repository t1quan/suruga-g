<?php

namespace App\Models\L1\Msg;

use App\Models\FEnt\FEntJob;
use App\Models\FEnt\FEntJobMasters;
use App\Models\FEnt\FEntJobSearchCriteria;

/**
 * Class MsgL1GetArrayJob
 * @package App\Models\L1\Msg
 */
class MsgL1GetArrayJob extends MsgL1Abstract
{
    // in
    /** @var FEntJobSearchCriteria $fEntJobSearchCriteria */
    public $fEntJobSearchCriteria;

    /** @var FEntJobMasters  */
    public $masters;

    // out
    /** @var FEntJob $fEntJob[] */
    public $arrayFEntJob;

    /** @var int */
    public $totalCnt;

}
