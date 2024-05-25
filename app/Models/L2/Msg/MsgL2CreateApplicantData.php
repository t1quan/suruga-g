<?php

namespace App\Models\L2\Msg;

use App\Models\FEnt\FEntApplyMasters;
use App\Models\FEnt\FEntApplyRequestData;
use App\Models\FEnt\FEntJob;
use App\Models\FEnt\FEntConfig;

/**
 * Class MsgL2CreateBEntApplicantData
 * @package App\Models\l1
 */
class MsgL2CreateApplicantData extends MsgL2Abstract
{

    // input
    /** @var FEntJob $fEntJob */
    public $fEntJob;
    /** @var array */
    public $params;
    /** @var FEntConfig $fEntConfig */
    public $fEntConfig;
    /** @var ?FEntApplyMasters $applyMasters */
    public $applyMasters;
    /** @var string */
    public $jobUri;
    /** @var string */
    public $formPath; //入力フォームのパス
    /** @var boolean */
    public $isLinkJob; //求人に紐づく応募か
    /** @var boolean */
    public $isInsertApplicantData;
    /** @var boolean */
    public $isChangeMailTemplateId;
    /** @var integer */
    public $mailObosyaId;
    /** @var integer */
    public $mailTantosyaId;
    /** @var string */
    public $toTantosyaMailAddress; //担当者向けメール送信先アドレス

    // output
    /**@var FEntApplyRequestData */
    public $fEntApplyRequestData;

}
