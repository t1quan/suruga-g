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

class ContentController extends Controller
{

    /** @var FEntPage */
    private $page;
    /** @var array */
    private $favoriteList;

    /**
     * ContentController constructor.
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

        $arrayCorpCd = $fEntPage->fEntConfig->frontendSettings['arrayCorpCd']??null;
        $this->page->favoriteJobCnt = UtilFavorite::getFavoriteJobCount($arrayCorpCd, $this->favoriteList);
    }

    /**
     * @throws Exception
     */
    public function show($path)
    {

        if($path === 'xxxx') {
            return redirect(Route('top')); //Route記述のためだけのパスなのでリダイレクト
        }

        Logger::infoTrace(__METHOD__ . ' - start');
        $page = $this->page;
        $page->id = 'content';
        $page->class = 'content';
        $page->action = route($path);

        $key = "textlist." . $path;
        $subtitle =  __($key);
        if($subtitle !== $key) { //対象のキーが定義されていない場合、指定したキーの文字列がそのまま表示されてしまうため回避する
            $page->title = $subtitle . ' | ' . $page->title;
        }

        Logger::infoTrace(__METHOD__ . ' - end');

        $viewName = 'pages.' . $path;
        return view($viewName, compact('page'));
    }
}
