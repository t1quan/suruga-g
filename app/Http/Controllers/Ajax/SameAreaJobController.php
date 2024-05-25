<?php

namespace App\Http\Controllers\Ajax;

use App\config\Consts\TenrikuConst;
use App\Core\Logger\Logger;
use App\Http\Controllers\Controller;
use App\Models\FEnt\FEntJobMasters;
use App\Models\FEnt\FEntJobSearchCriteria;
use App\Models\FEnt\FEntPage;
use App\Models\L1\L1CreateFEntPage;
use App\Models\L1\L1GetArrayJob;
use App\Models\L1\Msg\MsgL1CreateFEntPage;
use App\Models\L1\Msg\MsgL1GetArrayJob;
use App\Util\UtilFavorite;
use App\Util\UtilKbnMaster;

use ErrorException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

class SameAreaJobController extends Controller
{

    /** @var FEntPage */
    private $page;
    /** @var array */
    private $favoriteList;
    /** @var FEntJobMasters */
    private $masters;

    /**
     * SameAreaJobController constructor.
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
    }


    /**
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        Logger::infoTrace(__METHOD__ .' - start');

        $res = $request->validate([
            'jobId' => 'required|numeric|between:1,'.TenrikuConst::INTEGER_MAX,
            'prefCds' => 'array',
            'prefCds.*' => 'required|numeric',
        ]);
        if(!$res){
            throw ValidationException::withMessages([
                'errMsg' => 'エラーが発生しました。再度やり直してください。'
            ]);
        }

        $jobId = $request->get('jobId');
        $prefCds = $request->get('prefCds');

        $prefCd = implode('[]',$prefCds);

        Logger::infoTrace(__METHOD__ .' - createJobSearchCriteria', [$jobId, $prefCd]);

        $fEntJobSearchCriteria = new FEntJobSearchCriteria();

        $page = $this->page;

        $sameAreaJobInfo = array();
        if(isset($page->fEntConfig->backendSettings['equal'])) {
            $sameAreaJobInfo = $page->fEntConfig->backendSettings['equal'];
        }

        $fEntJobSearchCriteria->exceptJobIds = $jobId;

        $fEntJobSearchCriteria->prefCodes = $prefCd;

        $fEntJobSearchCriteria->pageLimit = $sameAreaJobInfo['limit']??3;

        $arrayFEntJob = array();

        if(isset($this->page->fEntConfig->frontendSettings['arrayCorpCd']) &&(count($this->page->fEntConfig->frontendSettings['arrayCorpCd'])>0) ) {
            $fEntJobSearchCriteria->corpCode = implode('[]', $this->page->fEntConfig->frontendSettings['arrayCorpCd']);
        }
        else {
            Logger::errorTrace(__METHOD__ . ' Error: frontendSettings ArrayCorpCode is Undefined or NULL', $fEntJobSearchCriteria);
            $list = view('components.sameAreaJob.item.list', compact('arrayFEntJob'))->render();
            return response()->json($list,200, ['Content-Type' => 'application/json'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }

        $fEntJobSearchCriteria->searchType = TenrikuConst::$DEFAULT_SEARCH_TYPE;
        $fEntJobSearchCriteria->pageNo = TenrikuConst::$DEFAULT_PAGE_NO;
        $fEntJobSearchCriteria->sort = $sameAreaJobInfo['sort']??null;
        $fEntJobSearchCriteria->isMatchFullJobNo = !(env('VITE_PREFIX_MATCH')); //仕事番号分割フラグとtrue/falseを反転させる
        $fEntJobSearchCriteria->isAndSearchKeyword = env('VITE_CRITERIA_AND_KEYWORD') ?? true;
        $fEntJobSearchCriteria->isAndSearchBiko = env('VITE_CRITERIA_AND_BIKO') ?? true;

        $jobMasters = new FEntJobMasters();
        $masters = $this->masters;

        foreach($masters as $maserName => $value) {
            if($maserName === 'stationMst') {
                continue;
            }
            $jobMasters->$maserName = $value;
        }

        $msgL1 = new MsgL1GetArrayJob();
        $msgL1->fEntJobSearchCriteria = $fEntJobSearchCriteria;
        $msgL1->masters = $jobMasters;
        $l1 = new L1GetArrayJob();
        $l1->execute($msgL1);

        if($msgL1->_c == JsonResponse::HTTP_OK){
            $arrayFEntJob = $msgL1->arrayFEntJob;
        }

        $favoriteList = $this->favoriteList;

        $list = view('components.sameAreaJob.item.list', compact('arrayFEntJob', 'favoriteList'))->render();

        Logger::infoTrace(__METHOD__ .' - end');

        return response()->json($list,200, ['Content-Type' => 'application/json'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
