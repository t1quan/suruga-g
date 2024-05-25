<?php

namespace App\Models\L2;

use App\config\Consts\TenrikuConst;
use App\Models\Constant\Cst;
use App\Models\FEnt\FEntJobSearchRequestData;
use App\Models\L2\Msg\MsgL2CreateFEntJobSearchRequestData;
use Illuminate\Http\JsonResponse;

/**
 * Class L2CreateFEntJobSearchRequestData
 * @package App\Models\L2
 */
class L2CreateFEntJobSearchRequestData extends L2Abstract
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param MsgL2CreateFEntJobSearchRequestData $msg
     * @throws \Exception
     */
    protected function exec(MsgL2CreateFEntJobSearchRequestData $msg)
    {

        if($msg->fEntJobSearchCriteria === null){
            $msg->isSuccess = false;
            $msg->rtnCd = Cst::INPUT_ERROR;
            $msg->rtnMessage = "検索条件が取得できませんでした";
            return;
        }

        $fEntJobSearchCriteria = $msg->fEntJobSearchCriteria;

        $delimiter = '[]';
        $fEntJobSearchRequestData = new FEntJobSearchRequestData();

        //jobIds
        if($fEntJobSearchCriteria->jobIds !== null && $fEntJobSearchCriteria->jobIds !== ''){
            $arrayJobId = explode($delimiter, $fEntJobSearchCriteria->jobIds);
            foreach($arrayJobId As $jobId) {
                if(is_numeric($jobId)) {
                    $fEntJobSearchRequestData->jobIds[] = (int)$jobId; //int型に変換
                }
            }
        }

        //exceptJobIds
        if($fEntJobSearchCriteria->exceptJobIds !== null && $fEntJobSearchCriteria->exceptJobIds !== ''){
            $arrayExceptJobId = explode($delimiter, $fEntJobSearchCriteria->exceptJobIds);
            foreach($arrayExceptJobId As $exceptJobId) {
                if(is_numeric($exceptJobId)) {
                    $fEntJobSearchRequestData->exceptJobIds[] = (int)$exceptJobId; //int型に変換
                }
            }
        }

        //jobNos
        if($fEntJobSearchCriteria->jobNos !== null && $fEntJobSearchCriteria->jobNos !== ''){
            $fEntJobSearchRequestData->jobNos = explode($delimiter, $fEntJobSearchCriteria->jobNos);
        }

        //isMatchFullJobNo
        if($fEntJobSearchCriteria->isMatchFullJobNo !== null && $fEntJobSearchCriteria->isMatchFullJobNo !== ''){
            $fEntJobSearchRequestData->isMatchFullJobNo = $fEntJobSearchCriteria->isMatchFullJobNo;
        }

        //isAndSearchFeature
        if($fEntJobSearchCriteria->isAndSearchFeature !== null && $fEntJobSearchCriteria->isAndSearchFeature !== ''){
            $fEntJobSearchRequestData->isAndSearchFeature = $fEntJobSearchCriteria->isAndSearchFeature;
        }

        //isAndSearchKeyword
        if($fEntJobSearchCriteria->isAndSearchKeyword !== null && $fEntJobSearchCriteria->isAndSearchKeyword !== ''){
            $fEntJobSearchRequestData->isAndSearchKeyword = $fEntJobSearchCriteria->isAndSearchKeyword;
        }

        //isAndSearchBiko
        if($fEntJobSearchCriteria->isAndSearchBiko !== null && $fEntJobSearchCriteria->isAndSearchBiko !== ''){
            $fEntJobSearchRequestData->isAndSearchBiko = $fEntJobSearchCriteria->isAndSearchBiko;
        }

        //area
        if($fEntJobSearchCriteria->areaCodes !== null && $fEntJobSearchCriteria->areaCodes !== ''){
            $arrayArea = explode($delimiter, $fEntJobSearchCriteria->areaCodes);
            foreach($arrayArea As $area) {
                if(is_numeric($area)) {
                    $fEntJobSearchRequestData->area[] = (int)$area; //int型に変換
                }
            }
        }

        //pref
        if($fEntJobSearchCriteria->prefCodes !== null && $fEntJobSearchCriteria->prefCodes !== ''){
            $arrayPref = explode($delimiter, $fEntJobSearchCriteria->prefCodes);
            foreach($arrayPref As $pref) {
                if(is_numeric($pref)) {
                    $fEntJobSearchRequestData->pref[] = (int)$pref; //int型に変換
                }
            }
        }

        //city 都道府県コード+市区町村コードの形そのままで渡す
        if($fEntJobSearchCriteria->cityCodes !== null && $fEntJobSearchCriteria->cityCodes !== ''){
            $arrayCity = explode($delimiter, $fEntJobSearchCriteria->cityCodes);
            foreach($arrayCity As $city) {
                if(is_numeric($city)) {
                    $fEntJobSearchRequestData->city[] = (int)$city; //int型に変換
                }
            }
        }

        //jobbc
        if($fEntJobSearchCriteria->jobGroupCodes !== null && $fEntJobSearchCriteria->jobGroupCodes !== ''){
            $arrayJobbc = explode($delimiter, $fEntJobSearchCriteria->jobGroupCodes);
            foreach($arrayJobbc As $jobbc) {
                if(is_numeric($jobbc)) {
                    $fEntJobSearchRequestData->jobbc[] = (int)$jobbc; //int型に変換
                }
            }
        }

        //job
        if($fEntJobSearchCriteria->jobCodes !== null && $fEntJobSearchCriteria->jobCodes !== ''){
            $arrayJob = explode($delimiter, $fEntJobSearchCriteria->jobCodes);
            foreach($arrayJob As $job) {
                if(is_numeric($job)) {
                    $fEntJobSearchRequestData->job[] = (int)$job; //int型に変換
                }
            }
        }

        //koy
        if($fEntJobSearchCriteria->koyKeitaiCodes !== null && $fEntJobSearchCriteria->koyKeitaiCodes !== ''){
            $arrayKoy = explode($delimiter, $fEntJobSearchCriteria->koyKeitaiCodes);
            foreach($arrayKoy As $koy) {
                if(is_numeric($koy)) {
                    $fEntJobSearchRequestData->koy[] = (int)$koy; //int型に変換
                }
            }
        }

        //tokucho
        if($fEntJobSearchCriteria->tokuchoCodes !== null && $fEntJobSearchCriteria->tokuchoCodes !== ''){
            $arrayTokucho = explode($delimiter, $fEntJobSearchCriteria->tokuchoCodes);
            foreach($arrayTokucho As $tokucho) {
                if(is_numeric($tokucho)) {
                    $fEntJobSearchRequestData->tokucho[] = (int)$tokucho; //int型に変換
                }
            }
            //AND検索の場合、同一コードが存在すると検索結果0件になるので重複排除
            if($fEntJobSearchCriteria->isAndSearchFeature == true) {
                $arrayAndTokucho =  array_unique($fEntJobSearchRequestData->tokucho); //重複排除
                $fEntJobSearchRequestData->tokucho = array_values($arrayAndTokucho); //キーが飛ばされる場合があるので0から振り直し
            }
        }

        //eki 親コード:子コードの形そのままで渡す
        if($fEntJobSearchCriteria->rosenCodes !== null && $fEntJobSearchCriteria->rosenCodes !== ''){
            $fEntJobSearchRequestData->eki = explode($delimiter, $fEntJobSearchCriteria->rosenCodes);
        }

        //salaryClassCode
        if($fEntJobSearchCriteria->salaryCode !== null && $fEntJobSearchCriteria->salaryCode !== ''){
            $fEntJobSearchRequestData->salaryClassCode = (int)$fEntJobSearchCriteria->salaryCode;
        }

        //salaryMin
        if($fEntJobSearchCriteria->salaryMin !== null && $fEntJobSearchCriteria->salaryMin !== ''){
            $fEntJobSearchRequestData->salaryMin = (int)$fEntJobSearchCriteria->salaryMin;
        }

        //salaryMax
        if($fEntJobSearchCriteria->salaryMax !== null && $fEntJobSearchCriteria->salaryMax !== ''){
            $fEntJobSearchRequestData->salaryMax = (int)$fEntJobSearchCriteria->salaryMax;
        }

        //kw
        if($fEntJobSearchCriteria->keyword !== null && $fEntJobSearchCriteria->keyword !== ''){
            $fEntJobSearchRequestData->kw = explode(' ', $fEntJobSearchCriteria->keyword); //キーワード・備考は区切り文字を半角スペースとして配列に格納
        }

        //biko
        if($fEntJobSearchCriteria->biko !== null && $fEntJobSearchCriteria->biko !== ''){
            $fEntJobSearchRequestData->biko = explode(' ', $fEntJobSearchCriteria->biko); //キーワード・備考は区切り文字を半角スペースとして配列に格納
        }

        //searchType
        if($fEntJobSearchCriteria->searchType !== null && $fEntJobSearchCriteria->searchType !== ''){
            $fEntJobSearchRequestData->searchType = (int)$fEntJobSearchCriteria->searchType;
        }

        //corp
        if($fEntJobSearchCriteria->corpCode !== null && $fEntJobSearchCriteria->corpCode !== ''){
            $arrayCorp = explode($delimiter, $fEntJobSearchCriteria->corpCode);
            foreach($arrayCorp As $corp) {
                if(is_numeric($corp)) {
                    $fEntJobSearchRequestData->corp[] = (int)$corp;
                }
            }
        }

        //video
        if($fEntJobSearchCriteria->isSetVideo !== null && $fEntJobSearchCriteria->isSetVideo !== ''){
            $fEntJobSearchRequestData->video = $fEntJobSearchCriteria->isSetVideo;
        }

        //image
        if($fEntJobSearchCriteria->isSetImage !== null && $fEntJobSearchCriteria->isSetImage !== ''){
            $fEntJobSearchRequestData->image = $fEntJobSearchCriteria->isSetImage;
        }

        //termFrom
        if($fEntJobSearchCriteria->termFrom !== null && $fEntJobSearchCriteria->termFrom !== ''){
            $fEntJobSearchRequestData->termFrom = $fEntJobSearchCriteria->termFrom;
        }

        //termTo
        if($fEntJobSearchCriteria->termTo !== null && $fEntJobSearchCriteria->termTo !== ''){
            $fEntJobSearchRequestData->termTo = $fEntJobSearchCriteria->termTo;
        }

        //pageLimit
        if($fEntJobSearchCriteria->pageLimit !== null && $fEntJobSearchCriteria->pageLimit > 0){
            $fEntJobSearchRequestData->pageLimit = (int)$fEntJobSearchCriteria->pageLimit;
        }

        //pageNo
        if($fEntJobSearchCriteria->pageNo !== null && $fEntJobSearchCriteria->pageNo > 0){
            $fEntJobSearchRequestData->pageNo = (int)$fEntJobSearchCriteria->pageNo;
        }

        //sort 条件指定があった場合、渡されてきた条件をそのままAPIリクエスト用データとして使用する
        if($fEntJobSearchCriteria->sort !== null && $fEntJobSearchCriteria->sort > 0){
            $fEntJobSearchRequestData->sort = $fEntJobSearchCriteria->sort;
        }

        $intParamList = array(
            'jobIds',
            'exceptJobIds',
            'area',
            'pref',
            'city',
            'jobbc',
            'job',
            'koy',
            'tokucho',
            'salaryClassCode',
            'salaryMin',
            'salaryMax',
            'searchType',
            'corp',
            'pageLimit',
            'pageNo',
        );

        foreach($intParamList As $key) {
            if($fEntJobSearchRequestData->$key) {
                $targetParam = $fEntJobSearchRequestData->$key;

                if(!is_array($targetParam)) {
                    $targetParam = array($targetParam); //foreachで共通処理するために一度配列に格納する
                }

                foreach($targetParam As $param) {
                    if($param > TenrikuConst::INTEGER_MAX) {
                        $msg->isSuccess = false;
                        $msg->rtnCd = JsonResponse::HTTP_FORBIDDEN;
                        $msg->rtnMessage = $key. "の検索パラメータの値がint型の数値範囲を超えています";
                        return;
                    }
                }
            }
        }

        $msg->isSuccess = true;
        $msg->fEntJobSearchRequestData = $fEntJobSearchRequestData;

    }

}
