<?php
namespace App\Models\L1;

use App\Core\Logger\Logger;
use App\Models\Constant\Cst;
use App\Models\FEnt\FEntJob;
use App\Models\FEnt\FEntKinmuti;
use App\Models\L1\Msg\MsgL1GetArrayJob;
use App\Models\L2\Msg\MsgL2CreateFEntJobSearchRequestData;
use App\Models\L2\L2CreateFEntJobSearchRequestData;
use App\Util\UtilHttpRequest;
use Illuminate\Http\JsonResponse;

/**
 * Class L1GetArrayJob
 * @package App\Models\L1
 */
class L1GetArrayJob extends L1Abstract
{
    function __construct(){
        parent::__construct();
    }

    /**
     * @param MsgL1GetArrayJob $msg
     * @throws \Exception
     */
    protected function exec(MsgL1GetArrayJob $msg)
    {
        //初期化
        $msg->_c = null;
        $msg->_m = null;
        $msg->arrayFEntJob = array();
        $msg->totalCnt = null;
        $masters = $msg->masters;

        if($msg->fEntJobSearchCriteria === null){
            $msg->_c = Cst::INPUT_ERROR;
            $msg->_m = "検索条件が取得できませんでした";
            return;
        }
        $fEntJobSearchCriteria = $msg->fEntJobSearchCriteria;

        $arrayMaster = array();

        //マスタデータの整形
        foreach($masters as $masterName => $arrayMasterObject) {
            if($masterName === 'areaMst' || $masterName === 'stationMst') {
                continue;
            }
            if($arrayMasterObject == null || count($arrayMasterObject) === 0) {
                $msg->_c = Cst::OUTPUT_ERROR;
                $msg->_m = 'マスタデータに不備があります。'. 'master_name='.$masterName;
                return;
            }
            if($masterName === 'cityMst') {
                foreach($arrayMasterObject as $index => $items) {
                    if(!($items->parent && $items->value)) {
                        $msg->_c = Cst::OUTPUT_ERROR;
                        $msg->_m = 'マスタデータに不備があります。'. 'master_name='.$masterName;
                        return;
                    }
                    $arrayMaster[$masterName][$items->parent . $items->value] = $items->name;
                }
            }
            else {
                foreach($arrayMasterObject as $index => $items) {
                    if(!($items->value)) {
                        $msg->_c = Cst::OUTPUT_ERROR;
                        $msg->_m = 'マスタデータに不備があります。'. 'master_name='.$masterName;
                        return;
                    }
                    $arrayMaster[$masterName][$items->value] = $items->name;
                }
            }
        }

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
            Logger::errorTrace('Request Error is L1GetArrayJob.', [$fEntJobSearchRequestData]);
            $msg->_c = Cst::OUTPUT_ERROR;
            $msg->_m = "求人一覧の取得に失敗しました。";
            return;
        }

        $totalCnt = $ary->data->count??null;

        if($totalCnt === null) { //0の場合があるので厳密にnull判定
            $msg->_c = Cst::OUTPUT_ERROR;
            $msg->_m = "求人一覧の該当件数が取得できませんでした。";
            return;
        }

        $arraySearchResult = $ary->data->list??null;

        $arrayFEntJob = array();
        if (is_array($arraySearchResult)) {
            foreach ($arraySearchResult as $searchResult) {
                $fEntJob = new FEntJob();
                $fEntJob->jobId = $searchResult->jobId;
                $fEntJob->jisyaKoukokuNum = $searchResult->jobNo;
                $fEntJob->updatedAt = $searchResult->updatedAt;
                $fEntJob->corpCd = $searchResult->corpCd;
                $fEntJob->corpMei = $searchResult->corpName;
                $fEntJob->jobTitle = $searchResult->jobTitle;
                $fEntJob->mainGazoFilePath = $searchResult->mainGazoFilePath;
                $fEntJob->mainGazoCaption = $searchResult->mainGazoCaption;
                $fEntJob->catchCopy = $searchResult->catchCopy;
                $fEntJob->workingTimes = $searchResult->workingTimes;
                $fEntJob->jobCategoryCode = $searchResult->jobCategoryCode;
                $fEntJob->jobCategoryName = $arrayMaster['jobCategoryMst'][$fEntJob->jobCategoryCode]??null;  //職種名取得
                $fEntJob->jobCategoryGroupCode = $searchResult->jobCategoryGroupCode;
                $fEntJob->jobCategoryGroupName = $arrayMaster['jobCategoryGroupMst'][$fEntJob->jobCategoryGroupCode]??null;  //職種分類名取得
                $fEntJob->koyKeitaiCode = $searchResult->koyKeitaiCd;
                $fEntJob->koyKeitaiName = $arrayMaster['koyKeitaiMst'][$fEntJob->koyKeitaiCode]??null;  //雇用形態名取得
                $fEntJob->koyKeitaiBiko = $searchResult->koyKeitaiBiko;
                $fEntJob->jobNaiyo = $searchResult->jobNaiyo;
                $fEntJob->kyuyoKbnCode = $searchResult->salaryClassCode;
                $fEntJob->kyuyoKbnName = $arrayMaster['salaryKbnMst'][$fEntJob->kyuyoKbnCode]??null;  //給与区分取得
                $fEntJob->kyuyoMin = $searchResult->salaryMin;
                $fEntJob->kyuyoMax = $searchResult->salaryMax;
                $fEntJob->biko = $searchResult->remarks;

                $arrayFEntKinmuti = array();
                if($searchResult->kinmuti??null){
                    foreach($searchResult->kinmuti as $kinmutiData){
                        $fEntKinmuti = new FEntKinmuti();
                        $fEntKinmuti->renban = $kinmutiData->num;
                        $fEntKinmuti->kinmutiName = $kinmutiData->kinmutiName;
                        $fEntKinmuti->prefCode = $kinmutiData->prefCode;
                        $fEntKinmuti->cityCode = $kinmutiData->cityCode;
                        $fEntKinmuti->prefName = $arrayMaster['prefMst'][$fEntKinmuti->prefCode]??null;  //都道府県名取得
                        $fEntKinmuti->cityName = $arrayMaster['cityMst'][$fEntKinmuti->prefCode.$fEntKinmuti->cityCode]??null;  //市区町村名取得

                        if(json_encode($fEntKinmuti) != json_encode(new FEntKinmuti())){
                            $arrayFEntKinmuti[] = $fEntKinmuti;
                        }

                        if(count($arrayFEntKinmuti)>0) {
                            $idx = array_column($arrayFEntKinmuti, 'renban');
                            array_multisort($idx, SORT_ASC, $arrayFEntKinmuti); //勤務地連番の昇順にソート
                        }
                        $fEntJob->arrayFEntKinmuti = $arrayFEntKinmuti;
                    }
                }

                $arrayFEntJob[] = $fEntJob;
            }
        }

        $msg->arrayFEntJob = $arrayFEntJob;
        $msg->totalCnt = $totalCnt;
        $msg->_c = JsonResponse::HTTP_OK;
        $msg->_m = "求人 $totalCnt 件取得しました";

    }

}
