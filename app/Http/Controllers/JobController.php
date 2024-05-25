<?php

namespace App\Http\Controllers;

use App\config\Consts\TenrikuConst;
use App\Core\Logger\Logger;
use App\Models\FEnt\FEntJobMasters;
use App\Models\FEnt\FEntPage;
use App\Models\L1\L1CreateFEntPage;
use App\Models\L1\Msg\MsgL1CreateFEntPage;
use App\Models\L1\L1GetJobDetail;
use App\Models\L1\Msg\MsgL1GetJobDetail;
use App\Util\UtilFavorite;
use App\Util\UtilHttpRequest;
use App\Util\UtilKbnMaster;
use ErrorException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class JobController extends Controller
{

    /** @var FEntPage */
    private $page;
    /** @var array */
    private $favoriteList;
    /** @var FEntJobMasters */
    private $masters;

    /**
     * TopController constructor.
     * @throws ErrorException|Exception
     */
    public function __construct()
    {

        $msgL1CreateFEntPage = new MsgL1CreateFEntPage();
        $l1CreateFEntPage = new L1CreateFEntPage();
        $l1CreateFEntPage->execute($msgL1CreateFEntPage);
        if($msgL1CreateFEntPage->_c != JsonResponse::HTTP_OK){
            App::abort(503);
        }
        $fEntPage = $msgL1CreateFEntPage->fEntPage;
        $this->page = $fEntPage;
        $this->favoriteList = UtilFavorite::getFavoriteList();
        $this->masters = UtilKbnMaster::getJobMasters();
        $arrayCorpCd = $fEntPage->fEntConfig->frontendSettings['arrayCorpCd']??null;
        $this->page->favoriteJobCnt = UtilFavorite::getFavoriteJobCount($arrayCorpCd, $this->favoriteList);

    }

    /**
     * @throws Exception
     */
    public function show($id){
        Logger::infoTrace( __METHOD__ . ' - start --- ', $id);

        $page = $this->page;
        $page->id = 'job';
        $page->class = 'job';
        $favoriteList = $this->favoriteList;

        //Routerで型判定とNot null判定は済んでいるため、int最大値の判定処理のみ行う
        if($id > TenrikuConst::INTEGER_MAX) {
            App::abort(404);
        }

        $token = UtilHttpRequest::getToken();
        // endpointの指定
        $endpoint = env('API_BASE_URL') . "/job/" . $id;
        //---CURL Request
        $result = UtilHttpRequest::cUrlRequest("GET", $endpoint, $token);

        if(!$result) {
            Logger::errorTrace('Error API connect to:', [$endpoint]);
            return view('pages.job', compact('page'));
        }

        $ary = json_decode($result);  // JSONを配列に

        //404 or 403で返ってきた場合
        if ($ary->code == JsonResponse::HTTP_NOT_FOUND || $ary->code == JsonResponse::HTTP_FORBIDDEN) {
            Logger::errorTrace('Request job is not found.', $id);
            return view('pages.job', compact('page')); //該当求人ヒットせず
        }

        if ($ary->code != JsonResponse::HTTP_OK) {
            Logger::errorTrace('Request Error is GetJobDetail.', $id);
            return view('pages.maintenance', compact('page')); //エラー表示
        }

        $jobDetailData = $ary->data;

        $jobMasters = new FEntJobMasters();
        $arrayMasters = $this->masters;

        foreach($arrayMasters as $maserName => $value) {
            if($maserName === 'areaMst' || $maserName === 'stationMst') {
                continue;
            }
            $jobMasters->$maserName = $value;
        }

        $msgL1 = new MsgL1GetJobDetail();
        $msgL1->apiResult = $jobDetailData;
        $msgL1->masters = $jobMasters;
        $l1 = new L1GetJobDetail();
        $l1->execute($msgL1);

        if($msgL1->_c != JsonResponse::HTTP_OK){
            return view('pages.maintenance', compact('page')); //エラー表示
        }

        $fEntJobDetail = $msgL1->fEntJobDetail;

        $subtitle = $fEntJobDetail->jobTitle ?? '';

        if(strlen($subtitle)>0) {
            $page->title = $subtitle . ' | ' . $page->title;
        }

        return view('pages.job', compact('page', 'fEntJobDetail', 'favoriteList'));
    }
}