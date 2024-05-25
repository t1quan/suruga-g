<?php

namespace App\Http\Controllers;

use App\config\Consts\TenrikuConst;
use App\Core\Context\Context;
use App\Core\Logger\Logger;
use App\Models\FEnt\FEntApplyMasters;
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
 * Class  ApplyThanksController
 * @package App\Http\Controllers
 */
class ApplyThanksController extends Controller
{
    /** @var FEntPage */
    private $page;
    /** @var array */
    private $favoriteList;
    /** @var FEntJobMasters */
    private $masters;
    /** @var FEntApplyMasters */
    private $applyMasters;
    /** @var FEntValidateRuleConfig */
    private $validateRuleConfig;

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
        $this->applyMasters = UtilKbnMaster::getApplyMasters();
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

    }

    /**
     * @throws ValidationException|Exception
     */
    public function create($id,$obosyaId=null){

        Logger::infoTrace(__METHOD__ .' - start', [$id, $obosyaId]);
        $page = $this->page;

        $page->id = 'apply_thanks';
        $page->class = 'apply_thanks';

        //応募者IDが存在しない場合応募画面にリダイレクト
        if(!$obosyaId) {
            $intended = Route('top')."/apply/{$id}";
            return redirect()->intended($intended);
        }

        // 対象の求人情報を一覧検索のAPIで取得する(必要データ量少ないため)
        if($id > TenrikuConst::INTEGER_MAX) {
            App::abort(404);
        }

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
            return view('pages.apply.thanks', compact('page'));
        }

        $key = "textlist.applyThanks";
        $subtitle =  __($key);
        if($subtitle !== $key) { //対象のキーが定義されていない場合、指定したキーの文字列がそのまま表示されてしまうため回避する
            $page->title = $subtitle . ' | ' . $page->title;
        }

        Logger::infoTrace(__METHOD__ .' - end', [$id, $obosyaId]);
        return view('pages.apply.thanks', compact('page', 'fEntJob'));
    }

    /**
     * @throws ValidationException|Exception
     */
    public function store(Request $request, $id){

        Logger::infoTrace(__METHOD__ .' - start', $id);
        $page = $this->page;

        $page->id = 'apply_thanks';
        $page->class = 'apply_thanks';

        $rules = $this->validateRuleConfig->rules;
        $messages = $this->validateRuleConfig->messages;

        $this->validate($request,$rules,$messages);

        $params = $request->all();

        Logger::debugTrace($params);

        if(isset($params['dobYear']) and isset($params['dobMonth']) and isset($params['dobDay'])){
            $y = $params['dobYear'];
            $m = $params['dobMonth'];
            $d = $params['dobDay'];
            if(!(checkdate($m,$d,$y))) {
                $intended = Route('top')."/apply/{$id}";
                return redirect()->intended($intended); //確認画面での日付のアラートを無視した場合、入力画面にリダイレクト
            }
        }

        Context::setProgramId('saveApply');

        if($id > TenrikuConst::INTEGER_MAX) {
            App::abort(404);
        }

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
            return view('pages.apply.thanks', compact('page'));
        }

        $msgL1 = new MsgL1SaveApply();
        $msgL1->params = $params;
        $msgL1->fEntJob = $fEntJob;
        $msgL1->fEntConfig = $page->fEntConfig;
        $isInsertApplicantData = true;
        $msgL1->isInsertApplicantData = $isInsertApplicantData;

        $msgL1->applyMasters = null; // 初期化
        if($isInsertApplicantData === false) {
            $fEntApplyMasters = $this->applyMasters;
            $msgL1->applyMasters = $fEntApplyMasters;
        }
        $msgL1->jobUri = null; //初期化
        if(isset($page->fEntConfig->backendSettings['form']['applyUri'])) {
            $msgL1->jobUri = $page->fEntConfig->backendSettings['form']['applyUri'] . $fEntJob->jobId;
        }

        $msgL1->formPath = 'apply';
        $msgL1->isLinkJob = true;
        $msgL1->isChangeMailTemplateId = false;
        $msgL1->mailObosyaId = 1;
        $msgL1->mailTantosyaId = 2;
        $msgL1->toTantosyaMailAddress = '';

        $l1 = new L1SaveApply();
        $l1->execute($msgL1);
        if($msgL1->_c != JsonResponse::HTTP_OK){
            return view('pages.maintenance', compact('page')); //エラー表示
        }

        Logger::infoTrace(__METHOD__ .' - end', $id);
        return redirect()->to(Route('top') . '/apply/thanks/'. $id . '/' . $msgL1->obosyaId . '/');
    }

}
