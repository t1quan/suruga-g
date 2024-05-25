<?php

namespace App\Models\L1;

use App\Core\Logger\Logger;
use App\Models\Constant\Cst;
use App\Models\L1\Msg\MsgL1SaveApply;
use App\Models\L2\L2CreateApplicantData;
use App\Models\L2\Msg\MsgL2CreateApplicantData;
use App\Util\UtilHttpRequest;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class L1SaveApply
 * @package App\Models\L1
 */
class L1SaveApply extends L1Abstract
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @param MsgL1SaveApply $msg
     * @throws Exception
     */
    protected function exec(MsgL1SaveApply $msg)
    {
        //初期化
        $msg->_c = null;
        $msg->_m = null;

        if(!$msg->params){
            $msg->_c = Cst::INPUT_ERROR;
            $msg->_m = "応募入力の情報を正しく受け取ることができませんでした。";
            return;
        }

        if(!$msg->fEntJob){
            $msg->_c = Cst::INPUT_ERROR;
            $msg->_m = "応募求人の情報を正しく受け取ることができませんでした。";
            return;
        }

        if(!$msg->jobUri){
            $msg->_c = Cst::INPUT_ERROR;
            $msg->_m = "求人掲載URIを正しく受け取ることができませんでした。";
            return;
        }

        // 応募データの生成
        $msgL2CreateApplicantData = new MsgL2CreateApplicantData();
        $msgL2CreateApplicantData->fEntJob = $msg->fEntJob;
        $msgL2CreateApplicantData->params = $msg->params;
        $msgL2CreateApplicantData->fEntConfig = $msg->fEntConfig;
        $msgL2CreateApplicantData->applyMasters = $msg->applyMasters;
        $msgL2CreateApplicantData->jobUri = $msg->jobUri;

        //追加設定のためデフォルト値を設定
        $msgL2CreateApplicantData->formPath = $msg->formPath ?? 'apply';
        $msgL2CreateApplicantData->isLinkJob = $msg->isLinkJob ?? true;
        $msgL2CreateApplicantData->isInsertApplicantData = $msg->isInsertApplicantData ?? true;
        $msgL2CreateApplicantData->isChangeMailTemplateId = $msg->isChangeMailTemplateId ?? false;
        $msgL2CreateApplicantData->mailObosyaId = $msg->mailObosyaId ?? 1;
        $msgL2CreateApplicantData->mailTantosyaId = $msg->mailTantosyaId ?? 2;
        $msgL2CreateApplicantData->toTantosyaMailAddress = $msg->toTantosyaMailAddress ?? '';
        //追加設定ここまで

        $l2CreateApplicantData = new L2CreateApplicantData();
        $l2CreateApplicantData->execute($msgL2CreateApplicantData);
        if(!$msgL2CreateApplicantData->isSuccess){
            $msg->_c = $msgL2CreateApplicantData->rtnCd;
            $msg->_m = $msgL2CreateApplicantData->rtnMessage;
            return;
        }

        $fEntApplyRequestData = $msgL2CreateApplicantData->fEntApplyRequestData;

        $token = UtilHttpRequest::getToken();
        // endpointの指定
        $endpoint = env('API_BASE_URL') . "/apply";
        //---CURL Request
        $result = UtilHttpRequest::cUrlRequest("POST", $endpoint, $token, $fEntApplyRequestData);

        if(!$result) {
            Logger::errorTrace('Error API connect to:', [$endpoint]);
            $msg->_c = Cst::OUTPUT_ERROR;
            $msg->_m = "応募受付が正常に完了しませんでした。";
            return;
        }

        $ary = json_decode($result);  // JSONを配列に

        if ($ary->code != JsonResponse::HTTP_OK) {
            $msg->_c = Cst::OUTPUT_ERROR;
            $msg->_m = "応募受付が正常に完了しませんでした";
            return;
        }

        $id = $ary->data->id??null;

        if(!is_numeric($id)) {
            $msg->_c = Cst::OUTPUT_ERROR;
            $msg->_m = "応募受付は完了しましたが応募者IDが正常に取得できませんでした";
            return;
        }
        $obosyaId = $id;

        $msg->_c = JsonResponse::HTTP_OK;
        $msg->_m = "応募受付が完了しました。";
        $msg->obosyaId = $obosyaId;
    }

}
