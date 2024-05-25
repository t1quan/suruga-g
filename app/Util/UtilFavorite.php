<?php
namespace App\Util;

use App\config\Consts\TenrikuConst;
use App\Models\FEnt\FEntJobSearchCriteria;
use App\Models\L1\Msg\MsgL1GetOnlyJobCount;
use App\Models\L1\L1GetOnlyJobCount;
use Illuminate\Http\JsonResponse;

/**
 * Class UtilFavorite
 * @package App\Util
 */
class UtilFavorite
{

    /**
     * @return array
     */
    static function getFavoriteList(){
        $favoriteList = array();
        if(isset($_COOKIE[env('VITE_APP_NAME')])){
            $cookie = $_COOKIE[env('VITE_APP_NAME')];
            $favoriteList = array();
            if(strlen($cookie) > 0){
                $ary = explode(",", $cookie);
                foreach($ary as $targetCode){
                    if (env('VITE_TIMESTAMP_JOINT')){
                        $tcAry = explode(env('VITE_TIMESTAMP_JOINT'), $targetCode);
                        $favoriteList[$tcAry[0]] = $tcAry[1];
                    }else{
                        $favoriteList[$targetCode] = $targetCode;
                    }
                }
            }
        }

        return $favoriteList;
    }

    /**
     * @param $arrayCorpCd
     * @param $favoriteList
     * @return integer
     */
    static function getFavoriteJobCount($arrayCorpCd, $favoriteList){
        $favoriteJobCount = 0;

        if(!($arrayCorpCd && count($arrayCorpCd)>0)) {
            return $favoriteJobCount;
        }

        $favoriteCookieList = $favoriteList;

        if(!$favoriteCookieList or count($favoriteCookieList) == 0){
            return $favoriteJobCount;
        }

        $fEntJobSearchCriteria = new FEntJobSearchCriteria();

        $arrayJobNo = array();
        foreach ($favoriteCookieList as $jobNo => $timestamp) {
            $arrayJobNo[] = $jobNo;
        }
        $fEntJobSearchCriteria->jobNos = implode('[]', $arrayJobNo);

        $fEntJobSearchCriteria->corpCode = implode('[]', $arrayCorpCd);
        $fEntJobSearchCriteria->pageNo = TenrikuConst::$DEFAULT_PAGE_NO;
        $fEntJobSearchCriteria->pageLimit = TenrikuConst::$DEFAULT_PAGE_LIMIT;
        $fEntJobSearchCriteria->searchType = TenrikuConst::$DEFAULT_SEARCH_TYPE;
        $fEntJobSearchCriteria->isMatchFullJobNo = !(env('VITE_PREFIX_MATCH')); //仕事番号分割フラグとtrue/falseを反転させる

        $msgL1 = new MsgL1GetOnlyJobCount();
        $msgL1->fEntJobSearchCriteria = $fEntJobSearchCriteria;
        $l1 = new L1GetOnlyJobCount();
        $l1->execute($msgL1);
        if($msgL1->_c != JsonResponse::HTTP_OK){
            return $favoriteJobCount;
        }
        $favoriteJobCount = $msgL1->totalCnt;

        return $favoriteJobCount;
    }

    /**
     * @param $favoriteList
     * @param $jobManagerCode
     * @return bool
     */
    static function getFavoriteStatus($favoriteList, $jobManagerCode){

        $isFavorite = false;
        if(!is_array($favoriteList) || count($favoriteList) == 0 || !isset($jobManagerCode)){
            return $isFavorite;
        }

        // お仕事Noの一致チェックする
        if ($favoriteList) {

            $targetCode = $jobManagerCode;

            foreach ($favoriteList as $favoriteCode => $timestamp) {
                if(env('VITE_PREFIX_MATCH')) { //前方一致
                    if (str_starts_with($targetCode, $favoriteCode)) { //対象の求人の仕事番号がcookie保存済みの(末尾区切り文字までの)仕事番号から始まるか
                        $isFavorite = true;
                        break;
                    }
                }
                else {
                    if ($favoriteCode == $targetCode) {
                        $isFavorite = true;
                        break;
                    }
                }
            }
        }

        return $isFavorite;
    }
}
