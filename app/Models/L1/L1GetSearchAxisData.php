<?php

namespace App\Models\L1;

use App\Core\Logger\Logger;
use App\Models\Constant\Cst;
use App\Models\FEnt\FEntSearchAxis;
use App\Models\FEnt\FEntSearchAxisKbn;
use App\Models\FEnt\FEntSearchAxisData;
use App\Models\L1\Msg\MsgL1GetSearchAxisData;
use Symfony\Component\HttpFoundation\Response;
use App\Util\UtilHttpRequest;

/**
 * Class L1GetJobDetail
 * @package App\Models\L1
 */
class L1GetSearchAxisData extends L1Abstract
{

    /**
     * L1GetSearchAxisData constructor.
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * @param MsgL1GetSearchAxisData $msg
     * @throws \Exception
     */
    protected function exec(MsgL1GetSearchAxisData $msg)
    {
        // 初期化
        $msg->_m = null;
        $msg->_c = null;

        $fEntSearchAxisData = new FEntSearchAxisData();
        $msg->fEntSearchAxisData = $fEntSearchAxisData;

        $frontendSettings = $msg->frontendSettings;

        if(!$frontendSettings) {
            $fEntSearchAxisData->isSuccessGetAxis = false;

            $msg->_c = Cst::OUTPUT_ERROR;
            $msg->_m = '企業設定情報に不備があります。';
            $msg->fEntSearchAxisData = $fEntSearchAxisData;
            return;
        }

        //必須検索軸情報の取得
        $arrayConfigRequiredAxis = $frontendSettings['searchAxisRequiredList'];

        $arrayRequiredAxis = array();

        foreach($arrayConfigRequiredAxis As $configRequiredAxis) {

            //カスタム検索軸の場合はAPIからの取得をスキップする
            if($configRequiredAxis === 'area' || $configRequiredAxis === 'pref' || $configRequiredAxis === 'city') {
                if($frontendSettings['isCustomArea']) {
                    continue;
                }
            }
            if($configRequiredAxis === 'jobbc' || $configRequiredAxis === 'job') {
                if($frontendSettings['isCustomJob']) {
                    continue;
                }
            }

            $arrayRequiredAxis[] = $configRequiredAxis;
        }


        //APIからの検索軸取得
        $searchAxisApiResult = array();
        $token = UtilHttpRequest::getToken();

        foreach($arrayRequiredAxis As $requiredAxis) {

            // endpointの指定
            $endpoint = env('API_BASE_URL') . "/schema/search/" . $requiredAxis;
            //---CURL Request
            $result = UtilHttpRequest::cUrlRequest("GET", $endpoint, $token);

            //JSONが存在しない場合、あるいはresponseのcode,messageが存在しない場合は$resultがfalseで返ってくる
            if(!$result) {
                Logger::errorTrace('Error API connect to:', [$endpoint]);
                $fEntSearchAxisData->fEntSearchAxis = $requiredAxis;
                $fEntSearchAxisData->isSuccessGetAxis = false;
                $fEntSearchAxisData->isCustomSearch = false;

                $msg->_c = Cst::OUTPUT_ERROR;
                $msg->_m = '検索軸データに不備があります。axis_name=' . $requiredAxis;
                $msg->fEntSearchAxisData = $fEntSearchAxisData;
                return;
            }

            $ary = json_decode($result);

            if($ary->code != Response::HTTP_OK) {

                $fEntSearchAxisData->fEntSearchAxis = $requiredAxis;
                $fEntSearchAxisData->isSuccessGetAxis = false;
                $fEntSearchAxisData->isCustomSearch = false;

                $msg->_c = Cst::OUTPUT_ERROR;
                $msg->_m = '検索軸データに不備があります。axis_name=' . $requiredAxis;
                $msg->fEntSearchAxisData = $fEntSearchAxisData;
                return;
            }

            $searchAxisApiResult[$requiredAxis] = ($ary->data->$requiredAxis) ?? array();
        }

        $arraySearchAxis = array();
        $fEntSearchAxis = new FEntSearchAxis();

        //一時格納用配列の初期化処理
        foreach($fEntSearchAxis as $key => $value) {
            $arraySearchAxis[$key] = $value;
        }

        $koyParams = array(
            '1' => 'rs',
            '2' => 'ks',
            '3' => 'ap',
            '4' => 'hs',
            '5' => 'sy',
            '6' => 'th',
            '7' => 'js',
            '8' => 'is',
            '99' => 'ss',
        );

        //APIからの取得検索軸の格納 start

        if(count($searchAxisApiResult)>0 && count($arrayRequiredAxis)>0) {

            foreach($arrayRequiredAxis As $requiredAxis) {
                foreach ($searchAxisApiResult as $axisName => $arrayAxisObject) {

                        if ($axisName !== $requiredAxis) {
                            continue;
                        }

                        switch ($axisName) {
                            case ('city') :

                                $parent = array_column($arrayAxisObject, 'parent');
                                $value = array_column($arrayAxisObject, 'value');
                                array_multisort($parent, SORT_ASC, $value, SORT_ASC, $arrayAxisObject);

                                foreach ($arrayAxisObject as $index => $objectItems) {

                                    $fEntSearchAxisKbn = new FEntSearchAxisKbn();

                                    $fEntSearchAxisKbn->type = 'city';
                                    $fEntSearchAxisKbn->name = $objectItems->name;
                                    if ($objectItems->parent && $objectItems->value) {
                                        $fEntSearchAxisKbn->value = $objectItems->parent . $objectItems->value;
                                    } else {
                                        $arraySearchAxis[$axisName] = null;
                                        break;
                                    }
                                    $fEntSearchAxisKbn->cnt = $objectItems->cnt;
                                    $fEntSearchAxisKbn->parent = $objectItems->parent;

                                    $arraySearchAxis[$axisName][] = $fEntSearchAxisKbn;
                                }
                                break;

                            case('pref') :

                                $value = array_column($arrayAxisObject, 'value');
                                array_multisort($value, SORT_ASC, $arrayAxisObject);

                                //子要素(市区町村)の配列をあらかじめ作成
                                $tmpArrayChildren = array();
                                if($searchAxisApiResult['city']??null && count($searchAxisApiResult['city'])>0) {

                                    $parent = array_column($searchAxisApiResult['city'], 'parent');
                                    $value = array_column($searchAxisApiResult['city'], 'value');
                                    array_multisort($parent, SORT_ASC, $value, SORT_ASC, $searchAxisApiResult['city']);

                                    foreach($searchAxisApiResult['city'] As $childrenObject) {
                                        if (($childrenObject->parent??null)) {
                                            $tmpArrayChildren[$childrenObject->parent][] = $childrenObject;
                                        }
                                    }
                                }

                                foreach ($arrayAxisObject as $index => $objectItems) {

                                    $fEntSearchAxisKbn = new FEntSearchAxisKbn();

                                    $fEntSearchAxisKbn->type = 'area';
                                    $fEntSearchAxisKbn->name = $objectItems->name;
                                    $fEntSearchAxisKbn->value = $objectItems->value;
                                    $fEntSearchAxisKbn->cnt = $objectItems->cnt;
                                    $fEntSearchAxisKbn->parent = $objectItems->parent;

                                    if($objectItems->children ?? null) {
                                        $arrayChildren = array();
                                        foreach ($objectItems->children as $childrenObject) {

                                            $fEntSearchAxisChildrenKbn = new FEntSearchAxisKbn();

                                            $fEntSearchAxisChildrenKbn->type = 'city';
                                            $fEntSearchAxisChildrenKbn->name = $childrenObject->name;
                                            if ($childrenObject->parent && $childrenObject->value) {
                                                $fEntSearchAxisChildrenKbn->value = $childrenObject->parent . $childrenObject->value;
                                            } else {
                                                $arraySearchAxis[$axisName] = null;
                                                break 2;
                                            }
                                            $fEntSearchAxisChildrenKbn->cnt = $childrenObject->cnt;
                                            $fEntSearchAxisChildrenKbn->parent = $childrenObject->parent;
                                            $arrayChildren[] = $fEntSearchAxisChildrenKbn;
                                        }
                                        $fEntSearchAxisKbn->children = $arrayChildren;
                                    }
                                    else {
                                        if(count($tmpArrayChildren)>0) {
                                            $arrayChildren = array();
                                            foreach($tmpArrayChildren As $parentValue => $childrenObject) {
                                                if((int)$parentValue === (int)$objectItems->value) {
                                                    foreach($childrenObject As $children) {
                                                        $fEntSearchAxisChildrenKbn = new FEntSearchAxisKbn();
                                                        $fEntSearchAxisChildrenKbn->type = 'city';
                                                        $fEntSearchAxisChildrenKbn->name = $children->name;
                                                        if ($children->parent && $children->value) {
                                                            $fEntSearchAxisChildrenKbn->value = $children->parent . $children->value;
                                                        } else {
                                                            $arraySearchAxis[$axisName] = null;
                                                            break 3;
                                                        }
                                                        $fEntSearchAxisChildrenKbn->cnt = $children->cnt;
                                                        $fEntSearchAxisChildrenKbn->parent = $children->parent;
                                                        $arrayChildren[] = $fEntSearchAxisChildrenKbn;
                                                    }
                                                }
                                            }
                                            $fEntSearchAxisKbn->children = $arrayChildren;
                                        }
                                    }

                                    $arraySearchAxis[$axisName][] = $fEntSearchAxisKbn;
                                }
                                break;

                            case('koy') :

                                $value = array_column($arrayAxisObject, 'value');
                                array_multisort($value, SORT_ASC, $arrayAxisObject);

                                foreach ($arrayAxisObject as $index => $objectItems) {

                                    $fEntSearchAxisKbn = new FEntSearchAxisKbn();

                                    $fEntSearchAxisKbn->type = 'koy';
                                    $fEntSearchAxisKbn->name = $objectItems->name;
                                    $fEntSearchAxisKbn->value = $koyParams[$objectItems->value];
                                    $fEntSearchAxisKbn->cnt = $objectItems->cnt;
                                    $fEntSearchAxisKbn->parent = $objectItems->parent ?? null;

                                    $arraySearchAxis[$axisName][$index] = $fEntSearchAxisKbn;
                                }
                                break;

                            default :

                                $value = array_column($arrayAxisObject, 'value');

                                if($axisName == 'job') {
                                    $parent = array_column($arrayAxisObject, 'parent');
                                    array_multisort($parent, SORT_ASC, $value, SORT_ASC, $arrayAxisObject);
                                }
                                else {
                                    array_multisort($value, SORT_ASC, $arrayAxisObject);
                                }

                                $tmpArrayChildren = array();

                                if($axisName == 'area') {
                                    //子要素(都道府県)の配列をあらかじめ作成
                                    if($searchAxisApiResult['pref']??null && count($searchAxisApiResult['pref'])>0) {

                                        $parent = array_column($searchAxisApiResult['pref'], 'parent');
                                        $value = array_column($searchAxisApiResult['pref'], 'value');
                                        array_multisort($parent, SORT_ASC, $value, SORT_ASC, $searchAxisApiResult['pref']);

                                        foreach($searchAxisApiResult['pref'] As $childrenObject) {
                                            if (($childrenObject->parent??null)) {
                                                $tmpArrayChildren[$childrenObject->parent][] = $childrenObject;
                                            }
                                        }
                                    }
                                }

                                if($axisName == 'jobbc') {
                                    //子要素(都道府県)の配列をあらかじめ作成
                                    if($searchAxisApiResult['job']??null && count($searchAxisApiResult['job'])>0) {

                                        $parent = array_column($searchAxisApiResult['job'], 'parent');
                                        $value = array_column($searchAxisApiResult['job'], 'value');
                                        array_multisort($parent, SORT_ASC, $value, SORT_ASC, $searchAxisApiResult['job']);

                                        foreach($searchAxisApiResult['job'] As $childrenObject) {
                                            if (($childrenObject->parent??null)) {
                                                $tmpArrayChildren[$childrenObject->parent][] = $childrenObject;
                                            }
                                        }
                                    }
                                }

                                foreach ($arrayAxisObject as $index => $objectItems) {

                                    $fEntSearchAxisKbn = new FEntSearchAxisKbn();

                                    if($axisName == 'area') {
                                        $fEntSearchAxisKbn->type = 'bc';
                                    }
                                    else {
                                        $fEntSearchAxisKbn->type = $axisName;
                                    }
                                    $fEntSearchAxisKbn->name = $objectItems->name;
                                    $fEntSearchAxisKbn->value = $objectItems->value;
                                    $fEntSearchAxisKbn->cnt = $objectItems->cnt;
                                    $fEntSearchAxisKbn->parent = $objectItems->parent ?? null;

                                    if ($objectItems->children ?? null) {
                                        $arrayChildren = array();
                                        foreach ($objectItems->children as $childrenObject) {

                                            $fEntSearchAxisChildrenKbn = new FEntSearchAxisKbn();

                                            if($axisName == 'jobbc') {
                                                $fEntSearchAxisChildrenKbn->type = 'job';
                                            }
                                            elseif($axisName == 'area') {
                                                $fEntSearchAxisChildrenKbn->type = 'area'; //都道府県検索用のtype
                                            }
                                            else {
                                                $fEntSearchAxisKbn->type = $axisName;
                                            }
                                            $fEntSearchAxisChildrenKbn->name = $childrenObject->name;
                                            $fEntSearchAxisChildrenKbn->value = $childrenObject->value;
                                            $fEntSearchAxisChildrenKbn->cnt = $childrenObject->cnt;
                                            $fEntSearchAxisChildrenKbn->parent = $childrenObject->parent;
                                            $arrayChildren[] = $fEntSearchAxisChildrenKbn;
                                        }
                                        $fEntSearchAxisKbn->children = $arrayChildren;
                                    }
                                    else {
                                        if(count($tmpArrayChildren)>0) {

                                            $arrayChildren = array();
                                            foreach($tmpArrayChildren As $parentValue => $childrenObject) {
                                                if((int)$parentValue === (int)$objectItems->value) {
                                                    foreach($childrenObject As $children) {
                                                        $fEntSearchAxisChildrenKbn = new FEntSearchAxisKbn();
                                                        if($axisName == 'jobbc') {
                                                        $fEntSearchAxisChildrenKbn->type = 'job';
                                                        }
                                                        elseif($axisName == 'area') {
                                                        $fEntSearchAxisChildrenKbn->type = 'area'; //都道府県検索用のtype
                                                        }
                                                        else {
                                                            $fEntSearchAxisKbn->type = $axisName;
                                                        }
                                                        $fEntSearchAxisChildrenKbn->name = $children->name;
                                                        $fEntSearchAxisChildrenKbn->value = $children->value;
                                                        $fEntSearchAxisChildrenKbn->cnt = $children->cnt;
                                                        $fEntSearchAxisChildrenKbn->parent = $children->parent;
                                                        $arrayChildren[] = $fEntSearchAxisChildrenKbn;
                                                    }
                                                }
                                            }
                                            $fEntSearchAxisKbn->children = $arrayChildren;
                                        }
                                    }
                                    $arraySearchAxis[$axisName][$index] = $fEntSearchAxisKbn;
                                }
                                break;
                        }

                        //APIから取得する必須検索軸の判定
                        if($arraySearchAxis[$axisName] === null && (count($arrayAxisObject) > 0)) {
                            $fEntSearchAxisData->fEntSearchAxis = $fEntSearchAxis;
                            $fEntSearchAxisData->isSuccessGetAxis = false;
                            $fEntSearchAxisData->isCustomSearch = false;

                            $msg->_c = Cst::OUTPUT_ERROR;
                            $msg->_m = '検索軸データに不備があります。axis_name=' . $axisName;
                            $msg->fEntSearchAxisData = $fEntSearchAxisData;
                            return;
                        }
                    }
            }
        }
        //APIからの取得検索軸の格納 end

        //カスタム検索軸の格納　start

        $isCustomSearch = false;
        $isCustomArea = false;
        $isCustomJob = false;

        //APIから取得済みの検索軸は判定から除外する
        $arrayCustomRequiredAxis = array_diff($arrayConfigRequiredAxis, $arrayRequiredAxis);

        if(count($arrayCustomRequiredAxis)>0) {
            foreach($arrayCustomRequiredAxis As $customRequiredAxis) {

                if($customRequiredAxis !== 'area' && $customRequiredAxis !== 'pref' && $customRequiredAxis !== 'city' &&
                    $customRequiredAxis !== 'jobbc' && $customRequiredAxis !== 'job')
                {
                    continue;
                }

                $customSectionsList = array();
                $axisType = null;

                //独自エリア判定
                if($customRequiredAxis === 'area' || $customRequiredAxis === 'pref' || $customRequiredAxis === 'city') {
                    if($frontendSettings['isCustomArea']) {

                        $customAreaSections = $frontendSettings['customAreaSections']??null;

                        if($customAreaSections && count($customAreaSections)>0) {

                            foreach($customAreaSections As $customArea) {
                                $axisType = $customArea['type']??null;

                                if(($axisType !== 'area' && $axisType !== 'pref' && $axisType !== 'city')) {
                                    $fEntSearchAxisData->fEntSearchAxis = $fEntSearchAxis;
                                    $fEntSearchAxisData->isSuccessGetAxis = false;
                                    $fEntSearchAxisData->isCustomSearch = true;
                                    $fEntSearchAxisData->isCustomArea = true;

                                    $msg->_c = Cst::OUTPUT_ERROR;
                                    $msg->_m = 'カスタムエリア検索軸データのTypeに不備があります。';
                                    $msg->fEntSearchAxisData = $fEntSearchAxisData;
                                    return;
                                }
                                $customSectionsList[$axisType] = $customArea['list']??null;
                            }
                        }
                        $isCustomSearch = true;
                        $isCustomArea = true;
                    }
                }
                //独自職種判定
                if($customRequiredAxis === 'jobbc' || $customRequiredAxis === 'job') {
                    if($frontendSettings['isCustomJob']) {

                        $customJobSections = $frontendSettings['customJobSections']??null;

                        if($customJobSections && count($customJobSections)>0) {

                            foreach($customJobSections As $customJob) {
                                $axisType = $customJob['type']??null;

                                if(($axisType !== 'jobbc' && $axisType !== 'job')) {
                                    $fEntSearchAxisData->fEntSearchAxis = $fEntSearchAxis;
                                    $fEntSearchAxisData->isSuccessGetAxis = false;
                                    $fEntSearchAxisData->isCustomSearch = true;
                                    $fEntSearchAxisData->isCustomJob = true;

                                    $msg->_c = Cst::OUTPUT_ERROR;
                                    $msg->_m = 'カスタム職種検索軸データのTypeに不備があります。';
                                    $msg->fEntSearchAxisData = $fEntSearchAxisData;
                                    return;
                                }
                                $customSectionsList[$axisType] = $customJob['list']??null;
                            }
                        }
                        $isCustomSearch = true;
                        $isCustomJob = true;
                    }
                }

                //格納処理
                foreach($customSectionsList As $customAxisName => $customSections) {
                    if($customSections && count($customSections)>0) {
                        foreach($customSections As $index => $axisItems) {

                            if(!((isset($axisItems['type'])&&$axisItems['type']) &&
                                (isset($axisItems['name'])&&$axisItems['name']) &&
                                (isset($axisItems['value'])&&$axisItems['value']))) {
                                //カスタム検索軸の情報が正常に取得できないためエラーを返す

                                $fEntSearchAxisData->fEntSearchAxis = $fEntSearchAxis;
                                $fEntSearchAxisData->isSuccessGetAxis = false;
                                $fEntSearchAxisData->isCustomSearch = true;

                                $msg->_c = Cst::OUTPUT_ERROR;
                                $msg->_m = 'カスタム検索軸データの親要素に不備があります。axis_name=' . $customAxisName;
                                $msg->fEntSearchAxisData = $fEntSearchAxisData;
                                return;
                            }

                            if($customAxisName !== 'city' && $customAxisName !== 'job') {
                                if(!(isset($axisItems['children'])&&$axisItems['children'])) {
                                    //子要素の値が必要だが取得できないためエラーを返す

                                    $fEntSearchAxisData->fEntSearchAxis = $fEntSearchAxis;
                                    $fEntSearchAxisData->isSuccessGetAxis = false;
                                    $fEntSearchAxisData->isCustomSearch = true;

                                    $msg->_c = Cst::OUTPUT_ERROR;
                                    $msg->_m = 'カスタム検索軸データの子要素が存在しません。axis_name=' . $customAxisName;
                                    $msg->fEntSearchAxisData = $fEntSearchAxisData;
                                    return;
                                }
                            }

                            $fEntSearchAxisKbn = new FEntSearchAxisKbn();

                            $fEntSearchAxisKbn->type = $axisItems['type'];
                            $fEntSearchAxisKbn->name = $axisItems['name'];
                            $fEntSearchAxisKbn->value = $axisItems['value'];

                            if($axisItems['children']??null) {
                                $arrayChildren = array();
                                foreach ($axisItems['children'] as $childrenItems) {

                                    if(!((isset($childrenItems['type'])&&$childrenItems['type']) &&
                                        (isset($childrenItems['name'])&&$childrenItems['name']) &&
                                        (isset($childrenItems['value'])&&$childrenItems['value']))) {
                                        //カスタム検索軸の情報が正常に取得できないためエラーを返す

                                        $fEntSearchAxisData->fEntSearchAxis = $fEntSearchAxis;
                                        $fEntSearchAxisData->isSuccessGetAxis = false;
                                        $fEntSearchAxisData->isCustomSearch = true;

                                        $msg->_c = Cst::OUTPUT_ERROR;
                                        $msg->_m = 'カスタム検索軸データの子要素に不備があります。axis_name=' . $customAxisName;
                                        $msg->fEntSearchAxisData = $fEntSearchAxisData;
                                        return;
                                    }

                                    $fEntSearchAxisChildrenKbn = new FEntSearchAxisKbn();

                                    $fEntSearchAxisChildrenKbn->type = $childrenItems['type'];
                                    $fEntSearchAxisChildrenKbn->name = $childrenItems['name'];
                                    $fEntSearchAxisChildrenKbn->value = $childrenItems['value'];
                                    $arrayChildren[] = $fEntSearchAxisChildrenKbn;
                                }
                                $fEntSearchAxisKbn->children = $arrayChildren;
                            }

                            $arraySearchAxis[$customAxisName][$index] = $fEntSearchAxisKbn;
                        }
                    }
                    else {
                        if($isCustomSearch) {
                            //カスタム検索のフラグが立っているのに軸の情報が取れていないためエラーを返す

                            $fEntSearchAxisData->fEntSearchAxis = $fEntSearchAxis;
                            $fEntSearchAxisData->isSuccessGetAxis = false;
                            $fEntSearchAxisData->isCustomSearch = true;

                            $msg->_c = Cst::OUTPUT_ERROR;
                            $msg->_m = 'カスタム検索軸データが存在しません。axis_name=' . $customAxisName;
                            $msg->fEntSearchAxisData = $fEntSearchAxisData;
                            return;
                        }
                    }
                }
            }
        }

        //カスタム検索軸の格納 end

        $fEntSearchAxis->area = $arraySearchAxis['area']??null;
        $fEntSearchAxis->pref = $arraySearchAxis['pref']??null;
        $fEntSearchAxis->city = $arraySearchAxis['city']??null;
        $fEntSearchAxis->jobbc = $arraySearchAxis['jobbc']??null;
        $fEntSearchAxis->job = $arraySearchAxis['job']??null;
        $fEntSearchAxis->koy = $arraySearchAxis['koy']??null;
        $fEntSearchAxis->tokucho = $arraySearchAxis['tokucho']??null;
        $fEntSearchAxis->rosen = $arraySearchAxis['rosen']??null;


        //こだわり検索軸の格納 start (必要に応じて)

//        $fEntSearchAxis->kodawari = array();
//
//        $kodawariParamList = array(
//            ["name" => "初心者・未経験者OK", "value" => "＃初心者・未経験者OK"],
//            ["name" => "カップル・友人応募OK", "value" => "＃カップル・友人応募OK"],
//            ["name" => "車・バイク通勤OK", "value" => "＃車・バイク通勤OK"],
//            ["name" => "寮・社宅完備", "value" => "＃寮・社宅完備"],
//            ["name" => "外国人活躍中", "value" => "＃外国人活躍中"],
//            ["name" => "シニア活躍中", "value" => "＃シニア活躍中"],
//            ["name" => "中高年活躍中", "value" => "＃中高年活躍中"],
//            ["name" => "女性活躍中", "value" => "＃女性活躍中"],
//            ["name" => "子育てママ・パパ活躍", "value" => "＃子育てママ・パパ活躍"],
//            ["name" => "土日（祝）休み", "value" => "＃土日（祝）休み"],
//            ["name" => "年間休日120日以上", "value" => "＃年間休日120日以上"],
//            ["name" => "シフト勤務", "value" => "＃シフト勤務"],
//            ["name" => "時間または曜日が選べる", "value" => "＃時間または曜日が選べる"],
//            ["name" => "日勤のみ", "value" => "＃日勤のみ"],
//            ["name" => "夜勤のみ", "value" => "＃夜勤のみ"],
//            ["name" => "夜勤", "value" => "＃夜勤"],
//            ["name" => "残業少なめ", "value" => "＃残業少なめ"],
//            ["name" => "残業多め", "value" => "＃残業多め"],
//            ["name" => "短期", "value" => "＃短期"],
//            ["name" => "時短勤務", "value" => "＃時短勤務"],
//            ["name" => "研修あり", "value" => "＃研修あり"],
//            ["name" => "資格・免許取得支援あり", "value" => "＃資格・免許取得支援あり"],
//            ["name" => "食堂完備", "value" => "＃食堂完備"],
//            ["name" => "綺麗な工場", "value" => "＃綺麗な工場"],
//            ["name" => "髪型または髪色自由", "value" => "＃髪型または髪色自由"],
//            ["name" => "ネイルOK", "value" => "＃ネイルOK"],
//            ["name" => "経験者優遇", "value" => "＃経験者優遇"],
//            ["name" => "駅チカ", "value" => "＃駅チカ"],
//            ["name" => "送迎あり", "value" => "＃送迎あり"],
//            ["name" => "請負", "value" => "＃請負"],
//            ["name" => "派遣", "value" => "＃派遣"],
//            ["name" => "寮費0円（無料）", "value" => "＃寮費0円"],
//            ["name" => "寮費補助", "value" => "＃寮費補助"],
//            ["name" => "住宅手当", "value" => "＃住宅手当"],
//            ["name" => "食事補助", "value" => "＃食事補助"],
//            ["name" => "月収30万円以上可", "value" => "＃月収30万円以上可"],
//            ["name" => "月収40万円以上可", "value" => "＃月収40万円以上可"],
//            ["name" => "特別手当あり", "value" => "＃特別手当あり"],
//            ["name" => "入社特典あり", "value" => "＃入社特典あり"],
//            ["name" => "家族寮", "value" => "＃家族寮"],
//            ["name" => "カップル寮", "value" => "＃カップル寮"],
//            ["name" => "ペット寮", "value" => "＃ペット寮"]
//
//        );
//
//        foreach($kodawariParamList As $index => $params) {
//            $fEntSearchAxisKbn = new FEntSearchAxisKbn();
//            $fEntSearchAxisKbn->type = "kw";
//            $fEntSearchAxisKbn->name = $params["name"];
//            $fEntSearchAxisKbn->value = $params["value"];
//            $fEntSearchAxisKbn->cnt = null;
//            $fEntSearchAxisKbn->parent = null;
//            $fEntSearchAxisKbn->children = null;
//
//            $fEntSearchAxis->kodawari[$index] = $fEntSearchAxisKbn;
//        }


        //こだわり検索軸の格納 end


        $fEntSearchAxisData->fEntSearchAxis = $fEntSearchAxis;
        $fEntSearchAxisData->isSuccessGetAxis = true;
        $fEntSearchAxisData->isCustomSearch = $isCustomSearch;
        $fEntSearchAxisData->isCustomArea = $isCustomArea;
        $fEntSearchAxisData->isCustomJob = $isCustomJob;

        $msg->_c = Response::HTTP_OK;
        $msg->_m = '検索軸の取得に成功しました';
        $msg->fEntSearchAxisData = $fEntSearchAxisData;

    }
}
