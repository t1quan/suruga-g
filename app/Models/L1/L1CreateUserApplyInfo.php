<?php
namespace App\Models\L1;

use App\Models\Constant\Cst;
use App\Models\FEnt\FEntUserApplyInfo;
use App\Models\L1\Msg\MsgL1CreateUserApplyInfo;

use Illuminate\Http\JsonResponse;

/**
 * Class L1CreateUserApplyInfo
 * @package App\Models\L1
 */
class L1CreateUserApplyInfo extends L1Abstract
{
    function __construct(){
        parent::__construct();
    }

    /**
     * @param MsgL1CreateUserApplyInfo $msg
     * @throws \Exception
     */
    protected function exec(MsgL1CreateUserApplyInfo $msg)
    {
        //初期化
        $msg->_c = null;
        $msg->_m = null;

        $fEntUserApplyInfo = new FEntUserApplyInfo();
        $params = $msg->params;
        if($params){

            // 日付形式のデータを連結・フォーマットかける
            //生年月日が必須ではない場合を考慮し、生年月日のパラメータが存在しない場合もエラーは返さない
            if(isset($params['dobYear']) and isset($params['dobMonth']) and isset($params['dobDay'])){
                $date = self::createDate($params['dobYear'], $params['dobMonth'], $params['dobDay']);
                if($date){
                    $params['birthday'] = $date;
                }
            }

            $fieldList = array(
                'start' => 'kinmStrYymm',
                'end' => 'kinmEndYymm',
            );

            $names = array('A','B','C','D','E');

            for($i = 1; $i <= 5; $i++){
                foreach($fieldList as $key => $filed){
                    $fn1 = $key . 'Year'.$names[$i-1];
                    $fn2 = $key. 'Month'.$names[$i-1];
                    $filedNm = $filed . $i;
                    if(isset($params[$fn1]) and isset($params[$fn2])){
                        $date = self::createDate($params[$fn1], $params[$fn2], 1);
                        if($date){
                            $params[$filedNm] = $date;
                        }
                    }
                }
            }

            $mappingList = array(
                'lastName' => 'nameSei',
                'firstName' => 'nameMei',
                'lastKana' => 'nameSeiKn',
                'firstKana' => 'nameMeiKn',
                'dobYear' => 'birthdayYear',
                'dobMonth' => 'birthdayMonth',
                'dobDay' => 'birthdayDay',
                'birthday' => 'birthday',
                'gender' => 'gender',
                'telNumber' => 'telNumber',
                'mailAddress' => 'mailAddress',
                'currentOccupation' => 'currentSykgyKbn',
                'zipCode' => 'zipCd',
                'prefecture' => 'kenCd',
                'city' => 'shikuCd',
                'street' => 'otherAddr',
                'station' => 'moyoriEki',
                'educationLevel' => 'gakkoKbn',
                'graduationYear' => 'sotsugyoYear',
                'graduationStatus' => 'gakurekiKbn',
                'schoolName' => 'gakkoMei',
                'departmentName' => 'gakubuGakkaMei',
                'maritalStatus' => 'marriage',
                'englishConversation' => 'eigoKaiwaLevelKbn',
                'businessEnglish' => 'eigoGyomLevelKbn',
                'toeicScore' => 'toeic',
                'toeflScore' => 'toefl',
                'stepScore' => 'eikenKbn',
                'otherLanguage' => 'etcLanguageKbn',
                'otherConversation' => 'etcLanguageKaiwaLevelKbn',
                'otherBusiness' => 'etcLanguageGyomLevelKbn',
                'wordSkill' => 'wordLevelKbn',
                'excelSkill' => 'excelLevelKbn',
                'accessSkill' => 'accessLevelKbn',
                'powerpointSkill' => 'powerpointLevelKbn',
                'webSkill' => 'webKnrnLevelKbn',
                'otherPCSkill' => 'etcPcSkill',
                'qualification' => 'sikak',
                'changeNumber' => 'changeJobCount',
                'occupation1' => 'keiknSyksyCd1',
                'occupation2' => 'keiknSyksyCd2',
                'occupation3' => 'keiknSyksyCd3',
                'occupation4' => 'keiknSyksyCd4',
                'occupation5' => 'keiknSyksyCd5',
                'period1' => 'keiknSyksyNensuKbn1',
                'period2' => 'keiknSyksyNensuKbn2',
                'period3' => 'keiknSyksyNensuKbn3',
                'period4' => 'keiknSyksyNensuKbn4',
                'period5' => 'keiknSyksyNensuKbn5',
                'industry1' => 'keiknGyokaiCd1',
                'industry2' => 'keiknGyokaiCd2',
                'industry3' => 'keiknGyokaiCd3',
                'managementExperience' => 'managementExperience',
                'managementNumber' => 'numberOfManagement',
                'companyNameA' => 'corpMei1',
                'companyNameB' => 'corpMei2',
                'companyNameC' => 'corpMei3',
                'companyNameD' => 'corpMei4',
                'companyNameE' => 'corpMei5',
                'kinmStrYymm1' => 'kinmStrYymm1',
                'kinmStrYymm2' => 'kinmStrYymm2',
                'kinmStrYymm3' => 'kinmStrYymm3',
                'kinmStrYymm4' => 'kinmStrYymm4',
                'kinmStrYymm5' => 'kinmStrYymm5',
                'kinmEndYymm1' => 'kinmEndYymm1',
                'kinmEndYymm2' => 'kinmEndYymm2',
                'kinmEndYymm3' => 'kinmEndYymm3',
                'kinmEndYymm4' => 'kinmEndYymm4',
                'kinmEndYymm5' => 'kinmEndYymm5',
                'employmentStatusA' => 'koyKeitaiKbn1',
                'employmentStatusB' => 'koyKeitaiKbn2',
                'employmentStatusC' => 'koyKeitaiKbn3',
                'employmentStatusD' => 'koyKeitaiKbn4',
                'employmentStatusE' => 'koyKeitaiKbn5',
                'jobDescriptionA' => 'syokumuNaiyo1',
                'jobDescriptionB' => 'syokumuNaiyo2',
                'jobDescriptionC' => 'syokumuNaiyo3',
                'jobDescriptionD' => 'syokumuNaiyo4',
                'jobDescriptionE' => 'syokumuNaiyo5',
                'pr' => 'jikoPr',
                'remarks' => 'biko',
            );

            $skipItems = array(
                '_token' => '',
                'job_id' => '',
                'agree' => '',
                'agree_flg1' => '',
                'agree_flg2' => '',
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

            foreach($mappingList as $formName => $propertyName){
                $fEntUserApplyInfo->__set($propertyName, self::setParam($params, $formName));
            }

            $arrayFreeItem = array();

            foreach($params As $name => $value) {
                if(isset($mappingList[$name])) {
                    continue;
                }
                if(isset($skipItems[$name])) {
                    continue;
                }

                $arrayFreeItem[$name] = $value;
            }

            $fEntUserApplyInfo->free = $arrayFreeItem;

            if(isset($params['gender']) && $params['gender'] === '0'){
                $fEntUserApplyInfo->gender = '0';
            }
            if(isset($params['maritalStatus']) && $params['maritalStatus'] === '0'){
                $fEntUserApplyInfo->marriage = '0';
            }
        }

        $msg->fEntUserApplyInfo = $fEntUserApplyInfo;
        $msg->_c = JsonResponse::HTTP_OK;
        $msg->_m = "応募情報の入力内容取得完了しました。";

    }

    /**
     * @throws \Exception
     */
    private function createDate($y, $m, $d){
        if(!checkdate($m,$d,$y)){
            return false;
        }

        $datetime = $y.'-'.$m.'-'.$d;

        return new \DateTimeImmutable($datetime, new \DateTimeZone('Asia/Tokyo'));
    }

    private function setParam($params, $field, $default=null)
    {
        if(isset($params[$field]) and $params[$field] !== null and $params[$field] !== '' and $params[$field] != '-1'){
            return $params[$field];
        }else{
            return $default;
        }
    }

}
