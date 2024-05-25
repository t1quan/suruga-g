<?php

namespace App\Http\Controllers;

use App\config\Consts\TenrikuConst;
use App\Core\Context\Context;
use App\Core\Logger\Logger;
use App\Models\FEnt\FEntJob;
use App\Models\FEnt\FEntJobMasters;
use App\Models\FEnt\FEntJobSearchCriteria;
use App\Models\FEnt\FEntPage;
use App\Models\FEnt\FEntValidateRuleConfig;
use App\Models\L1\L1CreateFEntPage;
use App\Models\L1\Msg\MsgL1CreateFEntPage;
use App\Models\L1\L1GetArrayJob;
use App\Models\L1\L1SaveApply;
use App\Models\L1\Msg\MsgL1GetArrayJob;
use App\Models\L1\Msg\MsgL1SaveApply;
use App\Util\UtilApplyValidate;
use App\Util\UtilFavorite;
use App\Util\UtilKbnMaster;
use ErrorException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

/**
 * Class  WebRegistThanksController
 * @package App\Http\Controllers
 */
class WebRegistThanksController extends Controller
{
    /** @var FEntPage */
    private $page;
    /** @var array */
    private $favoriteList;
    /** @var FEntJobMasters */
    private $masters;

    /**
     * ApplyThanksController constructor.
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

    public function create($path)
    {
        Logger::infoTrace(__METHOD__ .' - start');
        $intended = Route($path);
        return redirect()->intended($intended);
    }

    /**
     * @throws ValidationException|Exception
     */
    public function show($obosyaId=null, $path){

        Logger::infoTrace('path is', $path);
        Logger::infoTrace('obosyaId is', $obosyaId);

        Logger::infoTrace(__METHOD__ .' - start', [$path, $obosyaId]);
        $page = $this->page;

        $page->id = $path. '_thanks';
        $page->class = $path. '_thanks';

        //応募者IDが存在しない場合応募画面にリダイレクト
        if(!$obosyaId) {
            $intended = Route($path);
            return redirect()->intended($intended);
        }

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

        $viewName = 'pages.' . $path . '.thanks';

        // 求人IDが設定されている場合は対象の求人情報を一覧検索のAPIで取得する(必要データ量少ないため)
        if($id) {
            $fEntJobSearchCriteria = new FEntJobSearchCriteria();
            $fEntJobSearchCriteria->jobIds = $id;
            $fEntJobSearchCriteria->searchType = TenrikuConst::$DEFAULT_SEARCH_TYPE;

            if(isset($page->fEntConfig->frontendSettings['arrayCorpCd']) &&(count($page->fEntConfig->frontendSettings['arrayCorpCd'])>0) ) {
                $fEntJobSearchCriteria->corpCode = implode('[]', $page->fEntConfig->frontendSettings['arrayCorpCd']);
            }
            else {
                Logger::errorTrace(__METHOD__ . ' Error: frontendSettings ArrayCorpCode is Undefined or NULL', $fEntJobSearchCriteria);
                return view('pages.maintenance', compact('page')); //エラー表示
            }

            $msgL1 = new MsgL1GetArrayJob();
            $msgL1->fEntJobSearchCriteria = $fEntJobSearchCriteria;
            $msgL1->masters = $this->masters;
            $l1 = new L1GetArrayJob();
            $l1->execute($msgL1);
            if($msgL1->_c != JsonResponse::HTTP_OK){
                return view('pages.maintenance', compact('page')); //エラー表示
            }

            $fEntJob = $msgL1->arrayFEntJob[0]??null;

            if(!$fEntJob) {//該当求人ヒットしなかった場合
                return view($viewName, compact('page'));
            }
        }

        if(!isset($fEntJob)) {
            $fEntJob = new FEntJob();
            $fEntJob->jobId = null;
        }

        $key = "textlist." . $path . "Thanks";
        $subtitle =  __($key);
        if($subtitle !== $key) { //対象のキーが定義されていない場合、指定したキーの文字列がそのまま表示されてしまうため回避する
            $page->title = $subtitle . ' | ' . $page->title;
        }

        Logger::infoTrace(__METHOD__ .' - end', [$path, $obosyaId]);
        return view($viewName, compact('page', 'fEntJob'));
    }

