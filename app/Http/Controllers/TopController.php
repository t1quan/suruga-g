<?php

namespace App\Http\Controllers;

use App\Core\Logger\Logger;
use App\Models\FEnt\FEntJobMasters;
use App\Models\FEnt\FEntPage;
use App\Models\FEnt\FEntSearchAxisData;
use App\Models\L1\L1CreateFEntPage;
use App\Models\L1\L1GetSearchAxisData;
use App\Models\L1\Msg\MsgL1CreateFEntPage;
use App\Models\L1\Msg\MsgL1GetSearchAxisData;
use App\Util\UtilFavorite;
use App\Util\UtilKbnMaster;
use ErrorException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class TopController extends Controller
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

        $msgL1 = new MsgL1GetSearchAxisData();
        $msgL1->frontendSettings = $fEntPage->fEntConfig->frontendSettings;
        $l1 = new L1GetSearchAxisData();
        $l1->execute($msgL1);

        $this->fEntSearchAxisData = $msgL1->fEntSearchAxisData;

    }

    /**
     * @throws Exception
     */
    public function show()
    {
        Logger::infoTrace(__METHOD__ . ' - start');
        $page = $this->page;
        $page->id = 'top';
        $page->class = 'top';
        $page->action = route('top');

        $fEntSearchAxisData = $this->fEntSearchAxisData;

        if(!($fEntSearchAxisData->isSuccessGetAxis)) {
            return view('pages.maintenance', compact('page')); //エラー表示
        }

        $favoriteList = $this->favoriteList;

        Logger::infoTrace(__METHOD__ . ' - end');
        return view('pages.top', compact('page','fEntSearchAxisData','favoriteList'));
    }
}
