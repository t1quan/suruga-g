<?php

namespace App\Http\Controllers;

use App\config\Consts\TenrikuConst;
use App\Core\Logger\Logger;
use App\Models\FEnt\FEntJobMasters;
use App\Models\FEnt\FEntJobSearchCriteria;
use App\Models\FEnt\FEntPage;
use App\Models\FEnt\FEntPager;
use App\Models\L1\L1CreateFEntPage;
use App\Models\L1\L1GetArrayJob;
use App\Models\L1\L1CreateArrayTitle;
use App\Models\L1\Msg\MsgL1CreateFEntPage;
use App\Models\L1\Msg\MsgL1GetArrayJob;
use App\Models\L1\Msg\MsgL1CreateArrayTitle;
use App\Util\UtilFavorite;
use App\Util\UtilKbnMaster;
use App\Models\FEnt\FEntSearchAxisData;
use App\Models\L1\L1GetSearchAxisData;
use App\Models\L1\Msg\MsgL1GetSearchAxisData;
use App\Util\UtilPager;
use App\Util\UtilStringFormat;
use ErrorException;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

/**
 * Class SearchController
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{
    /** @var FEntPage */
    private $page;
    /** @var array */
    private $favoriteList;
    /** @var FEntJobMasters */
    private $masters;
    /** @var FEntSearchAxisData */
    private $fEntSearchAxisData;

    /**
     * SearchController constructor.
     * @throws ErrorException|Exception
     */
    public function __construct()
    {

        $msgL1CreateFEntPage = new MsgL1CreateFEntPage();
        $l1CreateFEntPage = new L1CreateFEntPage();
        $l1CreateFEntPage->execute($msgL1CreateFEntPage);
        if($msgL1CreateFEntPage->_c != JsonResponse::HTTP_OK) {
            App::abort(503);
        }
        $fEntPage = $msgL1CreateFEntPage->fEntPage;
        $this->page = $fEntPage;
        $this->favoriteList = UtilFavorite::getFavoriteList();
        $this->masters = UtilKbnMaster::getJobMasters();
        $arrayCorpCd = $fEntPage->fEntConfig->frontendSettings['arrayCorpCd']??null;
        $this->page->favoriteJobCnt = UtilFavorite::getFavoriteJobCount($arrayCorpCd, $this->favoriteList);

        $msgL1 = new MsgL1GetSearchAxisData();
        $msgL1->frontendSettings = $fEntPage->fEntConfig->frontendSettings;
        $l1 = new L1GetSearchAxisData();
        $l1->execute($msgL1);

        $this->fEntSearchAxisData = $msgL1->fEntSearchAxisData;
    }

    /**
     * @throws Exception
     */
    public function show(){

        Logger::infoTrace(__METHOD__ . ' - start');

        $page = $this->page;
        $page->id = 'search';
        $page->class = 'search';
        $page->action = route('search');

        //検索軸取得判定処理結果
        $fEntSearchAxisData = $this->fEntSearchAxisData;

        if(!($fEntSearchAxisData->isSuccessGetAxis)) {
            return view('pages.maintenance', compact('page')); //エラー表示
        }

        $key = "textlist.search";
        $subtitle =  __($key);
        if($subtitle !== $key) { //対象のキーが定義されていない場合、指定したキーの文字列がそのまま表示されてしまうため回避する
            $page->title = $subtitle . ' | ' . $page->title;
        }

        Logger::infoTrace(__METHOD__ . ' - end');

        return view('pages.search', compact('page', 'fEntSearchAxisData'));
    }

    // Directoryパラメータでの検索

    /**
     * @param $params
     * @return Application|Factory|View
     */
    public function dirSearch($params){

        Logger::infoTrace(__METHOD__ . ' - start');

        $page = $this->page;
        $page->id = 'search';
        $page->class = 'search';

        $res = self::getParam($params);
        $dirParams = $res[0];
        $fEntJobSearchCriteria = $res[1];

        if(json_encode($fEntJobSearchCriteria) === json_encode(new FEntJobSearchCriteria())) {
            return view('pages.maintenance', compact('page')); //エラー表示(URLはそのままになる)
        }

        $pageParam = 'p_' . $fEntJobSearchCriteria->pageNo;
        //ページパラメータ削除
        $result = array_diff($dirParams, array($pageParam));
        //indexを詰める
        $result = array_values($result);

        $jobMasters = new FEntJobMasters();
        $masters = $this->masters;

        //検索軸取得判定処理結果
        $fEntSearchAxisData = $this->fEntSearchAxisData;

        if(!($fEntSearchAxisData->isSuccessGetAxis)) {
            return view('pages.maintenance', compact('page')); //エラー表示(URLはそのままになる)
        }

        foreach($masters as $maserName => $value) {
            if($maserName === 'stationMst') { //一次検索の時点ではエリアマスタは使用しないが、二次検索用の情報生成時に使用する
                continue;
            }
            $jobMasters->$maserName = $value;
        }

        //求人一覧取得処理
        $msgL1 = new MsgL1GetArrayJob();
        $msgL1->fEntJobSearchCriteria = $fEntJobSearchCriteria;
        $msgL1->masters = $jobMasters;
        $l1 = new L1GetArrayJob();
        $l1->execute($msgL1);

        if($msgL1->_c == JsonResponse::HTTP_FORBIDDEN) { //int型最大値を超えたパラメータの場合の想定ステータスコード
            App::abort(403); //画面表示としては403エラー
        }

        if($msgL1->_c != JsonResponse::HTTP_OK) {
            return view('pages.maintenance', compact('page')); //エラー表示(URLはそのままになる)
        }

        $arrayFEntJob = $msgL1->arrayFEntJob;

        $fEntPager = new FEntPager();
        $addParams = implode('/', $result);
        if($addParams){
            $addParams = '/' . $addParams;
        }
        $fEntPager->action = route('search') . $addParams .'/p_';
        $fEntPager->totalCnt = $msgL1->totalCnt;
        $fEntPager->currentPage = $msgL1->fEntJobSearchCriteria->pageNo;
        $fEntPager->pageLimit = $msgL1->fEntJobSearchCriteria->pageLimit;
        $fEntPager->maxLinkCount = $page->frontendSettings['pager']['maxLink'] ?? TenrikuConst::$MAX_LINK_COUNT;

        $fEntPager = UtilPager::createFEntPager($fEntPager);

        $favoriteList = $this->favoriteList;
        $page->criteria = $fEntJobSearchCriteria;

        if($jobMasters->areaMst == null || count($jobMasters->areaMst)===0) {
            return view('pages.maintenance', compact('page')); //エラー表示(URLはそのままになる)
        }
        foreach($jobMasters->cityMst As $cityMst) { //市区町村コード整形
            $cityMst->value = $cityMst->parent.$cityMst->value;
        }

        $msgL1 = new MsgL1CreateArrayTitle();
        $msgL1->fEntJobSearchCriteria = $fEntJobSearchCriteria;
        $msgL1->fEntJobMasters = $jobMasters;
        $msgL1->fEntSearchAxisData = $fEntSearchAxisData;
        $l1 = new L1CreateArrayTitle();
        $l1->execute($msgL1);

        if($msgL1->_c == JsonResponse::HTTP_OK && ($msgL1->arrayTitle) && count($msgL1->arrayTitle)>0) {
            $arrayTitle = array();
            foreach($msgL1->arrayTitle as $key => $name){
                $arrayTitle[] = $name;
            }
            $resultTitle = implode("、", $arrayTitle) . 'の求人';
            $keyword = implode(",", $arrayTitle);
            $page->keywords = $keyword. ",". $page->keywords;
        }
        else {
            $resultTitle = '検索結果';
        }

        $page->title = $resultTitle . ' | '. $page->title;

        $searchSelectedMasterList = $jobMasters;
        Logger::infoTrace(__METHOD__ . ' - end');
        return view('pages.search', compact('page', 'fEntSearchAxisData', 'searchSelectedMasterList', 'arrayFEntJob', 'fEntPager', 'favoriteList', 'resultTitle'));
    }

    // Queryパラメータでの検索

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function querySearch(Request $request){

        Logger::infoTrace(__METHOD__ . ' - start');

        $page = $this->page;
        $page->id = 'search';
        $page->class = 'search';
        $page->action = route('search.query');

        //検索軸取得判定処理結果
        $fEntSearchAxisData = $this->fEntSearchAxisData;

        if(!($fEntSearchAxisData->isSuccessGetAxis)) {
            return view('pages.maintenance', compact('page')); //エラー表示(URLはそのままになる)
        }

        $jobMasters = new FEntJobMasters();
        $masters = $this->masters;

        foreach($masters as $maserName => $value) {
            if($maserName === 'stationMst') {
                continue;
            }
            $jobMasters->$maserName = $value;
        }

        $aryParam = array();
        foreach(self::$allowParamList as $key => $value){
            foreach($value as $v){
                if($request->$v != null and $request->$v !== ''){
                    $aryParam[$v] = $request->$v;
                }
            }
        }

        // 検索条件生成
        $fEntJobSearchCriteria = self::createFEntJobSearchCriteria($aryParam);

        if(json_encode($fEntJobSearchCriteria) === json_encode(new FEntJobSearchCriteria())) {
            return view('pages.maintenance', compact('page')); //エラー表示(URLはそのままになる)
        }

        //求人一覧取得処理
        $msgL1 = new MsgL1GetArrayJob();
        $msgL1->fEntJobSearchCriteria = $fEntJobSearchCriteria;
        $msgL1->masters = $jobMasters;
        $l1 = new L1GetArrayJob();
        $l1->execute($msgL1);

        if($msgL1->_c == JsonResponse::HTTP_FORBIDDEN) { //int型最大値を超えたパラメータの場合の想定ステータスコード
            App::abort(403); //画面表示としては403エラー
        }

        if($msgL1->_c != JsonResponse::HTTP_OK) {
            return view('pages.maintenance', compact('page')); //エラー表示(URLはそのままになる)
        }

        $arrayFEntJob = $msgL1->arrayFEntJob;

        $query = array();
        foreach($aryParam as $key => $value){
            if($key == 'p'){
                continue;
            }
            $query[] = $key . '=' . urlencode($value);
        }
        $queryStr = implode('&', $query);
        if($queryStr){
            $queryStr .=  '&p=';
        }else{
            $queryStr =  'p=';
        }

        $fEntPager = new FEntPager();
        $fEntPager->action = route('search.query') . '?'. $queryStr;
        $fEntPager->totalCnt = $msgL1->totalCnt;
        $fEntPager->currentPage = $msgL1->fEntJobSearchCriteria->pageNo;
        $fEntPager->pageLimit = $msgL1->fEntJobSearchCriteria->pageLimit;
        $fEntPager->maxLinkCount = $page->frontendSettings['pager']['maxLink'] ?? TenrikuConst::$MAX_LINK_COUNT;

        $fEntPager = UtilPager::createFEntPager($fEntPager);

        //求人検索時点でエリアマスタ以外の不備の検証は済んでいるためこの時点で検証はしない
        if($jobMasters->areaMst == null || count($jobMasters->areaMst)===0) {
            return view('pages.maintenance', compact('page')); //エラー表示(URLはそのままになる)
        }
        foreach($jobMasters->cityMst As $cityMst) { //市区町村コード整形
            $cityMst->value = $cityMst->parent.$cityMst->value;
        }

        $msgL1 = new MsgL1CreateArrayTitle();
        $msgL1->fEntJobSearchCriteria = $fEntJobSearchCriteria;
        $msgL1->fEntJobMasters = $jobMasters;
        $msgL1->fEntSearchAxisData = $fEntSearchAxisData;
        $l1 = new L1CreateArrayTitle();
        $l1->execute($msgL1);

        $favoriteList = $this->favoriteList;
        $page->criteria = $fEntJobSearchCriteria;

        if($msgL1->_c == JsonResponse::HTTP_OK && ($msgL1->arrayTitle) && count($msgL1->arrayTitle)>0) {
            $arrayTitle = array();
            foreach($msgL1->arrayTitle as $key => $name){
                $arrayTitle[] = $name;
            }
            $resultTitle = implode("、", $arrayTitle) . 'の求人';
            $keyword = implode(",", $arrayTitle);
            $page->keywords = $keyword. ",". $page->keywords;
        }
        else {
            $resultTitle = '検索結果';
        }

        $page->title = $resultTitle . ' | '. $page->title;

        $searchSelectedMasterList = $jobMasters;

        Logger::infoTrace(__METHOD__ . ' - end');
        return view('pages.search', compact('page', 'fEntSearchAxisData', 'searchSelectedMasterList', 'arrayFEntJob', 'fEntPager', 'favoriteList', 'resultTitle'));
    }

    /**
     * @param $params
     * @return array|null
     */
    private function getParam($params): ?array
    {

        if(!$params){
            return null;
        }
        $ptn = array();
        // 許可リストからパラメータのマッチチェックを行い、連想配列へ格納する
        foreach(self::$allowParamList as $key => $value){
            foreach($value as $v){
                if($key == 'number'){
                    $ptn[] = $v . '_[0-9]+';
                }
                if($key == 'string'){
                    $ptn[] = $v . '_[^\/]+';
                }
                if($key == 'boolean'){
                    $ptn[] = $v;
                }
            }
        }

        // 有効なURLParamsを抽出してパラメータの連想配列を生成する
        $pattern = implode("|", $ptn);
        $pattern = "/$pattern/";
        preg_match_all($pattern, $params,$matches);

        $aryParam = array();
        $delimiter = '_';
        $m = $matches[0];
        foreach($m as $str){
            if(strpos($str, $delimiter) != false){
                $ary = explode($delimiter, $str);
                if(count($ary) == 2){
                    $aryParam[$ary[0]] = $ary[1];
                }
            }else{
                $aryParam[$str] = true;
            }
        }
//        Logger::infoTrace('$aryParam:', $aryParam); // 確認用

        return array(
            $m, // 有効なディレクトリパラメータ: 'area_13' , 'vi' , 'kw_東京'
            self::createFEntJobSearchCriteria($aryParam)
        );
    }

    // リクエストパラメータ取得対象 / リスト内に含まれないものは参照しない
    private static $allowParamList = array(
        'number' => array(
            'corp',
            'bc',
            'area',
            'shiku',
            'city',
            'jobbc',
            'job',
            'industry',
            'kyuyo',
            'kyuyomin',
            'kyuyomax',
            'tokucho',
            'self',
            'p',
            's',
        ),
        'string' => array(
            'rosen',
            'kw',
            'bk',
        ),
        'boolean' => array(
            'rs',
            'ks',
            'ap',
            'hs',
            'sy',
            'th',
            'js',
            'is',
            'ss',
            'sk',
            'vi',
        ),
    );

    /**
     * @param $params
     * @return FEntJobSearchCriteria
     */
    private function createFEntJobSearchCriteria($params)
    {

        $delimiter = "[]";
        $koyKeitaiCodes = array();
        $fEntJobSearchCriteria = new FEntJobSearchCriteria();
        if(isset($params['corp'])) $fEntJobSearchCriteria->corpCode = $params['corp'];
        if(isset($params['bc'])) $fEntJobSearchCriteria->areaCodes = $params['bc'];
        if(isset($params['area'])) $fEntJobSearchCriteria->prefCodes = $params['area'];
        if(isset($params['city'])) $fEntJobSearchCriteria->cityCodes = $params['city'];
        if(isset($params['jobbc'])) $fEntJobSearchCriteria->jobGroupCodes = $params['jobbc'];
        if(isset($params['job']))$fEntJobSearchCriteria->jobCodes = $params['job'];
        if(isset($params['rs'])) $koyKeitaiCodes[] = 1;
        if(isset($params['ks'])) $koyKeitaiCodes[] = 2;
        if(isset($params['ap'])) $koyKeitaiCodes[] = 3;
        if(isset($params['hs'])) $koyKeitaiCodes[] = 4;
        if(isset($params['sy'])) $koyKeitaiCodes[] = 5;
        if(isset($params['th'])) $koyKeitaiCodes[] = 6;
        if(isset($params['js'])) $koyKeitaiCodes[] = 7;
        if(isset($params['is'])) $koyKeitaiCodes[] = 8;
        if(isset($params['ss'])) $koyKeitaiCodes[] = 99;
        if($koyKeitaiCodes){
            $fEntJobSearchCriteria->koyKeitaiCodes = implode($delimiter, $koyKeitaiCodes); // &k=1[]2[]3[]4 のような扱いに一旦揃えておく
        }
        if(isset($params['kyuyo'])) $fEntJobSearchCriteria->salaryCode = $params['kyuyo'];
        if(isset($params['kyuyomin'])) $fEntJobSearchCriteria->salaryMin = $params['kyuyomin'];
        if(isset($params['kyuyomax'])) $fEntJobSearchCriteria->salaryMax = $params['kyuyomax'];
        if(isset($params['tokucho'])) $fEntJobSearchCriteria->tokuchoCodes = $params['tokucho'];
        if(isset($params['rosen'])){
            if(!preg_match('/[^0-9\[\]:]/', $params['rosen'],$m)){
                $fEntJobSearchCriteria->rosenCodes = $params['rosen'];
            }
        }
        if(isset($params['kw'])) {
            $fEntJobSearchCriteria->keyword = self::formatStrCriteria($params['kw']);
        }

        if(isset($params['bk'])) {
            $fEntJobSearchCriteria->biko = self::formatStrCriteria($params['bk']);
        }

        if(!$fEntJobSearchCriteria->corpCode) {
            if(isset($this->page->fEntConfig->frontendSettings['arrayCorpCd']) &&(count($this->page->fEntConfig->frontendSettings['arrayCorpCd'])>0) ) {
                $fEntJobSearchCriteria->corpCode = implode('[]', $this->page->fEntConfig->frontendSettings['arrayCorpCd']); //検索パラメータとしてcopCdの指定がない場合、fEntConfigに設定されている企業コードを使用する
            }
            else {//企業設定情報にも企業コードが存在しない場合
                Logger::errorTrace(__METHOD__ . ' Error: frontendSettings ArrayCorpCode is Undefined or NULL', $fEntJobSearchCriteria);
                return (new FEntJobSearchCriteria());
            }
        }

        $fEntJobSearchCriteria->pageNo = $params['p'] ?? TenrikuConst::$DEFAULT_PAGE_NO;
        if(!is_numeric($fEntJobSearchCriteria->pageNo) || (int)$fEntJobSearchCriteria->pageNo <= 0){
            $fEntJobSearchCriteria->pageNo = TenrikuConst::$DEFAULT_PAGE_NO;
        }
        $fEntJobSearchCriteria->pageLimit = TenrikuConst::$DEFAULT_PAGE_LIMIT;
        $fEntJobSearchCriteria->searchType = TenrikuConst::$DEFAULT_SEARCH_TYPE;
        $fEntJobSearchCriteria->isMatchFullJobNo = !(env('VITE_PREFIX_MATCH')); //仕事番号分割フラグとtrue/falseを反転させる
        $fEntJobSearchCriteria->isAndSearchFeature = env('VITE_CRITERIA_AND_FEATURE') ?? false;
        $fEntJobSearchCriteria->isAndSearchKeyword = env('VITE_CRITERIA_AND_KEYWORD') ?? true;
        $fEntJobSearchCriteria->isAndSearchBiko = env('VITE_CRITERIA_AND_BIKO') ?? true;

        return $fEntJobSearchCriteria;
    }

    /**
     * @param $inStr
     * @return string
     */
    private function formatStrCriteria($inStr) {
        //全角スペースの置換・前後のスペースの削除・連続半角スペースの置換を行う(フロント側の表示制御用)

        $str = $inStr;

        $str = UtilStringFormat::fullSpaceToHalfSpace($str);
        $str = UtilStringFormat::trimStr($str);
        $str = UtilStringFormat::halfSpaceContinuousToOne($str);

        return $str;
    }

}
