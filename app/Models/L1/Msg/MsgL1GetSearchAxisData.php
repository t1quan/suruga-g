<?php
namespace App\Models\L1\Msg;

use App\Models\FEnt\FEntSearchAxisData;

/**
 * Class MsgL1GetSearchAxis
 * @package App\Models\L1\Msg
 */
class MsgL1GetSearchAxisData extends MsgL1Abstract
{
  // input
  /**
   * @var array */
  public $frontendSettings;

  // output
  /** @var FEntSearchAxisData  */
  public $fEntSearchAxisData;

}
