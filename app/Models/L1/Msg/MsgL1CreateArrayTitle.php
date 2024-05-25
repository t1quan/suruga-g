<?php

namespace App\Models\L1\Msg;

use App\Models\FEnt\FEntJobSearchCriteria;
use App\Models\FEnt\FEntJobmasters;
use App\Models\FEnt\FEntSearchAxisData;

/**
 * Class MsgL1CreateArrayTitle
 * @package App\Models\L1\Msg
 */
class MsgL1CreateArrayTitle extends MsgL1Abstract
{
    // in
    /** @var FEntJobSearchCriteria $fEntJobSearchCriteria */
    public $fEntJobSearchCriteria;
    /** @var FEntJobMasters $fEntJobMasters */
    public $fEntJobMasters;
    /** @var FEntSearchAxisData $fEntSearchAxisData */
    public $fEntSearchAxisData;

    // out
    /** @var array */
    public $arrayTitle;

}
