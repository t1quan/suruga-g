<?php

namespace App\Util;

use App\config\Consts\TenrikuConst;
use App\Core\Logger\Logger;
use App\Models\FEnt\FEntJobMasters;
use App\Models\FEnt\FEntApplyMasters;
use App\Models\FEnt\FEntMst;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class UtilKbnMaster
 * @package App\Util
 */
class UtilKbnMaster
{
    /**
     * @throws Exception
     */
    public static function getJobMasters(): FEntJobMasters
    {
        $fEntMasters = new FEntJobMasters();

        //マスタ名称のマッピングリスト
        $arrayMapJobMasterAPIName = array(
            'areaMst' => 'area',
            'prefMst' => 'pref',
            'cityMst' => 'city',
            'jobCategoryGroupMst' => 'jobbc',
            'jobCategoryMst' => 'job',
            'koyKeitaiMst' => 'koy',
            'tokuchoMst' => 'tokucho',
            'salaryKbnMst' => 'kyuyo',
            'stationMst' => 'eki'
        );

        $token = UtilHttpRequest::getToken();
        // endpointの指定
        foreach($fEntMasters As $masterName => $value) {
            if($masterName === 'stationMst') {
                continue; //路線マスタは使用しないためスキップする
            }
            $endpoint = env('JSON_CACHE_PATH') . '/'. $arrayMapJobMasterAPIName[$masterName] . 'Mst.json';
            //---Request
            $result = UtilHttpRequest::request(TenrikuConst::$HTTP_METHOD_GET, $endpoint, $token); //decode済みで返ってくる

            if($result) {
                $fEntMasters->$masterName = $result; //data部分のみがファイル内に記述されていると想定する
            }
            else { //ファイル読み込みに失敗した場合
                Logger::infoTrace('Master cache file is not found. Master API Connect Start: ', [$endpoint]);
                //APIリクエスト
                $endpoint = env('API_BASE_URL') . '/masters/' . $arrayMapJobMasterAPIName[$masterName];
                //---CURL Request
                $result = UtilHttpRequest::cUrlRequest(TenrikuConst::$HTTP_METHOD_GET, $endpoint, $token);

                if(!$result) {
                    Logger::errorTrace('Error Request result at API connect: ', [$endpoint]);
                    $fEntMasters->$masterName = null;
                }

                $ary = json_decode($result);
                if($ary->code == JsonResponse::HTTP_OK) {
                    $masterData = $ary->data;
                    $masterFile = json_encode($masterData, JSON_UNESCAPED_UNICODE);
                    $filePath = env('JSON_CACHE_PATH') . '/'. $arrayMapJobMasterAPIName[$masterName] . 'Mst.json';
                    file_put_contents($filePath, $masterFile, LOCK_EX);
                    $fEntMasters->$masterName = $masterData;
                }
            }
        }

        return $fEntMasters;
    }

