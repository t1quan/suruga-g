<?php

namespace App\Models\L1;

use App\Core\Logger\Logger;
use App\Models\Constant\Cst;
use App\Models\FEnt\FEntJobDetail;
use App\Models\FEnt\FEntKinmuti;
use App\Models\FEnt\FEntSelfParam;
use App\Models\FEnt\FEntStation;
use App\Models\FEnt\FEntTokucho;
use App\Models\FEnt\FEntVideo;
use App\Models\L1\Msg\MsgL1GetJobDetail;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class L1GetJobDetail
 * @package App\Models\L1
 */
class L1GetJobDetail extends L1Abstract
{

    /**
     * L1GetJobDetail constructor.
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * @param MsgL1GetJobDetail $msg
     * @throws \Exception
     */
    protected function exec(MsgL1GetJobDetail $msg)
    {
        // 初期化
        $msg->_m = null;
        $msg->_c = null;
        $msg->fEntJobDetail = null;

        $jobDetailApiResult = $msg->apiResult;
        $masters = $msg->masters;

        if(!$jobDetailApiResult) {
            $msg->_c = Cst::OUTPUT_ERROR;
            $msg->_m = 'ご指定の求人が見つかりませんでした。';
            return;
        }

        $arrayMasters = array();

        //マスタデータの整形
        foreach($masters as $masterName => $masterValue) {
            if($masterName === 'areaMst' || $masterName === 'stationMst') {
                continue;
            }
            if($masterValue == null || count($masterValue) === 0) {
                $msg->_c = Cst::OUTPUT_ERROR;
                $msg->_m = 'マスタデータに不備があります。'. 'master_name='.$masterName;
                return;
            }
            if($masterName === 'cityMst') {
                foreach($masterValue as $key => $value) {
                    if(!($value->parent && $value->value)) {
                        $msg->_c = Cst::OUTPUT_ERROR;
                        $msg->_m = 'マスタデータに不備があります。'. 'master_name='.$masterName;
                        return;
                    }
                    $arrayMasters[$masterName][$value->parent . $value->value] = $value->name;
                }
            }
            else {
                foreach($masterValue as $key => $value) {
                    if(!($value->value)) {
                        $msg->_c = Cst::OUTPUT_ERROR;
                        $msg->_m = 'マスタデータに不備があります。'. 'master_name='.$masterName;
                        return;
                    }
                    $arrayMasters[$masterName][$value->value] = $value->name;
                }
            }
        }

        $fEntJobDetail = new FEntJobDetail();

        $fEntJobDetail->jobId = $jobDetailApiResult->jobId;
        $fEntJobDetail->corpCd = $jobDetailApiResult->corpCd;
        $fEntJobDetail->jisyaKoukokuNum = $jobDetailApiResult->jobNo;
        $fEntJobDetail->updatedAt = $jobDetailApiResult->updatedAt;
        $fEntJobDetail->jobTitle = $jobDetailApiResult->jobTitle;
        $fEntJobDetail->corpMei = $jobDetailApiResult->corpName;
        $fEntJobDetail->catchCopy = $jobDetailApiResult->catchCopy;
        $fEntJobDetail->lead = $jobDetailApiResult->information;

        if(($jobDetailApiResult->images[0])??null) {
            $fEntJobDetail->mainGazoFilePath = $jobDetailApiResult->images[0]->url;
            $fEntJobDetail->mainGazoCaption = $jobDetailApiResult->images[0]->caption;
        }
        if(($jobDetailApiResult->images[1])??null) {
            $fEntJobDetail->subGazo1FilePath = $jobDetailApiResult->images[1]->url;
            $fEntJobDetail->subGazo1Caption = $jobDetailApiResult->images[1]->caption;
        }
        if(($jobDetailApiResult->images[2])??null) {
            $fEntJobDetail->subGazo2FilePath = $jobDetailApiResult->images[2]->url;
            $fEntJobDetail->subGazo2Caption = $jobDetailApiResult->images[2]->caption;
        }
        if(($jobDetailApiResult->images[3])??null) {
            $fEntJobDetail->subGazo3FilePath = $jobDetailApiResult->images[3]->url;
            $fEntJobDetail->subGazo3Caption = $jobDetailApiResult->images[3]->caption;
        }

        $fEntJobDetail->jobCategoryCode = $jobDetailApiResult->jobCategoryCode;

        $fEntJobDetail->jobCategoryName = $arrayMasters['jobCategoryMst'][$fEntJobDetail->jobCategoryCode]??null;  //職種名取得

        $fEntJobDetail->jobCategoryGroupCode = $jobDetailApiResult->jobCategoryGroupCode;
        $fEntJobDetail->jobCategoryGroupName = $arrayMasters['jobCategoryGroupMst'][$fEntJobDetail->jobCategoryGroupCode]??null;  //職種分類名取得

        $fEntJobDetail->koyKeitaiCode = $jobDetailApiResult->koyKeitaiCd;
        $fEntJobDetail->koyKeitaiName = $arrayMasters['koyKeitaiMst'][$fEntJobDetail->koyKeitaiCode]??null;  //雇用形態名取得

        $fEntJobDetail->koyKeitaiBiko = $jobDetailApiResult->koyKeitaiBiko;
        $fEntJobDetail->bosyuHaikei = $jobDetailApiResult->bosyuHaikei;
        $fEntJobDetail->jobNaiyo = $jobDetailApiResult->jobNaiyo;
        $fEntJobDetail->daigomi = $jobDetailApiResult->daigomi;
        $fEntJobDetail->kibishisa = $jobDetailApiResult->kibishisa;
        $fEntJobDetail->ouboSikaku = $jobDetailApiResult->ouboSikaku;
        $fEntJobDetail->katuyaku = $jobDetailApiResult->katuyaku;
        $fEntJobDetail->workingTimes = $jobDetailApiResult->workingTimes;
        $fEntJobDetail->kyuyoKbnCode = $jobDetailApiResult->salaryClassCode;
        $fEntJobDetail->kyuyoKbnName = $arrayMasters['salaryKbnMst'][$fEntJobDetail->kyuyoKbnCode]??null;  //給与区分取得

        $fEntJobDetail->kyuyoMin = $jobDetailApiResult->salaryMin;
        $fEntJobDetail->kyuyoMax = $jobDetailApiResult->salaryMax;
        $fEntJobDetail->kyuyoBiko = $jobDetailApiResult->salaryRemarks;
        $fEntJobDetail->salary = $jobDetailApiResult->monthlySalary;
        $fEntJobDetail->annualSalary = $jobDetailApiResult->annualSalary;
        $fEntJobDetail->taiguFukurikosei = $jobDetailApiResult->taiguFukurikosei;
        $fEntJobDetail->holiday = $jobDetailApiResult->holiday;
        $fEntJobDetail->appealPoint = $jobDetailApiResult->appealPoint;
        $fEntJobDetail->senkoTejun = $jobDetailApiResult->senkoTejun;
        $fEntJobDetail->mensetsuAddr = $jobDetailApiResult->mensetsuAddr;
        $fEntJobDetail->biko = $jobDetailApiResult->remarks;

        $arrayTokucho = array();
        if($jobDetailApiResult->tokucho??null){
            foreach($jobDetailApiResult->tokucho as $tokuchoData){
                $fEntTokucho = new FEntTokucho();
                $fEntTokucho->tokuchoCode = $tokuchoData;
                $fEntTokucho->tokuchoName = $arrayMasters['tokuchoMst'][$fEntTokucho->tokuchoCode]??null;  //特徴名取得

                if(json_encode($fEntTokucho) != json_encode(new FEntTokucho())){
                    $arrayTokucho[] = $fEntTokucho;
                }
            }
        }

        if(count($arrayTokucho)>0) {
            $idx = array_column($arrayTokucho, 'tokuchoCode');
            array_multisort($idx, SORT_ASC, $arrayTokucho); //特徴コードの昇順にソート
        }
        $fEntJobDetail->arrayFEntTokucho = $arrayTokucho;

        $arrayFEntKinmuti = array();
        if($jobDetailApiResult->kinmuti??null){
            foreach($jobDetailApiResult->kinmuti as $kinmutiData){
                $fEntKinmuti = new FEntKinmuti();
                $fEntKinmuti->renban = $kinmutiData->num;
                $fEntKinmuti->kinmutiName = $kinmutiData->kinmutiName;
                $fEntKinmuti->prefCode = $kinmutiData->prefCode;
                $fEntKinmuti->cityCode = $kinmutiData->cityCode;
                $fEntKinmuti->prefName = $arrayMasters['prefMst'][$fEntKinmuti->prefCode]??null;  //都道府県名取得
                $fEntKinmuti->cityName = $arrayMasters['cityMst'][$fEntKinmuti->prefCode.$fEntKinmuti->cityCode]??null;  //市区町村名取得

                $fEntKinmuti->kinmutiAddress = $kinmutiData->kinmutiAddress;
                $fEntKinmuti->kotu = $kinmutiData->kotu;
                if($kinmutiData->stations){
                    $arrayStation = array();
                    $i = 0;
                    foreach($kinmutiData->stations as $stationData){
                        $fEntStation = new FEntStation();
                        if($i < 2){  //表示する最寄り駅詳細は最大2駅
                            $fEntStation->prefCode = $stationData->prefCode;
                            $fEntStation->prefName = $stationData->prefName;
                            $fEntStation->lineCode = $stationData->lineCode;
                            $fEntStation->lineName = $stationData->lineName;
                            $fEntStation->stationCode = $stationData->stationCode;
                            $fEntStation->stationName = $stationData->stationName;
                            $arrayStation[] = $fEntStation;
                        }else{
                            $fEntStation->lineCode = 99;
                            $fEntStation->lineName = 'その他';
                            $arrayStation[] = $fEntStation;
                            break;
                        }
                        $i++;
                    }
                    $fEntKinmuti->arrayFEntStation = $arrayStation;
                }
                if(json_encode($fEntKinmuti) != json_encode(new FEntKinmuti())){
                    $arrayFEntKinmuti[] = $fEntKinmuti;
                }
            }
        }
        if(count($arrayFEntKinmuti)>0) {
            $idx = array_column($arrayFEntKinmuti, 'renban');
            array_multisort($idx, SORT_ASC, $arrayFEntKinmuti); //勤務地連番の昇順にソート
        }
        $fEntJobDetail->arrayFEntKinmuti = $arrayFEntKinmuti;

        $arrayFEntSelfParam = array();
        if(is_array($jobDetailApiResult->selfParams??null)){
            foreach($jobDetailApiResult->selfParams as $selfParamData){
                $fEntSelfParam = new FEntSelfParam();
                $fEntSelfParam->selfParamCode = $selfParamData->selfParamCode;
                $fEntSelfParam->percentCode = $selfParamData->percentCode;
                $fEntSelfParam->selfParamName = "パラメータ項目".$selfParamData->selfParamCode;
                if(json_encode($fEntSelfParam) != json_encode(new FEntSelfParam())){
                    $arrayFEntSelfParam[] = $fEntSelfParam;
                }
            }
        }
        $fEntJobDetail->arrayFEntSelfParam = $arrayFEntSelfParam;


        $fEntVideo = null;
        if($jobDetailApiResult->video??null){
            $fEntVideo = new FEntVideo();
            $fEntVideo->videoId = $jobDetailApiResult->video->videoId;
            $fEntVideo->thumbnailUrl = $jobDetailApiResult->video->thumbnailUrl;
            $fEntVideo->embedIframe = $jobDetailApiResult->video->embedIframe;
            $fEntVideo->videoCaption = $jobDetailApiResult->video->videoCaption;
        }
        $fEntJobDetail->fEntVideo = $fEntVideo;

        $fEntJobDetail->corpLogoGazoDataFilePath = $jobDetailApiResult->corpLogoGazoDataFilePath ?? null;
        $fEntJobDetail->tenichiSiteUrl = $jobDetailApiResult->tenichiSiteUrl ?? '';

        $msg->_c = Response::HTTP_OK;
        $msg->_m = '求人情報の一覧を取得しました。';
        $msg->fEntJobDetail = $fEntJobDetail;
    }
}
