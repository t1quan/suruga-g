<?php
namespace App\Models\L1\Msg;

use App\Models\FEnt\FEntJobMasters;
use App\Models\FEnt\FEntMasters;
use App\Models\FEnt\FEntJobDetail;

/**
 * Class MsgL1GetJobDetail
 * @package App\Models\L1\Msg
 */
class MsgL1GetJobDetail extends MsgL1Abstract
{
  // input
  /**
   * @var object
   * /api/v1/job/{id} の　API　Requestよりdataを参照する
   */
  public $apiResult;

  /** @var FEntJobMasters  */
  public $masters;

  // output
  /** @var FEntJobDetail  */
  public $fEntJobDetail;

}