    /**
     * @throws Exception
     */
    public static function getApplyMasters(): FEntApplyMasters
    {

        $masterData = null;

        $token = UtilHttpRequest::getToken();
        // endpointの指定
        $endpoint = env('JSON_CACHE_PATH') . '/applyMst.json';
        //---Request
        $result = UtilHttpRequest::request(TenrikuConst::$HTTP_METHOD_GET, $endpoint, $token); //decode済みで返ってくる

        if($result) {
            $masterData = $result; //data部分のみがファイル内に記述されていると想定する
        }
        else { //ファイル読み込みに失敗した場合
            Logger::infoTrace('Master cache file is not found. Master API Connect Start: ', [$endpoint]);
            //APIリクエスト
            $endpoint = env('API_BASE_URL') . '/masters/apply';
            //---CURL Request
            $result = UtilHttpRequest::cUrlRequest(TenrikuConst::$HTTP_METHOD_GET, $endpoint, $token);

            if(!$result) {
                Logger::errorTrace('Error Request result at API connect: ', $endpoint);
                return (new FEntApplyMasters());
            }

            $ary = json_decode($result);
            if($ary->code == JsonResponse::HTTP_OK) {
                $masterData = $ary->data;
                $masterFile = json_encode($masterData, JSON_UNESCAPED_UNICODE);
                $filePath = env('JSON_CACHE_PATH') . '/applyMst.json';
                file_put_contents($filePath, $masterFile, LOCK_EX);
            }
        }

        $arrayMasters = array();

        if($masterData) {
            foreach($masterData As $masterName => $arrayItem) {

                if($arrayItem && count($arrayItem)>0) {

                    switch($masterName) {

                        case('jobbc'):
                            foreach($arrayItem As $index => $list) {
                                if(!(isset($list->name)) || (!isset($list->children))) {
                                    $arrayMasters[$masterName] = null;
                                    break 2;
                                }
                                foreach($list->children As $children) {
                                    if(!(isset($children->name)) || (!isset($children->value))) {
                                        $arrayMasters[$masterName] = null;
                                        break 3;
                                    }
                                    $arrayMasters[$masterName][$list->name][$children->value] = $children->name;
                                }
                            }
                            break;

                        default:
                            foreach($arrayItem As $index => $list) {
                                $fEntMst = new FEntMst();
                                $fEntMst->name = $list->name??null;
                                $fEntMst->value = $list->value??null;
                                if(!(isset($fEntMst->name)) || (!isset($fEntMst->value))) {
                                    $arrayMasters[$masterName] = null;
                                    break 2;
                                }
                                if($list->parent??null) {
                                    $fEntMst->parent = $list->parent;
                                }
                                if($masterName=='city' && (!isset($fEntMst->parent))) {
                                    $arrayMasters[$masterName] = null;
                                    break 2;
                                }
                                $arrayMasters[$masterName][$index] = $fEntMst;
                            }
                            break;
                    }

                }
            }
        }
        else {
            return (new FEntApplyMasters());
        }

        $fEntApplyMasters = new FEntApplyMasters();
        $fEntApplyMasters->prefMst = ($arrayMasters['pref'])??null; //都道府県マスタ
        $fEntApplyMasters->cityMst = ($arrayMasters['city'])??null; //市区町村マスタ
        $fEntApplyMasters->occupationGroupMst = ($arrayMasters['jobbc'])??null; // 職種分類マスタ
        $fEntApplyMasters->koyKeitaiMst = ($arrayMasters['koy'])??null; // 雇用形態マスタ
        $fEntApplyMasters->occupationMst = ($arrayMasters['occupation'])??null; // 現在の職種(就業)マスタ
        $fEntApplyMasters->langMst = ($arrayMasters['lang'])??null; // 言語マスタ
        $fEntApplyMasters->kaiwaLvMst = ($arrayMasters['langConversation'])??null; // 言語会話レベルマスタ
        $fEntApplyMasters->gyomLvMst = ($arrayMasters['langBusiness'])??null; // 言語業務レベルマスタ
        $fEntApplyMasters->eikenRankMst = ($arrayMasters['englishSkillRank'])??null; // 英検等級マスタ
        $fEntApplyMasters->skillRankMst = ($arrayMasters['skillRank'])??null; // スキル等級マスタ
        $fEntApplyMasters->changeCntMst = ($arrayMasters['changeCnt'])??null; // 転職回数マスタ
        $fEntApplyMasters->mngCntMst = ($arrayMasters['management'])??null; // マネジメント回数マスタ
        $fEntApplyMasters->gyokaiMst = ($arrayMasters['industry'])??null; // 業界マスタ
        $fEntApplyMasters->expYearMst = ($arrayMasters['expYear'])??null; // 経験年数マスタ
        $fEntApplyMasters->schoolMst = ($arrayMasters['school'])??null; // 学校区分マスタ
        $fEntApplyMasters->educationMst = ($arrayMasters['education'])??null; //学歴区分マスタ
        $fEntApplyMasters->genderMst = ($arrayMasters['gender'])??null; //性別マスタ
        $fEntApplyMasters->maritalMst = ($arrayMasters['marriage'])??null; // 結婚区分マスタ
        $fEntApplyMasters->yearMst = self::getYearMst(); // 年数リスト
        $fEntApplyMasters->monthMst = self::getMonthMst(); // 月数リスト
        $fEntApplyMasters->dayMst = self::getDayMst(); // 日数リスト

        return $fEntApplyMasters;
    }

    /**
     * @throws Exception
     */
    public static function getYearMst(): array
    {
        $ary = array();

        $now = new \DateTimeImmutable("now", new \DateTimeZone('Asia/Tokyo'));
        $year = (int)$now->format('Y');
        $min = $year - 100; //
        $i = 1;
        while($year >= $min){
            $ary[$year] = $year;
            $modifier = '-'.$i.' year';
            $year = $now->modify($modifier)->format('Y');
            $i++;
        }

        return $ary;
    }

    public static function getMonthMst(): array
    {
        $ary = array();

        for($i=1;$i<=12;$i++){
            $ary[$i] = $i;
        }

        return $ary;
    }

    public static function getDayMst(): array
    {
        $ary = array();

        for($i=1;$i<=31;$i++){
            $ary[$i] = $i;
        }

        return $ary;
    }
}
