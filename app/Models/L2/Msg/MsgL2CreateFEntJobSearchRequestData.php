<?php
namespace App\Models\L2\Msg;

use App\Models\FEnt\FEntJobSearchCriteria;
use App\Models\FEnt\FEntJobSearchRequestData;

/**
 * Class MsgL2CreateFEntJobSearchRequestData
 * @package App\Models\L2
 */
class MsgL2CreateFEntJobSearchRequestData extends MsgL2Abstract
{

  // input
  /** @var FEntJobSearchCriteria  $fEntJobSearchCriteria */
  public $fEntJobSearchCriteria;

  // output
  /** @var FEntJobSearchRequestData $fEntJobSearchRequestData */
  public $fEntJobSearchRequestData;
}
