<?php

namespace App\Http\Controllers;

use App\config\Consts\TenrikuConst;
use App\Core\Logger\Logger;
use App\Models\Constant\Cst;
use App\Models\FEnt\FEntJobDetail;
use App\Models\FEnt\FEntJobMasters;
use App\Models\FEnt\FEntApplyMasters;
use App\Models\FEnt\FEntUserApplyInfo;
use App\Models\FEnt\FEntPage;
use App\Models\L1\L1CreateFEntPage;
use App\Models\L1\L1CreateUserApplyInfo;
use App\Models\L1\L1GetJobDetail;
use App\Models\L1\Msg\MsgL1CreateFEntPage;
use App\Models\L1\Msg\MsgL1CreateUserApplyInfo;
use App\Models\L1\Msg\MsgL1GetJobDetail;
use App\Util\UtilFavorite;
use App\Util\UtilHttpRequest;
use App\Util\UtilKbnMaster;
use ErrorException;
use Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

/**
 * Class ApplyController
 * @package App\Http\Controllers
 */
class WebRegistController extends Controller
{

    /** @var FEntPage */
    private $page;
    /** @var array */
    private $favoriteList;
    /** @var FEntJobMasters */
    private $masters;
    /** @var FEntApplyMasters */
    private $applyMasters;

    /**
     * WebRegistController constructor.
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
        $this->applyMasters = UtilKbnMaster::getApplyMasters();
        $arrayCorpCd = $fEntPage->fEntConfig->frontendSettings['arrayCorpCd']??null;
        $this->page->favoriteJobCnt = UtilFavorite::getFavoriteJobCount($arrayCorpCd, $this->favoriteList);
    }

    /**
     * @throws Exception
     */
    public function show($path)
    {
        Logger::infoTrace(__METHOD__ . ' - start');
        $page = $this->page;
        $page->id = $path;
        $page->class = $path;
        $page->action = Route($path. '.confirm');

        $webRegistConfig = null;

        if(isset($page->fEntConfig->corporations[0]['form'][$path])) {
            $webRegistConfig = $page->fEntConfig->corporations[0]['form'][$path];
        }

        if(!$webRegistConfig) {
            Logger::errorTrace('WebRegist Config is undefined', null);
            return view('pages.maintenance', compact('page')); //エラー表示
        }

        $id = null;
        if(isset($webRegistConfig['type']) && $webRegistConfig['type'] === 'register') {
            if(!isset($webRegistConfig['jobId'])) {
                Logger::errorTrace('WebRegist Type is Register. But jobId is undefined', $id);
                return view('pages.maintenance', compact('page')); //エラー表示
            }
            if((env('APP_ENV') === 'production') || (env('APP_ENV') === 'develop')) {
                $id = $webRegistConfig['jobId'];
                if($id > TenrikuConst::INTEGER_MAX) {
                    App::abort(404);
                }
            }
            else {
                $id = 33617; //固定jobIdを設定
            }
        }

        //求人IDが設定されている場合は求人情報の取得を行う
        if($id) {
            $token = UtilHttpRequest::getToken();
            // endpointの指定
            $endpoint = env('API_BASE_URL') . "/job/" . $id;
            //---CURL Request
            $result = UtilHttpRequest::cUrlRequest("GET", $endpoint, $token);

            if(!$result) {
                Logger::errorTrace('Error API connect to:', [$endpoint]);
                return view('pages.maintenance', compact('page')); //エラー表示
            }

            $ary = json_decode($result);  // JSONを配列に

            //404 or 403で返ってきた場合
            if ($ary->code == JsonResponse::HTTP_NOT_FOUND || $ary->code == JsonResponse::HTTP_FORBIDDEN) {
                Logger::errorTrace('Request job is not found.', $id);
                return view('pages.apply.index', compact('page')); //該当求人ヒットせず
            }

            if ($ary->code != JsonResponse::HTTP_OK) {
                Logger::errorTrace('Request Error is GetJobDetail.', $id);
                return view('pages.maintenance', compact('page')); //エラー表示
            }

            $jobDetailData = $ary->data;

            $fEntJobMasters = new FEntJobMasters();
            $masters = $this->masters;

            foreach($masters as $maserName => $value) {
                $fEntJobMasters->$maserName = $value;
            }

            $msgL1 = new MsgL1GetJobDetail();
            $msgL1->apiResult = $jobDetailData;
            $msgL1->masters = $fEntJobMasters;
            $l1 = new L1GetJobDetail();
            $l1->execute($msgL1);

            if($msgL1->_c != JsonResponse::HTTP_OK){
                return view('pages.maintenance', compact('page')); //エラー表示
            }

            $fEntJobDetail = $msgL1->fEntJobDetail;
        }

        $fEntApplyMasters = $this->applyMasters;

        foreach($fEntApplyMasters As $name => $items) {
            if(!$items || count($items)===0) {
                Logger::errorTrace('Request Error is getApplyMasters.', $name);
                return view('pages.maintenance', compact('page')); //エラー表示
            }
        }

        $fEntUserApplyInfo = new FEntUserApplyInfo();

        $key = "textlist." . $path;
        $subtitle =  __($key);
        if($subtitle !== $key) { //対象のキーが定義されていない場合、指定したキーの文字列がそのまま表示されてしまうため回避する
            $page->title = $subtitle . ' | ' . $page->title;
        }

        if(!isset($fEntJobDetail)) {
            $fEntJobDetail = new FEntJobDetail();
            $fEntJobDetail->corpCd = $page->fEntConfig->corporations[0]['corpCd'];
        }

        Logger::infoTrace(__METHOD__ . ' - end');

        $viewName = 'pages.' . $path . '.index';
        return view($viewName, compact('page', 'fEntJobDetail', 'fEntUserApplyInfo', 'fEntApplyMasters'));
    }

