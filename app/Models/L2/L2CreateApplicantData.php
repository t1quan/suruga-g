<?php

namespace App\Models\L2;

use App\Core\Logger\Logger;
use App\Models\Constant\Cst;
use App\Models\FEnt\FEntApplyFreeItem;
use App\Models\FEnt\FEntApplyRequestData;
use App\Models\FEnt\FEntApplicant;
use App\Models\FEnt\FEntJobHistory;
use App\Models\FEnt\FEntMailSettings;
use App\Models\FEnt\FEntMailTemplateIdList;
use App\Models\L2\Msg\MsgL2CreateApplicantData;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Exception;

/**
 * Class L2CreateApplicantData
 * @package App\Models\L2
 */
class L2CreateApplicantData extends L2Abstract
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param MsgL2CreateApplicantData $msg
     * @throws Exception
     */
    protected function exec(MsgL2CreateApplicantData $msg)
    {

        $fEntJob = $msg->fEntJob;
        $params = $msg->params;
        $fEntConfig = $msg->fEntConfig;
        $jobUri = $msg->jobUri;

        if($params === null or count($params) == 0){
            $msg->isSuccess = false;
            $msg->rtnCd = Cst::INPUT_ERROR;
            $msg->rtnMessage = "応募者情報が取得できませんでした。";
            return;
        }

        if($fEntJob === null){
            $msg->isSuccess = false;
            $msg->rtnCd = Cst::INPUT_ERROR;
            $msg->rtnMessage = "応募求人の情報が取得できませんでした。";
            return;
        }

        if($fEntConfig === null){
            $msg->isSuccess = false;
            $msg->rtnCd = Cst::INPUT_ERROR;
            $msg->rtnMessage = "企業設定情報が取得できませんでした。";
            return;
        }

        if($jobUri === null or $jobUri === ""){
            $msg->isSuccess = false;
            $msg->rtnCd = Cst::INPUT_ERROR;
            $msg->rtnMessage = "求人掲載URIが取得できませんでした。";
            return;
        }

        $mappingList = array(
            'lastName' => 'lastName',
            'firstName' => 'firstName',
            'lastKana' => 'lastNameKana',
            'firstKana' => 'firstNameKana',
            'birthday' => 'birthDay',
            'gender' => 'gender',
            'telNumber' => 'tel',
            'mailAddress' => 'email',
            'currentOccupation' => 'occupation',
            'zipCode' => 'zip',
            'prefecture' => 'pref',
            'city' => 'city',
            'street' => 'otherAddr',
            'station' => 'station',
            'educationLevel' => 'schoolType',
            'graduationYear' => 'graduationYear',
            'graduationStatus' => 'educationStatus',
            'schoolName' => 'schoolName',
            'departmentName' => 'schoolFaculty',
            'maritalStatus' => 'married',
            'englishConversation' => 'conversationEnglish',
            'businessEnglish' => 'businessEnglish',
            'toeicScore' => 'toeic',
            'toeflScore' => 'toefl',
            'stepScore' => 'eiken',
            'otherLanguage' => 'otherLanguage',
            'otherConversation' => 'conversationOtherLanguage',
            'otherBusiness' => 'businessOtherLanguage',
            'wordSkill' => 'wordSkill',
            'excelSkill' => 'excelSkill',
            'accessSkill' => 'accessSkill',
            'powerpointSkill' => 'powerpointSkill',
            'webSkill' => 'webSkill',
            'otherPCSkill' => 'pcSkill',
            'qualification' => 'otherSkill',
            'changeNumber' => 'changeJobCount',
            'managementExperience' => 'managementExperience',
            'managementNumber' => 'numberOfManagement',
            'pr' => 'aboutMySelf',
            'remarks' => 'remarks',
        );

        $skipItems = array(
            '_token' => '',
            'job_id' => '',
            'agree' => '',
            'agree_flg1' => '',
            'agree_flg2' => '',
            'dobYear' => '',
            'dobMonth' => '',
            'dobDay' => '',
            'startYearA' => '',
            'startYearB' => '',
            'startYearC' => '',
            'startYearD' => '',
            'startYearE' => '',
            'startMonthA' => '',
            'startMonthB' => '',
            'startMonthC' => '',
            'startMonthD' => '',
            'startMonthE' => '',
            'endYearA' => '',
            'endYearB' => '',
            'endYearC' => '',
            'endYearD' => '',
            'endYearE' => '',
            'endMonthA' => '',
            'endMonthB' => '',
            'endMonthC' => '',
            'endMonthD' => '',
            'endMonthE' => '',
        );


        // 日付形式のデータを連結・フォーマットかける
        if(isset($params['dobYear']) and isset($params['dobMonth']) and isset($params['dobDay'])){
            $date = self::createDate($params['dobYear'], $params['dobMonth'], $params['dobDay']);
            if($date) {
                $params['birthday'] = $date->format('Y-m-d');
            }
        }

        $fieldList = array(
            'start' => 'startDate',
            'end' => 'endDate',
        );

        $names = array('A','B','C','D','E');

        for($i = 1; $i <= 5; $i++){
            foreach($fieldList as $key => $filed){
                $fn1 = $key.'Year'.$names[$i-1];
                $fn2 = $key.'Month'.$names[$i-1];
                $filedNm = $filed . $i;
                if(isset($params[$fn1]) and isset($params[$fn2])){
                    $date = self::createDate($params[$fn1], $params[$fn2], 1);
                    if($date){
                        $params[$filedNm] = $date->format('Y-m-d');
                    }
                }
            }
        }

        $alphabetFieldList = array(
            'companyName' => 'corpName',
            'employmentStatus' => 'employmentStatus',
            'jobDescription' => 'jobContents',
        );

        for($i = 1; $i <= 5; $i++){
            foreach($alphabetFieldList as $key => $filed){
                $fn = $key.$names[$i-1];
                $filedNm = $filed . $i;
                if(isset($params[$fn])){
                    $params[$filedNm] = $params[$fn];
                }
            }
        }

        $numberFieldList = array(
            'occupation' => 'jobCategory',
            'period' => 'yearsOfExperience',
            'industry' => 'jobIndustry',
        );

        for($i = 1; $i <= 5; $i++){
            foreach($numberFieldList as $key => $filed){
                $fn = $key.$i;
                $filedNm = $filed . $i;
                if(isset($params[$fn])){
                    $params[$filedNm] = $params[$fn];
                }
            }
        }

        $fEntApplyRequestData = new FEntApplyRequestData();

        $fEntApplyRequestData->appliedDate = self::getNowStr();

        $fEntApplyRequestData->jobId = $fEntJob->jobId;

        $fEntApplyRequestData->isLinkJob = $msg->isLinkJob ?? true;

        //oss0001への登録フラグ設定
        $isInsertApplicantData = $msg->isInsertApplicantData ?? true;

        //求人に紐づかないのにoss0001に応募登録をすることは不可能なのでエラーを返す
        if(($msg->isLinkJob === false) && ($isInsertApplicantData === true)) {
            $msg->isSuccess = false;
            $msg->rtnCd = Cst::INPUT_ERROR;
            $msg->rtnMessage = "求人に紐づかない応募は登録ができません。";
            return;
        }

        $fEntApplyRequestData->isInsertApplicantData = $isInsertApplicantData;

        //メール設定 start
        $mailSettings = new FEntMailSettings();

        $isChangeMailTemplateId = $msg->isChangeMailTemplateId ?? false; //デフォルト設定

        $mailSettings->isChangeMailTemplateId = $isChangeMailTemplateId;

        $toTantosyaMailAddress = $msg->toTantosyaMailAddress;

        //登録をしないのに担当者向けメールの送信先が設定されていないのでエラーを返す
        if(($isInsertApplicantData === false) && ($toTantosyaMailAddress === null || $toTantosyaMailAddress === '')) {
            $msg->isSuccess = false;
            $msg->rtnCd = Cst::INPUT_ERROR;
            $msg->rtnMessage = "応募登録を行わない設定ですが担当者向けメールアドレスが設定されていません。";
            return;
        }

        $mailSettings->toTantosyaMailAddress = $toTantosyaMailAddress;

        $mailTemplateIdList = new FEntMailTemplateIdList();

        //各メールテンプレートIDのデフォルト設定
        $mailObosyaId = 1;
        $mailTantosyaId = 2;

        if($isChangeMailTemplateId) {
            if($msg->mailObosyaId && is_numeric($msg->mailObosyaId)) {
                $mailObosyaId = $msg->mailObosyaId;
            }
            if($msg->mailTantosyaId && is_numeric($msg->mailTantosyaId)) {
                $mailTantosyaId = $msg->mailTantosyaId;
            }
        }

        $mailTemplateIdList->mailObosyaId = $mailObosyaId;
        $mailTemplateIdList->mailTantosyaId = $mailTantosyaId;

        $mailSettings->mailTemplateIdList = $mailTemplateIdList;

        $fEntApplyRequestData->mailSettings = $mailSettings;

        //メール設定 end


        $fEntApplicant = new FEntApplicant();

        foreach($mappingList as $formName => $propertyName){
            $fEntApplicant->__set($propertyName, self::setParam($params, $formName));
        }

        if(isset($params['gender']) && $params['gender'] === '0'){
            $fEntApplicant->gender = '0';
        }

        //int型への変換処理　start

        //プロフィール
        if(isset($params['prefecture']) && is_numeric($params['prefecture'])){
            $fEntApplicant->pref = (int)$params['prefecture'];
        }

        if(isset($params['city']) && is_numeric($params['city'])){
            $fEntApplicant->city = (int)$params['city'];
        }

        if(isset($params['currentOccupation']) && is_numeric($params['currentOccupation'])){
            $fEntApplicant->occupation = (int)$params['currentOccupation'];
        }

        //スキル
        if(isset($params['englishConversation']) && is_numeric($params['englishConversation'])){
            $fEntApplicant->conversationEnglish = (int)$params['englishConversation'];
        }

        if(isset($params['businessEnglish']) && is_numeric($params['businessEnglish'])){
            $fEntApplicant->businessEnglish = (int)$params['businessEnglish'];
        }

        if(isset($params['toeicScore']) && is_numeric($params['toeicScore'])){
            $fEntApplicant->toeic = (int)$params['toeicScore'];
        }

        if(isset($params['toeicScore']) && is_numeric($params['toeicScore'])){
            $fEntApplicant->toeic = (int)$params['toeicScore'];
        }

        if(isset($params['toeflScore']) && is_numeric($params['toeflScore'])){
            $fEntApplicant->toefl = (int)$params['toeflScore'];
        }

        if(isset($params['stepScore']) && is_numeric($params['stepScore'])){
            $fEntApplicant->eiken = (int)$params['stepScore'];
        }

        if(isset($params['otherLanguage']) && is_numeric($params['otherLanguage'])){
            $fEntApplicant->otherLanguage = (int)$params['otherLanguage'];
        }

        if(isset($params['otherConversation']) && is_numeric($params['otherConversation'])){
            $fEntApplicant->conversationOtherLanguage = (int)$params['otherConversation'];
        }

        if(isset($params['otherBusiness']) && is_numeric($params['otherBusiness'])){
            $fEntApplicant->businessOtherLanguage = (int)$params['otherBusiness'];
        }

        if(isset($params['wordSkill']) && is_numeric($params['wordSkill'])){
            $fEntApplicant->wordSkill = (int)$params['wordSkill'];
        }

        if(isset($params['excelSkill']) && is_numeric($params['excelSkill'])){
            $fEntApplicant->excelSkill = (int)$params['excelSkill'];
        }

        if(isset($params['accessSkill']) && is_numeric($params['accessSkill'])){
            $fEntApplicant->accessSkill = (int)$params['accessSkill'];
        }

        if(isset($params['powerpointSkill']) && is_numeric($params['powerpointSkill'])){
            $fEntApplicant->powerpointSkill = (int)$params['powerpointSkill'];
        }

        if(isset($params['webSkill']) && is_numeric($params['webSkill'])){
            $fEntApplicant->webSkill = (int)$params['webSkill'];
        }

        if(isset($params['otherPCSkill']) && is_numeric($params['otherPCSkill'])){
            $fEntApplicant->pcSkill = (int)$params['otherPCSkill'];
        }

        //キャリア
        if(isset($params['changeNumber']) && is_numeric($params['changeNumber'])){
            $fEntApplicant->changeJobCount = (int)$params['changeNumber'];
        }

        //マネジメント経験のデフォルトセッティング
        if(!isset($params['managementExperience'])){
            $fEntApplicant->managementExperience = 0;
        }
        else {
            if(is_numeric($params['managementExperience'])) {
                $fEntApplicant->managementExperience = (int)$params['managementExperience'];
            }
        }

        if(isset($params['managementNumber']) && is_numeric($params['managementNumber'])){
            $fEntApplicant->numberOfManagement = (int)$params['managementNumber'];
        }

        //その他

        if(isset($params['maritalStatus']) && is_numeric($params['maritalStatus'])){
            $fEntApplicant->married = (int)$params['maritalStatus'];
        }

        if(isset($params['graduationYear']) && is_numeric($params['graduationYear'])){
            $fEntApplicant->graduationYear = (int)$params['graduationYear'];
        }

        if(isset($params['educationLevel']) && is_numeric($params['educationLevel'])){
            $fEntApplicant->schoolType = (int)$params['educationLevel'];
        }

        if(isset($params['graduationStatus']) && is_numeric($params['graduationStatus'])){
            $fEntApplicant->educationStatus = (int)$params['graduationStatus'];
        }

        //int型への変換処理　end

        $arrayJobHistory = array();

        for($i = 1; $i <= 5; $i++) {
            $fEntJobHistry = new FEntJobHistory();
            foreach($fEntJobHistry As $key => $value) {
                $name = $key.$i;
                if(isset($params[$name])) {
                    if($key === 'employmentStatus' || $key === 'jobCategory' || $key === 'yearsOfExperience' || $key === 'jobIndustry') {
                        if(is_numeric($params[$name])) {
                            $fEntJobHistry->$key = (int)$params[$name]; //int型へ変換
                        }
                    }
                    else {
                        $fEntJobHistry->$key = $params[$name];
                    }
                }
            }
            if(json_encode($fEntJobHistry) != json_encode(new FEntJobHistory())) {
                $arrayJobHistory[] = $fEntJobHistry;
            }
        }

        $fEntApplicant->jobHistories = $arrayJobHistory;

        $fEntApplyRequestData->applicant = $fEntApplicant;

        $arrayFreeItem = array();

        //カスタムselect選択項目の値=>名称への変換用配列
        $customSelectItems = array();

        //バックエンド側に渡すカスタム項目のキー名称のリスト
        $customKeyList = array();

        $formPath = $msg->formPath ?? 'apply';

        if(isset($fEntConfig->backendSettings['form'][$formPath]['custom']) && count($fEntConfig->backendSettings['form'][$formPath]['custom'])>0) {
            foreach($fEntConfig->backendSettings['form'][$formPath]['custom'] As $sectionName => $items) {
                foreach($items As $groupName => $list) {

                    if($groupName === 'index' || $groupName === 'required') {
                        continue;
                    }

                    $label = null;

                    foreach($list As $fieldName => $rules) {
                        if($fieldName === 'label') {
                            $label = $rules;
                            continue;
                        }
                        if(isset($rules['fieldType']) && ($rules['fieldType'] === 'select')) {
                            if(isset($rules['master']) && count($rules['master'])>0) {
                                $customSelectItems[$fieldName] = $rules['master'];
                            }
                        }
                        if($label && is_array($rules)) {
                            if($isInsertApplicantData) {
                                $customKeyList[$fieldName] = $label;
                            }
                            else {
                                $customKeyList[$fieldName] = $fieldName;
                            }
                        }
                    }
                }
            }
        }

        foreach($params As $name => $value) {
            if(isset($mappingList[$name])) {
                continue;
            }
            if(isset($skipItems[$name])) {
                continue;
            }

            for($i = 1; $i <= 5; $i++){
                foreach($numberFieldList as $key => $filed){
                    $fn = $key.$i;
                    $filedNm = $filed . $i;
                    if(($name === $fn) || $name === $filedNm) {
                        continue 3;
                    }
                }

                foreach($alphabetFieldList as $key => $filed){
                    $fn = $key.$names[$i-1];
                    $filedNm = $filed . $i;
                    if(($name === $fn) || $name === $filedNm) {
                        continue 3;
                    }
                }

                foreach($fieldList as $key => $filed){
                    $filedNm = $filed . $i;
                    if($name === $filedNm) {
                        continue 3;
                    }
                }
            }

            $fEntApplyFreeItem = new FEntApplyFreeItem();

            $keyName = $customKeyList[$name] ?? $name;
            $fEntApplyFreeItem->name = $keyName;

            if(isset($customSelectItems[$name]) && ($value !== null)) {
                $fEntApplyFreeItem->value = $customSelectItems[$name][(int)$value]??null;
            }
            else {
                $fEntApplyFreeItem->value = $value??null;
            }

            $arrayFreeItem[] = $fEntApplyFreeItem;
        }

        //oss0001への登録を行わないため、メール送信を考慮し区分値を名称に変換した状態でフリー項目としてバックエンド側に渡す
        if($isInsertApplicantData === false) {

            $fEntApplyMasters = $msg->applyMasters ?? null;

            if(isset($params['gender'])) {
                //性別処理 start
                $arrayGenderMaster = array();
                if($fEntApplyMasters->genderMst??null && is_array($fEntApplyMasters->genderMst) && (count($fEntApplyMasters->genderMst) > 0)) {
                    foreach($fEntApplyMasters->genderMst As $gender) {
                        if($gender->value) {
                            $arrayGenderMaster[$gender->value] = $gender->name ?? '';
                        }
                    }
                }

                $fEntApplyFreeItem = new FEntApplyFreeItem();

                $fEntApplyFreeItem->name = 'gender';
                $genderName = '';
                if(isset($arrayGenderMaster[$params['gender']])) {
                    $genderName = $arrayGenderMaster[$params['gender']];
                }
                $fEntApplyFreeItem->value = $genderName;
                $arrayFreeItem[] = $fEntApplyFreeItem;

                //性別処理 end
            }

            if(isset($params['prefecture'])) {
                //都道府県処理 start
                $arrayPrefMaster = array();
                if($fEntApplyMasters->prefMst??null && is_array($fEntApplyMasters->prefMst) && (count($fEntApplyMasters->prefMst) > 0)) {
                    foreach($fEntApplyMasters->prefMst As $pref) {
                        if($pref->value) {
                            $arrayPrefMaster[$pref->value] = $pref->name ?? '';
                        }
                    }
                }

                $fEntApplyFreeItem = new FEntApplyFreeItem();

                $fEntApplyFreeItem->name = 'prefName';
                $prefectureName = '';
                if(isset($arrayPrefMaster[$params['prefecture']])) {
                    $prefectureName = $arrayPrefMaster[$params['prefecture']];
                }
                $fEntApplyFreeItem->value = $prefectureName;
                $arrayFreeItem[] = $fEntApplyFreeItem;

                //都道府県処理 end

                //市区町村コードのみの場合は考慮しない(必ず都道府県コードとセットと想定する)
                if(isset($params['city'])) {
                    //市区町村処理 start
                    $arrayCityMaster = array();
                    if($fEntApplyMasters->cityMst??null && is_array($fEntApplyMasters->cityMst) && (count($fEntApplyMasters->cityMst) > 0)) {
                        foreach($fEntApplyMasters->cityMst As $city) {
                            if($city->parent && $city->value) {
                                $arrayCityMaster[$city->parent][$city->value] = $city->name ?? '';
                            }
                        }
                    }

                    $fEntApplyFreeItem = new FEntApplyFreeItem();

                    $fEntApplyFreeItem->name = 'cityName';
                    $cityName = '';
                    if(isset($arrayCityMaster[$params['prefecture']][$params['city']])) {
                        $cityName = $arrayCityMaster[$params['prefecture']][$params['city']];
                    }
                    $fEntApplyFreeItem->value = $cityName;
                    $arrayFreeItem[] = $fEntApplyFreeItem;

                    //市区町村処理 end
                }
            }

        }

        $fEntApplyRequestData->free = $arrayFreeItem;

//        $fEntApplyRequestData->siteUrl = Route('top') . $jobUri . $fEntJob->jobId;
        $fEntApplyRequestData->siteUrl = Route('top') . $jobUri;

        $msg->fEntApplyRequestData = $fEntApplyRequestData;

        $msg->isSuccess = true;
        $msg->rtnCd = 200;
        $msg->rtnMessage = '登録データ作成完了';

    }

    /**
     * @throws Exception
     */
    private function createDate($y, $m, $d){
        if(!checkdate($m,$d,$y)){
            return false;
        }

        $datetime = $y.'-'.$m.'-'.$d;

        return new DateTimeImmutable($datetime, new DateTimeZone('Asia/Tokyo'));
    }

    private function setParam($params, $field, $default=null)
    {
        if(isset($params[$field]) and $params[$field] !== null and $params[$field] !== '' and $params[$field] != '-1'){
            return $params[$field];
        }else{
            return $default;
        }
    }

    /**
     * @param string $format
     * @return string
     */
    final protected function getNowStr($format = 'Y/m/d H:i:s'){
        $now = DateTime::createFromFormat('U.u', sprintf('%6F', microtime(true)));
        $now->setTimezone(new DateTimeZone('Asia/Tokyo'));
        return $now->format($format);
    }

}
