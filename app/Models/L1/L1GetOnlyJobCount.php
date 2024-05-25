<?php
namespace App\Models\L1;

use App\Core\Logger\Logger;
use App\Models\Constant\Cst;
use App\Models\L1\Msg\MsgL1GetOnlyJobCount;
use App\Models\L2\Msg\MsgL2CreateFEntJobSearchRequestData;
use App\Models\L2\L2CreateFEntJobSearchRequestData;
use App\Util\UtilHttpRequest;
use Illuminate\Http\JsonResponse;

/**
 * Class L1GetOnlyJobCount
 * @package App\Models\L1
 */
class L1GetOnlyJobCount extends L1Abstract
{
    function __construct(){
        parent::__construct();
    }

    /**
     * @param MsgL1GetOnlyJobCount $msg
     * @throws \Exception
     */
    protected function exec(MsgL1GetOnlyJobCount $msg)
    {
        //初期化
        $msg->_c = null;
        $msg->_m = null;
        $msg->totalCnt = null;

        if($msg->fEntJobSearchCriteria === null){
            $msg->_c = Cst::INPUT_ERROR;
            $msg->_m = "検索条件が取得できませんでした";
            return;
        }
        $fEntJobSearchCriteria = $msg->fEntJobSearchCriteria;

        $msgL2CreateFEntJobSearchRequestData = new MsgL2CreateFEntJobSearchRequestData();
        $msgL2CreateFEntJobSearchRequestData->fEntJobSearchCriteria = $fEntJobSearchCriteria;
        $l2CreateFEntJobSearchRequestData = new L2CreateFEntJobSearchRequestData();
        $l2CreateFEntJobSearchRequestData->execute($msgL2CreateFEntJobSearchRequestData);

        if($msgL2CreateFEntJobSearchRequestData->isSuccess === false){
            $msg->_c = $msgL2CreateFEntJobSearchRequestData->rtnCd;
            $msg->_m = $msgL2CreateFEntJobSearchRequestData->rtnMessage;
            return;
        }

        $fEntJobSearchRequestData = $msgL2CreateFEntJobSearchRequestData->fEntJobSearchRequestData;

        $token = UtilHttpRequest::getToken();
        // endpointの指定
        $endpoint = env('API_BASE_URL') . "/search";
        //---CURL Request
        $result = UtilHttpRequest::cUrlRequest("POST", $endpoint, $token, $fEntJobSearchRequestData);

        if(!$result) {
            Logger::errorTrace('Error API connect to:', [$endpoint, $fEntJobSearchRequestData]);
            $msg->_c = Cst::OUTPUT_ERROR;
            $msg->_m = "求人一覧の取得に失敗しました。";
            return;
        }

        $ary = json_decode($result);  // JSONを配列に

        if ($ary->code != JsonResponse::HTTP_OK) {
            Logger::errorTrace('Request Error is L1GetOnlyJobCount.', [$fEntJobSearchRequestData]);
            $msg->_c = Cst::OUTPUT_ERROR;
            $msg->_m = "求人一覧の取得に失敗しました。";
            return;
        }

        $totalCnt = $ary->data->count??null;

        if($totalCnt === null) { //0の場合があるので厳密にnull判定
            $msg->_c = Cst::OUTPUT_ERROR;
            $msg->_m = "求人の該当件数が取得できませんでした。";
            return;
        }

        $msg->totalCnt = $totalCnt;
        $msg->_c = JsonResponse::HTTP_OK;
        $msg->_m = "求人の該当件数は $totalCnt 件でした";

    }

}
