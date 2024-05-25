<?php

namespace App\Http\Controllers;

use App\config\Consts\TenrikuConst;
use App\Core\Logger\Logger;
use App\Models\Constant\Cst;
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
class ApplyController extends Controller
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
        $this->applyMasters = UtilKbnMaster::getApplyMasters();
        $arrayCorpCd = $fEntPage->fEntConfig->frontendSettings['arrayCorpCd']??null;
        $this->page->favoriteJobCnt = UtilFavorite::getFavoriteJobCount($arrayCorpCd, $this->favoriteList);

    }

    /**
     * @throws Exception
     */
    public function show($id)
    {
        Logger::infoTrace(__METHOD__ . ' - start', $id);
        $page = $this->page;
        $page->id = 'apply';
        $page->class = 'apply';
        $page->action = Route('top') . "/apply/confirm/{$id}";

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

        $fEntApplyMasters = $this->applyMasters;

        foreach($fEntApplyMasters As $name => $items) {
            if(!$items || count($items)===0) {
                Logger::errorTrace('Request Error is getApplyMasters.', $name);
                return view('pages.maintenance', compact('page')); //エラー表示
            }
        }

        $fEntUserApplyInfo = new FEntUserApplyInfo();

        $key = "textlist.apply";
        $subtitle =  __($key);
        if($subtitle !== $key) { //対象のキーが定義されていない場合、指定したキーの文字列がそのまま表示されてしまうため回避する
            $page->title = $subtitle . ' | ' . $page->title;
        }

        Logger::infoTrace(__METHOD__ . ' - end', $id);
        return view('pages.apply.index', compact('page', 'fEntJobDetail', 'fEntUserApplyInfo', 'fEntApplyMasters'));
    }

    /**
     * @throws Exception
     */
    public function store(Request $request){

        $params = $request->all();
        Logger::infoTrace(__METHOD__ . ' - start');

        $id = null;
        if(isset($params['job_id'])){
            $id = $params['job_id'];
        }else{
            abort(404);
        }
        $page = $this->page;
        $page->id = 'apply';
        $page->class = 'apply';
        $page->action = Route('top') . "/apply/confirm/{$id}";

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
            return view('pages.apply.index', compact('page'));
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
        $fEntUserApplyInfo = null;

        $fEntApplyMasters = $this->applyMasters;

        foreach($fEntApplyMasters As $name => $items) {
            if(!$items || count($items)===0) {
                Logger::errorTrace('Request Error is getApplyMasters.', $name);
                return view('pages.maintenance', compact('page')); //エラー表示
            }
        }

        $msgL1CreateUserApplyInfo = new MsgL1CreateUserApplyInfo();
        $msgL1CreateUserApplyInfo->params = $params;
        $l1CreateUserApplyInfo = new L1CreateUserApplyInfo();
        $l1CreateUserApplyInfo->execute($msgL1CreateUserApplyInfo);
        if($msgL1CreateUserApplyInfo->_c == JsonResponse::HTTP_OK){
            $fEntUserApplyInfo = $msgL1CreateUserApplyInfo->fEntUserApplyInfo;
        }

        $key = "textlist.apply";
        $subtitle =  __($key);
        if($subtitle !== $key) { //対象のキーが定義されていない場合、指定したキーの文字列がそのまま表示されてしまうため回避する
            $page->title = $subtitle . ' | ' . $page->title;
        }

        Logger::infoTrace(__METHOD__ . ' - end');
        return view('pages.apply.index', compact('page', 'fEntJobDetail', 'fEntUserApplyInfo', 'fEntApplyMasters'));
    }

}
