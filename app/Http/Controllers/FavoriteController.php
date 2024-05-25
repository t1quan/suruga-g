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
use App\Models\L1\Msg\MsgL1CreateFEntPage;
use App\Models\L1\Msg\MsgL1GetArrayJob;
use App\Util\UtilFavorite;
use App\Util\UtilKbnMaster;
use App\Util\UtilPager;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

/**
 * Class FavoriteController
 * @package App\Http\Controllers
 */
class FavoriteController extends Controller
{
    /** @var FEntPage */
    private $page;
    /** @var array */
    private $favoriteList;
    /** @var FEntJobMasters */
    private $masters;

    /**
     * SitemapController constructor.
     *
     * @throws Exception
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

        $page = $msgL1CreateFEntPage->fEntPage;
        $page->id = 'favorite';
        $page->class = 'favorite';
        $page->description = '本リストのデータは約30日程度で失われる可能性がございますので、長期間情報を保存される場合は各求人ページをブックマークすることをお勧めいたします。';
        $page->action = route('favorite');
        $page->noindex = true;

        $this->page = $page;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function create(Request $request){
        Logger::infoTrace(__METHOD__.' - start');

        $page = $this->page;
        $favoriteList = $this->favoriteList;

        $key = "textlist.favorite";
        $subtitle =  __($key);
        if($subtitle !== $key) { //対象のキーが定義されていない場合、指定したキーの文字列がそのまま表示されてしまうため回避する
            $page->title = $subtitle . ' | ' . $page->title;
        }

        // cookieの取得
        if (!$favoriteList or count($favoriteList) == 0){
            Logger::infoTrace(__METHOD__. ' - end', 'undefined favoriteList.');
            return view('pages.favorite', compact('page'));
        }

        $params = array();
        foreach(self::$allowParamList as $type => $paramNames){
            foreach($paramNames as $paramName){
                if($request->$paramName != null and $request->$paramName !== ''){
                    $params[$paramName] = $request->$paramName;
                }
            }
        }

        $fEntJobSearchCriteria = self::createFEntJobSearchCriteria($params);

        if(json_encode($fEntJobSearchCriteria) === json_encode(new FEntJobSearchCriteria())) {
            return view('pages.maintenance', compact('page')); //エラー表示
        }

        $masters = new FEntJobMasters();
        if($this->masters) {
            foreach ($this->masters as $maserName => $value) {
                if ($maserName === 'areaMst' || $maserName === 'stationMst') {
                    continue;
                }
                $masters->$maserName = $value;
            }
        }

        $msgL1 = new MsgL1GetArrayJob();
        $msgL1->fEntJobSearchCriteria = $fEntJobSearchCriteria;
        $msgL1->masters = $this->masters;
        $l1 = new L1GetArrayJob();
        $l1->execute($msgL1);
        if($msgL1->_c != JsonResponse::HTTP_OK){
            Logger::errorThrowable($msgL1->_m);
            return view('pages.maintenance', compact('page')); //エラー表示
        }
        $arrayFEntJob = $msgL1->arrayFEntJob;
        $page->favoriteJobCnt = $msgL1->totalCnt;

        $add = '/p_';
        if(isset($params['p'])){
            $add = '?p=';
        }
        $fEntPager = new FEntPager();
        $fEntPager->action = route('favorite') . $add;
        $fEntPager->totalCnt = $msgL1->totalCnt;
        $fEntPager->currentPage = $msgL1->fEntJobSearchCriteria->pageNo;
        $fEntPager->pageLimit = $msgL1->fEntJobSearchCriteria->pageLimit;
        $fEntPager->maxLinkCount = $page->frontendSettings['pager']['maxLink'] ?? TenrikuConst::$MAX_LINK_COUNT;

        $fEntPager = UtilPager::createFEntPager($fEntPager);

        Logger::infoTrace(__METHOD__.' - end');
        return view('pages.favorite', compact('page', 'arrayFEntJob', 'fEntPager', 'favoriteList'));
    }

    /**
     * @param $p
     * @return Application|Factory|View
     */
    public function store($p){
        Logger::infoTrace(__METHOD__.' - start', $p);

        $page = $this->page;
        $favoriteList = $this->favoriteList;

        $key = "textlist.favorite";
        $subtitle =  __($key);
        if($subtitle !== $key) { //対象のキーが定義されていない場合、指定したキーの文字列がそのまま表示されてしまうため回避する
            $page->title = $subtitle . ' | ' . $page->title;
        }

        // cookieの取得
        if (!$favoriteList or count($favoriteList) == 0){
            Logger::infoTrace(__METHOD__ . ' - end', 'undefined favoriteList.');
            return view('pages.favorite', compact('page'));
        }

        $params = array('p' => $p);
        $fEntJobSearchCriteria = self::createFEntJobSearchCriteria($params);

        if(json_encode($fEntJobSearchCriteria) === json_encode(new FEntJobSearchCriteria())) {
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
        $arrayFEntJob = $msgL1->arrayFEntJob;
        $page->favoriteJobCnt = $msgL1->totalCnt;

        $add = '/p_';
        $fEntPager = new FEntPager();
        $fEntPager->action = route('favorite') . $add;
        $fEntPager->totalCnt = $msgL1->totalCnt;
        $fEntPager->currentPage = $msgL1->fEntJobSearchCriteria->pageNo;
        $fEntPager->pageLimit = $msgL1->fEntJobSearchCriteria->pageLimit;
        $fEntPager->maxLinkCount = $page->frontendSettings['pager']['maxLink'] ?? TenrikuConst::$MAX_LINK_COUNT;

        $fEntPager = UtilPager::createFEntPager($fEntPager);

        Logger::infoTrace(__METHOD__.' - end', $p);
        return view('pages.favorite', compact('page', 'arrayFEntJob', 'fEntPager', 'favoriteList'));
    }

    // リクエストパラメータ取得対象 / リスト内に含まれないものは参照しない

    /**
     * @var array|string[][]
     */
    private static array $allowParamList = array(
        'number' => array(
            'p'
        )
    );

    /**
     * @param $params
     * @return FEntJobSearchCriteria
     */
    private function createFEntJobSearchCriteria($params): FEntJobSearchCriteria
    {

        $pageNo = null;
        $fEntJobSearchCriteria = new FEntJobSearchCriteria();
        if(isset($params['p'])) $pageNo = $params['p'];
        if($pageNo == null or $pageNo === ''){// default 1
            $pageNo = TenrikuConst::$DEFAULT_PAGE_NO;
        }

        $arrayJobNo = array();
        if ($this->favoriteList) {
            foreach ($this->favoriteList as $jobNo => $timestamp) {
                $arrayJobNo[] = $jobNo;
            }
            $fEntJobSearchCriteria->jobNos = implode('[]', $arrayJobNo);
        }

        if(isset($this->page->fEntConfig->frontendSettings['arrayCorpCd']) &&(count($this->page->fEntConfig->frontendSettings['arrayCorpCd'])>0) ) {
            $fEntJobSearchCriteria->corpCode = implode('[]', $this->page->fEntConfig->frontendSettings['arrayCorpCd']);
        }
        else {//企業設定情報にも企業コードが存在しない場合
            Logger::errorTrace(__METHOD__ . ' Error: frontendSettings ArrayCorpCode is Undefined or NULL', $fEntJobSearchCriteria);
            return (new FEntJobSearchCriteria());
        }

        $fEntJobSearchCriteria->pageNo = $pageNo;
        $fEntJobSearchCriteria->pageLimit = TenrikuConst::$DEFAULT_PAGE_LIMIT;
        $fEntJobSearchCriteria->searchType = TenrikuConst::$DEFAULT_SEARCH_TYPE;
        $fEntJobSearchCriteria->isMatchFullJobNo = !(env('VITE_PREFIX_MATCH')); //仕事番号分割フラグとtrue/falseを反転させる

        return $fEntJobSearchCriteria;
    }

}