    /**
     * @throws ValidationException|Exception
     */
    public function store(Request $request, $path){

        Logger::infoTrace(__METHOD__ .' - start');

        //validation用のルール作成
        $webRegistFormSettings = array();
        if(isset($this->page->fEntConfig->backendSettings['form'][$path])) {
            $webRegistFormSettings = $this->page->fEntConfig->backendSettings['form'][$path];
        }
        else {
            $webRegistFormSettings = config('applyForm');
        }

        $validateRuleConfig = UtilApplyValidate::createApplyValidateRuleConfig($webRegistFormSettings);

        $page = $this->page;

        $page->id = $path. '_thanks';
        $page->class = $path. '_thanks';

        $rules = $validateRuleConfig->rules;
        $messages = $validateRuleConfig->messages;

        $this->validate($request,$rules,$messages);

        $params = $request->all();

        Logger::debugTrace($params);

        if(isset($params['dobYear']) and isset($params['dobMonth']) and isset($params['dobDay'])){
            $y = $params['dobYear'];
            $m = $params['dobMonth'];
            $d = $params['dobDay'];
            if(!(checkdate($m,$d,$y))) {
                $intended = Route($path);
                return redirect()->intended($intended); //確認画面での日付のアラートを無視した場合、入力画面にリダイレクト
            }
        }

        Context::setProgramId('saveApply');

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
            $fEntJobSearchCriteria = new FEntJobSearchCriteria();
            $fEntJobSearchCriteria->jobIds = $id;
            $fEntJobSearchCriteria->searchType = TenrikuConst::$DEFAULT_SEARCH_TYPE;

            if(isset($page->fEntConfig->frontendSettings['arrayCorpCd']) &&(count($page->fEntConfig->frontendSettings['arrayCorpCd'])>0) ) {
                $fEntJobSearchCriteria->corpCode = implode('[]', $page->fEntConfig->frontendSettings['arrayCorpCd']);
            }
            else {
                Logger::errorTrace(__METHOD__ . ' Error: frontendSettings ArrayCorpCode is Undefined or NULL', $fEntJobSearchCriteria);
                return view('pages.maintenance', compact('page')); //エラー表示
            }

            $msgL1 = new MsgL1GetArrayJob();
            $msgL1->fEntJobSearchCriteria = $fEntJobSearchCriteria;
            $msgL1->masters = $this->masters;
            $l1 = new L1GetArrayJob();
            $l1->execute($msgL1);
            if($msgL1->_c != JsonResponse::HTTP_OK){
                return view('pages.maintenance', compact('page')); //エラー表示
            }

            $fEntJob = $msgL1->arrayFEntJob[0]??null;

            if(!$fEntJob) {//該当求人ヒットしなかった場合
                $viewName = 'pages.' . $path . '.thanks';
                return view($viewName, compact('page'));
            }
        }

        if(!isset($fEntJob)) {
            $fEntJob = new FEntJob();
            $fEntJob->jobId = "";
        }

        $msgL1 = new MsgL1SaveApply();
        $msgL1->params = $params;
        $msgL1->fEntJob = $fEntJob;
        $msgL1->fEntConfig = $page->fEntConfig;
        $msgL1->jobUri = $page->fEntConfig->backendSettings['form'][$path.'Uri'] ?? null;
        $l1 = new L1SaveApply();
        $l1->execute($msgL1);
        if($msgL1->_c != JsonResponse::HTTP_OK){
            return view('pages.maintenance', compact('page')); //エラー表示
        }

        Logger::infoTrace(__METHOD__ .' - end', $id);
        Logger::infoTrace('redirect to: ', [Route($path. '.thanks') . '/' . $msgL1->obosyaId . '/']);
        return redirect()->to(Route($path. '.thanks') . '/' . $msgL1->obosyaId . '/');
    }

}
