<?php

namespace App\Http\Controllers;

use App\config\Consts\TenrikuConst;
use App\Core\Logger\Logger;
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
 * Class  ApplyConfirmController
 * @package App\Http\Controllers
 */
class ApplyConfirmController extends Controller
{

    /** @var FEntPage */
    private $page;
    /** @var array */
    private $favoriteList;
    /** @var FEntJobMasters */
    private $masters;
    /** @var FEntValidateRuleConfig */
    private $validateRuleConfig;
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
        $arrayCorpCd = $fEntPage->fEntConfig->frontendSettings['arrayCorpCd']??null;
        $this->page->favoriteJobCnt = UtilFavorite::getFavoriteJobCount($arrayCorpCd, $this->favoriteList);

        //validation用のルール作成
        $applyFormSettings = array();
        if(isset($this->page->fEntConfig->backendSettings['form']['apply'])) {
            $applyFormSettings = $this->page->fEntConfig->backendSettings['form']['apply'];
        }
        else {
            $applyFormSettings = config('applyForm');
        }

        $this->validateRuleConfig = UtilApplyValidate::createApplyValidateRuleConfig($applyFormSettings);

        $this->applyMasters = UtilKbnMaster::getApplyMasters();

    }

    public function create($id)
    {
        Logger::infoTrace(__METHOD__ .' - start', $id);
        $intended = Route('top')."/apply/{$id}";
        return redirect()->intended($intended);
    }

    /**
     * @throws ValidationException|Exception
     */
    public function show(Request $request, $id)
    {
        Logger::infoTrace(__METHOD__ .' - start');

        $rules = $this->validateRuleConfig->rules;
        $messages = $this->validateRuleConfig->messages;

        $this->validate($request,$rules,$messages);

        $params = $request->all();

        $page = $this->page;
        $page->id = 'apply_confirm';
        $page->class = 'apply_confirm';
        $page->action = Route('top')."/apply/thanks/{$id}";


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

        if ($ary->code == JsonResponse::HTTP_NOT_FOUND || $ary->code == JsonResponse::HTTP_FORBIDDEN) {
            Logger::errorTrace('Request job is not found.', $id);
            return view('pages.apply.confirm', compact('page')); //該当求人ヒットせず
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
            Logger::errorTrace('Request Error is CreateJobDetail.', $id);
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

        $key = "textlist.applyConfirm";
        $subtitle =  __($key);
        if($subtitle !== $key) { //対象のキーが定義されていない場合、指定したキーの文字列がそのまま表示されてしまうため回避する
            $page->title = $subtitle . ' | ' . $page->title;
        }

        Logger::infoTrace(__METHOD__ . ' - end');
        return view('pages.apply.confirm', compact('page','fEntJobDetail', 'fEntApplyMasters', 'params'));
    }

}