    /**
     * @throws Exception
     */
    public function store(Request $request, $path){

        $params = $request->all();
        Logger::infoTrace(__METHOD__ . ' - start');

        $page = $this->page;
        $page->id = $path;
        $page->class = $path;
        $page->action = Route($path. '.confirm');

        $webRegistConfig = null;

        if(isset($page->fEntConfig->corporations[0]['form'][$path])) {
            $webRegistConfig = $page->fEntConfig->corporations[0]['form'][$path];
        }

        if(!$webRegistConfig) {
            Logger::errorTrace('WebRegist Config is undefined', null);
            return view('pages.maintenance', compact('page')); //エラー表示
        }

        $id = null;
        if(isset($webRegistConfig['type']) && $webRegistConfig['type'] === 'register') {
            if(!isset($webRegistConfig['jobId'])) {
                Logger::errorTrace('WebRegist Type is Register. But jobId is undefined', $id);
                return view('pages.maintenance', compact('page')); //エラー表示
            }
            if((env('APP_ENV') === 'production') || (env('APP_ENV') === 'develop')) {
                $id = $webRegistConfig['jobId'];
                if($id > TenrikuConst::INTEGER_MAX) {
                    App::abort(404);
                }
            }
            else {
                $id = 33617; //固定jobIdを設定
            }
        }

        //求人IDが設定されている場合は求人情報の取得を行う
        if($id) {
            $token = UtilHttpRequest::getToken();
            // endpointの指定
            $endpoint = env('API_BASE_URL') . "/job/" . $id;
            //---CURL Request
            $result = UtilHttpRequest::cUrlRequest("GET", $endpoint, $token);

            if(!$result) {
                Logger::errorTrace('Error API connect to:', [$endpoint]);
                return view('pages.maintenance', compact('page')); //エラー表示
            }

            $ary = json_decode($result);  // JSONを配列に

            //404 or 403で返ってきた場合
            if ($ary->code == JsonResponse::HTTP_NOT_FOUND || $ary->code == JsonResponse::HTTP_FORBIDDEN) {
                Logger::errorTrace('Request job is not found.', $id);
                return view('pages.apply.index', compact('page')); //該当求人ヒットせず
            }

            if ($ary->code != JsonResponse::HTTP_OK) {
                Logger::errorTrace('Request Error is GetJobDetail.', $id);
                return view('pages.maintenance', compact('page')); //エラー表示
            }

            $jobDetailData = $ary->data;

            $fEntJobMasters = new FEntJobMasters();
            $masters = $this->masters;

            foreach($masters as $maserName => $value) {
                $fEntJobMasters->$maserName = $value;
            }

            $msgL1 = new MsgL1GetJobDetail();
            $msgL1->apiResult = $jobDetailData;
            $msgL1->masters = $fEntJobMasters;
            $l1 = new L1GetJobDetail();
            $l1->execute($msgL1);

            if($msgL1->_c != JsonResponse::HTTP_OK){
                return view('pages.maintenance', compact('page')); //エラー表示
            }

            $fEntJobDetail = $msgL1->fEntJobDetail;
        }

        $fEntApplyMasters = $this->applyMasters;

        foreach($fEntApplyMasters As $name => $items) {
            if(!$items || count($items)===0) {
                Logger::errorTrace('Request Error is getApplyMasters.', $name);
                return view('pages.maintenance', compact('page')); //エラー表示
            }
        }

        $fEntUserApplyInfo = null;

        $msgL1CreateUserApplyInfo = new MsgL1CreateUserApplyInfo();
        $msgL1CreateUserApplyInfo->params = $params;
        $l1CreateUserApplyInfo = new L1CreateUserApplyInfo();
        $l1CreateUserApplyInfo->execute($msgL1CreateUserApplyInfo);
        if($msgL1CreateUserApplyInfo->_c == JsonResponse::HTTP_OK){
            $fEntUserApplyInfo = $msgL1CreateUserApplyInfo->fEntUserApplyInfo;
        }

        $key = "textlist." . $path;
        $subtitle =  __($key);
        if($subtitle !== $key) { //対象のキーが定義されていない場合、指定したキーの文字列がそのまま表示されてしまうため回避する
            $page->title = $subtitle . ' | ' . $page->title;
        }

        if(!isset($fEntJobDetail)) {
            $fEntJobDetail = new FEntJobDetail();
            $fEntJobDetail->corpCd = $page->fEntConfig->corporations[0]['corpCd'];
        }

        Logger::infoTrace(__METHOD__ . ' - end');

        $viewName = 'pages.' . $path . '.index';
        return view($viewName, compact('page', 'fEntJobDetail', 'fEntUserApplyInfo', 'fEntApplyMasters'));
    }

}
