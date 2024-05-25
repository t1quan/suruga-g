<?php

namespace App\Http\Controllers;

use App\config\Consts\TenrikuConst;
use App\Core\Logger\Logger;
use App\Models\FEnt\FEntJobDetail;
use App\Models\FEnt\FEntJobMasters;
use App\Models\FEnt\FEntApplyMasters;
use App\Models\FEnt\FEntPage;
use App\Models\FEnt\FEntValidateRuleConfig;
use App\Models\L1\L1CreateFEntPage;
use App\Models\L1\L1GetJobDetail;
use App\Models\L1\Msg\MsgL1CreateFEntPage;
use App\Models\L1\Msg\MsgL1GetJobDetail;
use App\Util\UtilApplyValidate;
use App\Util\UtilFavorite;
use App\Util\UtilHttpRequest;
use App\Util\UtilKbnMaster;
use ErrorException;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

/**
 * Class  WebRegistConfirmController
 * @package App\Http\Controllers
 */
class WebRegistConfirmController extends Controller
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
     * WebRegistConfirmController constructor.
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
        $this->applyMasters = UtilKbnMaster::getApplyMasters();

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
    public function show(Request $request, $path)
    {
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

        $rules = $validateRuleConfig->rules;
        $messages = $validateRuleConfig->messages;

        $this->validate($request,$rules,$messages);

        $params = $request->all();

        $page = $this->page;
        $page->id = $path. '_confirm';
        $page->class = $path. '_confirm';
        $page->action = Route($path. '.thanks');

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

        $key = "textlist." . $path . "Confirm";
        $subtitle =  __($key);
        if($subtitle !== $key) { //対象のキーが定義されていない場合、指定したキーの文字列がそのまま表示されてしまうため回避する
            $page->title = $subtitle . ' | ' . $page->title;
        }

        if(!isset($fEntJobDetail)) {
            $fEntJobDetail = new FEntJobDetail();
            $fEntJobDetail->corpCd = $page->fEntConfig->corporations[0]['corpCd'];
        }

        Logger::infoTrace(__METHOD__ . ' - end');

        $viewName = 'pages.' . $path . '.confirm';
        return view($viewName, compact('page','fEntJobDetail', 'fEntApplyMasters', 'params'));
    }

}
