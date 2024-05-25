<?php

namespace App\Util;

use App\config\Consts\TenrikuConst;
use App\Core\Logger\Logger;
use App\Models\FEnt\FEntCity;
use App\Models\FEnt\FEntZipCode;

use Illuminate\Http\JsonResponse;

class UtilFormSelect
{
    public static function getByZip($code){

        $token = UtilHttpRequest::getToken();
        // endpointの指定
        $endpoint = env('API_BASE_URL') . "/search/address/" . $code;
        //---CURL Request
        $result = UtilHttpRequest::cUrlRequest(TenrikuConst::$HTTP_METHOD_GET, $endpoint, $token);

        if(!$result) {
            return false;
        }

        $ary = json_decode($result);
        if($ary->code != JsonResponse::HTTP_OK) {
            return false;
        }

        $zipCodeData = $ary->data;

        if(!$zipCodeData) {
            return false;
        }

        if(!(($zipCodeData->prefCode??null) && ($zipCodeData->cityCode??null))) {
            return false;
        }

        $fEntZipCode = new FEntZipCode();

        $fEntZipCode->zip = ($zipCodeData->zipCode)??null;
        $fEntZipCode->kenCd = $zipCodeData->prefCode;
        $fEntZipCode->shikuCd = $zipCodeData->cityCode;
        $fEntZipCode->shikuMei = ($zipCodeData->cityName)??null;
        $fEntZipCode->tyouiki = ($zipCodeData->street)??null;

        return $fEntZipCode;
    }

    public static function getByPref($code)
    {

        $cityMaster = null;

        $token = UtilHttpRequest::getToken();
        // endpointの指定
        $endpoint = env('JSON_CACHE_PATH') . '/applyMst.json';
        //---Request
        $result = UtilHttpRequest::request(TenrikuConst::$HTTP_METHOD_GET, $endpoint, $token); //decode済みで返ってくる

        if($result) {
            $cityMaster = $result->city??null;
        }
        //Ajaxを実行出来ている時点でapplyマスタのJSONファイル格納はできているものとし、falseが返ってきた時のAPIリクエストは考慮しない

        if(!$cityMaster) {
            Logger::errorTrace(__METHOD__ . ' Error', 'failed to get CityMaster');
            return false;
        }

        $arrayCity = array();
        foreach($cityMaster As $city) {
            if(!(($city->value??null) && ($city->parent??null))) {
                return false;
            }
            $arrayCity[$city->parent][] = $city;
        }

        $result = array();
        if($arrayCity[$code]??null) {
            foreach($arrayCity[$code] As $prefCode => $children) {
                $fEntCity = new FEntCity();

                $fEntCity->shikuCd = $children->value??null;
                $fEntCity->shikuMei = $children->name??null;

                $result[] = $fEntCity;
            }
        }

        if(!$result || count($result)===0){
            return false;
        }

        return $result;
    }
}
