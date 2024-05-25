<?php

namespace App\Models\L1\Msg;

use App\Models\FEnt\FEntApplyMasters;
use App\Models\FEnt\FEntJob;
use App\Models\FEnt\FEntConfig;

/**
 * Class MsgL1SaveApply
 * @package App\Models\L1\Msg
 */
class MsgL1SaveApply extends MsgL1Abstract
{
    // in
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
    public $isInsertApplicantData; //oss0001に登録を行うか
    /** @var boolean */
    public $isChangeMailTemplateId; //メールテンプレートIDを切り替えるか
    /** @var integer */
    public $mailObosyaId;
    /** @var integer */
    public $mailTantosyaId;
    /** @var string */
    public $toTantosyaMailAddress; //担当者向けメール送信先アドレス

    // out

    public $obosyaId;

}
