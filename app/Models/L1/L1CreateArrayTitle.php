<?php
namespace App\Models\L1;

use App\Models\Constant\Cst;
use App\Models\L1\Msg\MsgL1CreateArrayTitle;
use App\Models\L2\L2CreateFEntJobSearchRequestData;
use App\Models\L2\Msg\MsgL2CreateFEntJobSearchRequestData;
use Illuminate\Http\JsonResponse;

/**
 * Class L1CreateArrayTitle
 * @package App\Models\L1
 */
class L1CreateArrayTitle extends L1Abstract
{
    function __construct(){
        parent::__construct();
    }

    /**
     * @param MsgL1CreateArrayTitle $msg
     * @throws \Exception
     */
    protected function exec(MsgL1CreateArrayTitle $msg)
    {
        //初期化
        $msg->_c = null;
        $msg->_m = null;
        $msg->arrayTitle = array();

        if($msg->fEntJobSearchCriteria === null){
            $msg->_c = Cst::INPUT_ERROR;
            $msg->_m = "検索条件が取得できませんでした。";
            return;
        }

        if($msg->fEntJobMasters === null){
            $msg->_c = Cst::INPUT_ERROR;
            $msg->_m = "マスタ一覧が取得できませんでした。";
            return;
        }

        if($msg->fEntSearchAxisData === null || (!$msg->fEntSearchAxisData->isSuccessGetAxis)){
            $msg->_c = Cst::INPUT_ERROR;
            $msg->_m = "検索軸が取得できませんでした。";
            return;
        }

        $fEntJobSearchCriteria = $msg->fEntJobSearchCriteria;
        $fEntJobMasters = $msg->fEntJobMasters;
        $fEntSearchAxisData = $msg->fEntSearchAxisData;
        
        $customAreaMaster = array();
        $customJobMaster = array();

        $arrayTitle = array();
        $isDuplicate = false;

        if($fEntSearchAxisData->isCustomArea) {

            $areaAxisType = null;

            //表示優先順はpref > area > city としておく
            if($fEntSearchAxisData->fEntSearchAxis->city) {
                $areaAxisType = 'city';
            }
            if($fEntSearchAxisData->fEntSearchAxis->area) {
                $areaAxisType = 'area';
            }
            if($fEntSearchAxisData->fEntSearchAxis->pref) {
                $areaAxisType = 'pref';
            }

            if($areaAxisType) {
                foreach($fEntSearchAxisData->fEntSearchAxis->$areaAxisType As $index => $customAxis) {
                    $customAreaMaster[$customAxis->value] = $customAxis;
                }
            }

            if($customAreaMaster) {
                foreach($customAreaMaster As $key => $kbnItems) {
                    $isSearchedParent = false;

                    if($kbnItems->type??null) {
                        switch($kbnItems->type) {
                            case 'bc':
                                if($fEntJobSearchCriteria->areaCodes) {
                                    if(strpos($fEntJobSearchCriteria->areaCodes, $key) !== false) {
                                        if(isset($arrayTitle['area'])) {
                                            $isDuplicate = true; //同一表示項目での重複のため、タイトル表示をしない
                                            $arrayTitle = array();
                                            break 2;
                                        }
                                        $arrayTitle['area'] = $kbnItems->name;
                                        $isSearchedParent = true;
                                    }
                                }
                                break;

                            case 'area':
                                if($fEntJobSearchCriteria->prefCodes) {
                                    if(strpos($fEntJobSearchCriteria->prefCodes, $key) !== false) {
                                        if(isset($arrayTitle['area'])) {
                                            $isDuplicate = true;
                                            $arrayTitle = array();
                                            break 2;
                                        }
                                        $arrayTitle['area'] = $kbnItems->name;
                                        $isSearchedParent = true;
                                    }
                                }
                                break;

                            case 'city':
                                if($fEntJobSearchCriteria->cityCodes) {
                                    if(strpos($fEntJobSearchCriteria->cityCodes, $key) !== false) {
                                        if(isset($arrayTitle['area'])) {
                                            $isDuplicate = true;
                                            $arrayTitle = array();
                                            break 2;
                                        }
                                        $arrayTitle['area'] = $kbnItems->name;
                                        $isSearchedParent = true;
                                    }
                                }
                                break;

                            default:
                                break;
                        }
                    }

                    if($kbnItems->children) {
                        foreach($kbnItems->children As $children) {

                            if($children->type??null) {
                                switch($children->type) {
                                    case 'bc':
                                        if($fEntJobSearchCriteria->areaCodes) {
                                            if((strpos($fEntJobSearchCriteria->areaCodes, $children->value) !== false) && $isSearchedParent == false) {
                                                if(isset($arrayTitle['pref'])) {
                                                    $isDuplicate = true;
                                                    $arrayTitle = array();
                                                    break 3;
                                                }
                                                $arrayTitle['pref'] = $children->name;
                                            }
                                        }
                                        break;

                                    case 'area':
                                        if($fEntJobSearchCriteria->prefCodes) {
                                            if((strpos($fEntJobSearchCriteria->prefCodes, $children->value) !== false) && $isSearchedParent == false) {
                                                if(isset($arrayTitle['pref'])) {
                                                    $isDuplicate = true;
                                                    $arrayTitle = array();
                                                    break 3;
                                                }
                                                $arrayTitle['pref'] = $children->name;
                                            }
                                        }
                                        break;

                                    case 'city':
                                        if($fEntJobSearchCriteria->cityCodes) {
                                            if((strpos($fEntJobSearchCriteria->cityCodes, $children->value) !== false) && $isSearchedParent == false) {
                                                if(isset($arrayTitle['pref'])) {
                                                    $isDuplicate = true;
                                                    $arrayTitle = array();
                                                    break 3;
                                                }
                                                $arrayTitle['pref'] = $children->name;
                                            }
                                        }
                                        break;

                                    default:
                                        break;
                                }
                            }
                        }
                    }
                }
            }

            if($isDuplicate) {
                //初期化した配列を返す
                $msg->arrayTitle = $arrayTitle;
                $msg->_c = JsonResponse::HTTP_OK;
                $msg->_m = "「検索結果」のタイトルを生成しました。";
                return;
            }
        }

        if($fEntSearchAxisData->isCustomJob) {

            $jobAxisType = null;

            //表示優先順はjobbc > job としておく
            if($fEntSearchAxisData->fEntSearchAxis->job) {
                $jobAxisType = 'job';
            }
            if($fEntSearchAxisData->fEntSearchAxis->jobbc) {
                $jobAxisType = 'jobbc';
            }

            if($jobAxisType) {
                foreach($fEntSearchAxisData->fEntSearchAxis->$jobAxisType As $index => $customAxis) {
                    $customJobMaster[$customAxis->value] = $customAxis;
                }
            }

            if($customJobMaster) {
                foreach($customJobMaster As $key => $kbnItems) {
                    $isSearchedParent = false;

                    if($kbnItems->type??null) {
                        switch($kbnItems->type) {
                            case 'jobbc':
                                if($fEntJobSearchCriteria->jobGroupCodes) {
                                    if(strpos($fEntJobSearchCriteria->jobGroupCodes, $key) !== false) {
                                        if(isset($arrayTitle['jobbc'])) {
                                            $isDuplicate = true;
                                            $arrayTitle = array();
                                            break 2;
                                        }
                                        $arrayTitle['jobbc'] = $kbnItems->name;
                                        $isSearchedParent = true;
                                    }
                                }
                                break;

                            case 'job':
                                if($fEntJobSearchCriteria->jobCodes) {
                                    if(strpos($fEntJobSearchCriteria->jobCodes, $key) !== false) {
                                        if(isset($arrayTitle['jobbc'])) {
                                            $isDuplicate = true;
                                            $arrayTitle = array();
                                            break 2;
                                        }
                                        $arrayTitle['jobbc'] = $kbnItems->name;
                                        $isSearchedParent = true;
                                    }
                                }
                                break;

                            case 'kw':
                                if($fEntJobSearchCriteria->keyword) {
                                    if(strpos($fEntJobSearchCriteria->keyword, $key) !== false) {
                                        if(isset($arrayTitle['jobbc'])) {
                                            $isDuplicate = true;
                                            $arrayTitle = array();
                                            break 2;
                                        }
                                        $arrayTitle['jobbc'] = $kbnItems->name;
                                        $isSearchedParent = true;
                                    }
                                }
                                break;

                            default:
                                break;
                        }
                    }

                    if($kbnItems->children) {
                        foreach($kbnItems->children As $children) {

                            if($children->type??null) {
                                switch($children->type) {
                                    case 'jobbc':
                                        if($fEntJobSearchCriteria->jobGroupCodes) {
                                            if((strpos($fEntJobSearchCriteria->jobGroupCodes, $children->value) !== false) && $isSearchedParent == false) {
                                                if(isset($arrayTitle['job'])) {
                                                    $isDuplicate = true;
                                                    $arrayTitle = array();
                                                    break 3;
                                                }
                                                $arrayTitle['job'] = $children->name;
                                            }
                                        }
                                        break;

                                    case 'job':
                                        if($fEntJobSearchCriteria->jobCodes) {
                                            if((strpos($fEntJobSearchCriteria->jobCodes, $children->value) !== false) && $isSearchedParent == false) {
                                                if(isset($arrayTitle['job'])) {
                                                    $isDuplicate = true;
                                                    $arrayTitle = array();
                                                    break 3;
                                                }
                                                $arrayTitle['job'] = $children->name;
                                            }
                                        }
                                        break;

                                    case 'kw':
                                        if($fEntJobSearchCriteria->keyword) {
                                            if((strpos($fEntJobSearchCriteria->keyword, $children->value) !== false) && $isSearchedParent == false) {
                                                if(isset($arrayTitle['job'])) {
                                                    $isDuplicate = true;
                                                    $arrayTitle = array();
                                                    break 3;
                                                }
                                                $arrayTitle['job'] = $children->name;
                                            }
                                        }
                                        break;

                                    default:
                                        break;
                                }
                            }
                        }
                    }
                }
            }

            if($isDuplicate) {
                //初期化した配列を返す
                $msg->arrayTitle = $arrayTitle;
                $msg->_c = JsonResponse::HTTP_OK;
                $msg->_m = "「検索結果」のタイトルを生成しました";
                return;
            }
        }

        //配列要素に分解する
        $msgL2CreateFEntJobSearchRequestData = new MsgL2CreateFEntJobSearchRequestData();
        $msgL2CreateFEntJobSearchRequestData->fEntJobSearchCriteria = $fEntJobSearchCriteria;
        $l2CreateFEntJobSearchRequestData = new L2CreateFEntJobSearchRequestData();
        $l2CreateFEntJobSearchRequestData->execute($msgL2CreateFEntJobSearchRequestData);
        if ($msgL2CreateFEntJobSearchRequestData->isSuccess === false) {
            $msg->_c = $msgL2CreateFEntJobSearchRequestData->rtnCd;
            $msg->_m = $msgL2CreateFEntJobSearchRequestData->rtnMessage;
            return;
        }
        $fEntJobSearchRequestData = $msgL2CreateFEntJobSearchRequestData->fEntJobSearchRequestData;

        if(!($fEntSearchAxisData->isCustomArea)) {
            if($fEntJobSearchRequestData->area and count($fEntJobSearchRequestData->area)>0){
                if(count($fEntJobSearchRequestData->area) === 1) {
                    foreach($fEntJobMasters->areaMst as $fEntMst){
                        if($fEntMst->value == $fEntJobSearchRequestData->area[0]){
                            $arrayTitle['area'] = $fEntMst->name;
                        }
                    }
                }
                else {
                    //同一検索パラメータ内の重複のためタイトル生成をしない
                    $arrayTitle = array();
                    $msg->arrayTitle = $arrayTitle;
                    $msg->_c = JsonResponse::HTTP_OK;
                    $msg->_m = "「検索結果」のタイトルを生成しました。";
                    return;
                }
            }
            if($fEntJobSearchRequestData->pref and count($fEntJobSearchRequestData->pref)>0){
                if(count($fEntJobSearchRequestData->pref) === 1) {
                    foreach ($fEntJobMasters->prefMst as $fEntMst) {
                        if ($fEntMst->value == $fEntJobSearchRequestData->pref[0]) {
                            //親要素が検索されている場合はタイトルに追加しない
                            if ($fEntJobSearchRequestData->area and count($fEntJobSearchRequestData->area) === 1) {
                                if ($fEntMst->parent == $fEntJobSearchRequestData->area[0]) {
                                    continue;
                                }
                            }
                            $arrayTitle['pref'] = $fEntMst->name;
                        }
                    }
                }
                else {
                    //todo 親要素との一致確認処理は二次検索ボックスでチェックがついているもの全てが検索URLおよび検索条件に含まれることによって生じる処理のため削除したい

                    if(!($fEntJobSearchRequestData->area)) { //上位要素が検索条件に含まれていない場合
                        //同一検索パラメータ内の重複のためタイトル生成をしない
                        $arrayTitle = array();
                        $msg->arrayTitle = $arrayTitle;
                        $msg->_c = JsonResponse::HTTP_OK;
                        $msg->_m = "「検索結果」のタイトルを生成しました。";
                        return;
                    }

                    if (count($fEntJobSearchRequestData->area) === 1) { //検索条件の上位要素が1種類のみの場合(上位要素が複数の場合は既にreturn済のため考慮しない)

                        $relationalPrefCodes = array();
                        $arrayPrefMaster = array();

                        foreach ($fEntJobMasters->prefMst as $fEntMst) {
                            $arrayPrefMaster[$fEntMst->value] = $fEntMst->name;
                            if($fEntMst->parent == $fEntJobSearchRequestData->area[0]) {
                                $relationalPrefCodes[] = $fEntMst->value;
                            }
                        }

                        $diffPrefCodes = array_diff($fEntJobSearchRequestData->pref , $relationalPrefCodes);

                        if(count($diffPrefCodes) > 0) {
                            if(count($diffPrefCodes) === 1) {
                                foreach($diffPrefCodes As $prefCode) {
                                    $arrayTitle['pref'] = $arrayPrefMaster[$prefCode];
                                }
                            }
                            else {
                                //同一検索パラメータ内の重複のためタイトル生成をしない
                                $arrayTitle = array();
                                $msg->arrayTitle = $arrayTitle;
                                $msg->_c = JsonResponse::HTTP_OK;
                                $msg->_m = "「検索結果」のタイトルを生成しました。";
                                return;
                            }
                        }
                    }
                }
            }

            if($fEntJobSearchRequestData->city and count($fEntJobSearchRequestData->city)>0){
                if(count($fEntJobSearchRequestData->city) === 1) {
                    foreach ($fEntJobMasters->cityMst as $fEntMst) {
                        if ($fEntMst->value == $fEntJobSearchRequestData->city[0]) {
                            //親要素が検索されている場合はタイトルに追加しない
                            if ($fEntJobSearchRequestData->pref and count($fEntJobSearchRequestData->pref) === 1) {
                                if ($fEntMst->parent == $fEntJobSearchRequestData->pref[0]) {
                                    continue;
                                }
                            }
                            $arrayTitle['city'] = $fEntMst->name;
                        }
                    }
                }
                else {
                    //todo 親要素との一致確認処理は二次検索ボックスでチェックがついているもの全てが検索URLおよび検索条件に含まれることによって生じる処理のため削除したい

                    if(!($fEntJobSearchRequestData->pref)) { //上位要素が検索条件に含まれていない場合
                        //同一検索パラメータ内の重複のためタイトル生成をしない
                        $arrayTitle = array();
                        $msg->arrayTitle = $arrayTitle;
                        $msg->_c = JsonResponse::HTTP_OK;
                        $msg->_m = "「検索結果」のタイトルを生成しました。";
                        return;
                    }

                    if (count($fEntJobSearchRequestData->pref) === 1) { //検索条件の上位要素が1種類のみの場合(上位要素が複数の場合は既にreturn済のため考慮しない)

                        $relationalCityCodes = array();
                        $arrayCityMaster = array();

                        foreach ($fEntJobMasters->cityMst as $fEntMst) {
                            $arrayCityMaster[$fEntMst->value] = $fEntMst->name;
                            if($fEntMst->parent == $fEntJobSearchRequestData->pref[0]) {
                                $relationalCityCodes[] = $fEntMst->value;
                            }
                        }

                        $diffCityCodes = array_diff($fEntJobSearchRequestData->city , $relationalCityCodes);

                        if(count($diffCityCodes) > 0) {
                            if(count($diffCityCodes) === 1) {
                                foreach($diffCityCodes As $cityCode) {
                                    $arrayTitle['city'] = $arrayCityMaster[$cityCode];
                                }
                            }
                            else {
                                //同一検索パラメータ内の重複のためタイトル生成をしない
                                $arrayTitle = array();
                                $msg->arrayTitle = $arrayTitle;
                                $msg->_c = JsonResponse::HTTP_OK;
                                $msg->_m = "「検索結果」のタイトルを生成しました。";
                                return;
                            }
                        }
                    }
                }
            }
        }

        if(!($fEntSearchAxisData->isCustomJob)) {
            if($fEntJobSearchRequestData->jobbc and count($fEntJobSearchRequestData->jobbc)>0){
                if(count($fEntJobSearchRequestData->jobbc)===1) {
                    foreach($fEntJobMasters->jobCategoryGroupMst as $fEntMst){
                        if($fEntMst->value == $fEntJobSearchRequestData->jobbc[0]){
                            $arrayTitle['jobbc'] = $fEntMst->name;
                        }
                    }
                }
                else {
                    //同一検索パラメータ内の重複のためタイトル生成をしない
                    $arrayTitle = array();
                    $msg->arrayTitle = $arrayTitle;
                    $msg->_c = JsonResponse::HTTP_OK;
                    $msg->_m = "「検索結果」のタイトルを生成しました。";
                    return;
                }
            }
            if($fEntJobSearchRequestData->job and count($fEntJobSearchRequestData->job)>0){
                if(count($fEntJobSearchRequestData->job)===1) {
                    foreach($fEntJobMasters->jobCategoryMst as $fEntMst){
                        if($fEntMst->value == $fEntJobSearchRequestData->job[0]){
                            //親要素が検索されている場合はタイトルに追加しない
                            if($fEntJobSearchRequestData->jobbc and count($fEntJobSearchRequestData->jobbc) === 1) {
                                if($fEntMst->parent == $fEntJobSearchRequestData->jobbc[0]) {
                                    continue;
                                }
                            }
                            $arrayTitle['job'] = $fEntMst->name;
                        }
                    }
                }
                else {
                    //todo 親要素との一致確認処理は二次検索ボックスでチェックがついているもの全てが検索URLおよび検索条件に含まれることによって生じる処理のため削除したい

                    if(!($fEntJobSearchRequestData->jobbc)) { //上位要素が検索条件に含まれていない場合
                        //同一検索パラメータ内の重複のためタイトル生成をしない
                        $arrayTitle = array();
                        $msg->arrayTitle = $arrayTitle;
                        $msg->_c = JsonResponse::HTTP_OK;
                        $msg->_m = "「検索結果」のタイトルを生成しました。";
                        return;
                    }

                    if (count($fEntJobSearchRequestData->jobbc) === 1) { //検索条件の上位要素が1種類のみの場合(上位要素が複数の場合は既にreturn済のため考慮しない)

                        $relationalJobCategoryCodes = array();
                        $arrayJobCategoryMaster = array();

                        foreach ($fEntJobMasters->jobCategoryMst as $fEntMst) {
                            $arrayJobCategoryMaster[$fEntMst->value] = $fEntMst->name;
                            if($fEntMst->parent == $fEntJobSearchRequestData->jobbc[0]) {
                                $relationalJobCategoryCodes[] = $fEntMst->value;
                            }
                        }

                        $diffJobCategoryCodes = array_diff($fEntJobSearchRequestData->job , $relationalJobCategoryCodes);

                        if(count($diffJobCategoryCodes) > 0) {
                            if(count($diffJobCategoryCodes) === 1) {
                                foreach($diffJobCategoryCodes As $jobCategoryCode) {
                                    $arrayTitle['job'] = $arrayJobCategoryMaster[$jobCategoryCode];
                                }
                            }
                            else {
                                //同一検索パラメータ内の重複のためタイトル生成をしない
                                $arrayTitle = array();
                                $msg->arrayTitle = $arrayTitle;
                                $msg->_c = JsonResponse::HTTP_OK;
                                $msg->_m = "「検索結果」のタイトルを生成しました。";
                                return;
                            }
                        }
                    }
                }
            }
        }

        // 雇用形態
        if($fEntJobSearchRequestData->koy and count($fEntJobSearchRequestData->koy)>0){
            if(count($fEntJobSearchRequestData->koy)===1) {
                foreach($fEntJobMasters->koyKeitaiMst as $fEntMst){
                    if($fEntMst->value == $fEntJobSearchRequestData->koy[0]){
                        $arrayTitle['koy'] = $fEntMst->name;
                    }
                }
            }
            else {
                //同一検索パラメータ内の重複のためタイトル生成をしない
                $arrayTitle = array();
                $msg->arrayTitle = $arrayTitle;
                $msg->_c = JsonResponse::HTTP_OK;
                $msg->_m = "「検索結果」のタイトルを生成しました。";
                return;
            }
        }
        // 特徴
        if($fEntJobSearchRequestData->tokucho and count($fEntJobSearchRequestData->tokucho)>0){
            if(count($fEntJobSearchRequestData->tokucho)===1) {
                foreach($fEntJobMasters->tokuchoMst as $fEntMst){
                    if($fEntMst->value == $fEntJobSearchRequestData->tokucho[0]){
                        $arrayTitle['tokucho'] = $fEntMst->name;
                    }
                }
            }
            else {
                //同一検索パラメータ内の重複のためタイトル生成をしない
                $arrayTitle = array();
                $msg->arrayTitle = $arrayTitle;
                $msg->_c = JsonResponse::HTTP_OK;
                $msg->_m = "「検索結果」のタイトルを生成しました。";
                return;
            }
        }

        if($fEntJobSearchRequestData->salaryClassCode) {
            $kyuyoKbnTitle = '';
            foreach($fEntJobMasters->salaryKbnMst as $fEntMst){
                if($fEntMst->value == $fEntJobSearchRequestData->salaryClassCode){
                    $kyuyoKbnTitle .= $fEntMst->name;
                    break;
                }
            }

            if($kyuyoKbnTitle) { //給与区分名称が存在する場合
                $kyuyoKingkTitle = '';
                if($fEntJobSearchRequestData->salaryClassCode != 99) { //「その他」の給与区分の場合、金額情報を生成しない
                    if($fEntJobSearchRequestData->salaryMin) {
                        $salaryMin = $fEntJobSearchRequestData->salaryMin;
                        $num = number_format($salaryMin);
                        $moneyStr = sprintf("%s",$num);
                        $kyuyoKingkTitle .= $moneyStr . '円以上';
                    }
                    if($fEntJobSearchRequestData->salaryMax) {
                        $salaryMax = $fEntJobSearchRequestData->salaryMax;
                        $num = number_format($salaryMax);
                        $moneyStr = sprintf("%s",$num);
                        $kyuyoKingkTitle .= $moneyStr . '円以下';
                    }
                }

                if($kyuyoKingkTitle) { //金額情報がある場合
                    $arrayTitle['kyuyo'] = $kyuyoKbnTitle . $kyuyoKingkTitle;
                }
                else {
                    $arrayTitle['kyuyo'] = '給与区分：' . $kyuyoKbnTitle;
                }
            }
        }

        //フリーワード
        if($fEntJobSearchRequestData->kw and count($fEntJobSearchRequestData->kw)>0){
            if(!($fEntSearchAxisData->isCustomJob)) {
                if(count($fEntJobSearchRequestData->kw)===1) {
                    $arrayTitle['kw'] = '「' . $fEntJobSearchRequestData->kw[0] . '」';
                }
                else {
                    //同一検索パラメータ内の重複のためタイトル生成をしない
                    $arrayTitle = array();
                    $msg->arrayTitle = $arrayTitle;
                    $msg->_c = JsonResponse::HTTP_OK;
                    $msg->_m = "「検索結果」のタイトルを生成しました。";
                    return;
                }

            }
            else { //独自職種の場合
                $arrayCustomJobKeyword = array();
                foreach($customJobMaster As $key => $kbnItems) {
                    if($kbnItems->children??null) {
                        foreach($kbnItems->children As $children) {
                            if((($children->type??null) == 'kw') && ($children->value??null)) {
                                $arrayCustomJobKeyword[] = $children->value;
                            }
                        }
                    }
                }

                $diffKeywords = array_diff($fEntJobSearchRequestData->kw , $arrayCustomJobKeyword);

                if(count($diffKeywords) > 0) {
                    if(count($diffKeywords) === 1) {
                        foreach($diffKeywords As $keyword) {
                            $arrayTitle['kw'] = '「' . $keyword . '」';
                        }
                    }
                    else {
                        //同一検索パラメータ内の重複のためタイトル生成をしない
                        $arrayTitle = array();
                        $msg->arrayTitle = $arrayTitle;
                        $msg->_c = JsonResponse::HTTP_OK;
                        $msg->_m = "「検索結果」のタイトルを生成しました。";
                        return;
                    }
                }
            }
        }

        $msg->arrayTitle = $arrayTitle;
        $msg->_c = JsonResponse::HTTP_OK;
        $msg->_m = "タイトルの取得に成功しました。";

    }

}
