<?php

namespace App\Models\L1;

use App\config\Consts\TenrikuConst;
use App\Core\Logger\Logger;
use App\Models\FEnt\FEntConfig;
use App\Models\FEnt\FEntPage;
use App\Models\L1\Msg\MsgL1CreateFEntPage;
use App\Util\UtilHttpRequest;
use DateTime;
use DateTimeZone;
use ErrorException;
use Illuminate\Http\JsonResponse;

class L1CreateFEntPage extends L1Abstract
{

    /**
     * L1CreateFEntPage constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws ErrorException
     */
    protected function exec(MsgL1CreateFEntPage $msg){

        $unixTime = time();
        $timeZone = new DateTimeZone('Asia/Tokyo');
        $time = new DateTime();
        $time->setTimestamp($unixTime)->setTimezone($timeZone);
        $formattedTime = $time->format('YmdHis');
        $version = env('APP_VERSION', $formattedTime);

        $fEntPage = new FEntPage();
        $fEntPage->noindex = false;
        $fEntPage->version = $version;

        $endpoint = env('API_BASE_URL'). '/corporation';
        $token = UtilHttpRequest::getToken();
        $result = UtilHttpRequest::cUrlRequest(TenrikuConst::$HTTP_METHOD_GET, $endpoint, $token);
        if(!$result){
            Logger::errorTrace('Error API connect to:', [$endpoint]);
            $msg->_c = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
            $msg->_m = '設定情報が取得できませんでした。';
            return;
        }

        $response = json_decode($result, true);
        if($response['code'] != JsonResponse::HTTP_OK){
            $msg->_c = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
            $msg->_m = '設定情報が取得できませんでした。';
            return;
        }

        $configJson = $response['data'];
        $fEntConfig = new FEntConfig();
        $fEntConfig->clientId = $configJson['clientId'];
        $fEntConfig->corporations = $configJson['corporations'];
        $fEntConfig->frontendSettings = $configJson['frontendSettings'];
        $fEntConfig->backendSettings = $configJson['backendSettings'];

        $arrayKeyword = array();
        $corporationInfo = $fEntConfig->corporations[0];
        $arrayKeyword[] = $corporationInfo['corpFullName'] ?? '';
        $keywords = implode(",", $arrayKeyword);
        if(strpos($keywords, ',')) {
            $keywords = preg_replace(",,", ",", $keywords);
        }
        $fEntPage->keywords = $keywords;

        $title = $fEntConfig->frontendSettings['title'] ?? $corporationInfo['title'] ?? '';
        $fEntPage->title = $title . TenrikuConst::$HEADER_CST_MSG;

        $description = $corporationInfo['description'] ?? '';
        $fEntPage->description .= $description . TenrikuConst::$HEADER_CST_MSG;

        $fEntPage->fEntConfig = $fEntConfig;

        $msg->_c = JsonResponse::HTTP_OK;
        $msg->_m = 'ページ情報の生成が完了しました。';
        $msg->fEntPage = $fEntPage;
    }
}