<?php
namespace App\Util;

use App\Core\Logger\Logger;
use App\Models\FEnt\FEntValidateRuleConfig;

/**
 * Class UtilApplyValidate
 * @package App\Util
 */
class UtilApplyValidate
{
    /**
     * @param $formSettings
     * @return FEntValidateRuleConfig
     */
    static function createApplyValidateRuleConfig($formSettings){

        Logger::infoTrace(__METHOD__ . ' --start');

        $applyValidateRuleConfig = new FEntValidateRuleConfig();

        //validationルール作成前の判定処理
        $isTrueConfig = true;
        foreach($formSettings As $sectionName => $items) {

            if($sectionName === 'custom') {
                continue;
            }

            if(count($items)===0) {
                $isTrueConfig = false;
                Logger::errorTrace('validation rule: section missing Error' , $sectionName);
                break;
            }
            foreach($items As $groupName => $list) {
                if(count($list)===0) {
                    $isTrueConfig = false;
                    Logger::errorTrace('validation rule: group missing Error' , $groupName);
                    break 2;
                }
                foreach($list As $fieldName => $rules) {

                    if(($fieldName === 'index') || ($fieldName === 'required')) {
                        continue;
                    }

                    if(!(array_key_exists('required', $rules) && array_key_exists('type', $rules) && array_key_exists('rule', $rules))) {
                        $isTrueConfig = false;
                        Logger::errorTrace('validation rule: field missing Error' , $fieldName);
                        break 3;
                    }
                }
            }
        }

        if(!$isTrueConfig) {
            $formSettings = config('applyForm'); //validation項目エラーが発生した時点でデフォルトの設定に置き換える
        }

        $rules = self::createValidateRules($formSettings);

        $applyValidateRuleConfig->rules = $rules;
        $applyValidateRuleConfig->messages = self::createValidateMessages($rules);

        Logger::infoTrace(__METHOD__ . ' --end');

        return $applyValidateRuleConfig;
    }

    /**
     * @param $applyFormSettings
     * @return array
     */
    static function createValidateRules($applyFormSettings){
        $arrayRule = array();


        if($applyFormSettings && count($applyFormSettings)>0) {
            foreach($applyFormSettings As $sectionName => $items) {

                if($sectionName == 'custom') {
                    foreach($items As $name => $list) {
                        foreach($list As $groupName => $customList) {
                            foreach($customList As $fieldName => $rules) {

                                if(($fieldName === 'index') || ($fieldName === 'label')) {
                                    continue;
                                }

                                $arrayRule[$fieldName] = array();

                                if(isset($rules['required']) && $rules['required']) {
                                    array_push($arrayRule[$fieldName], 'required');
                                }
                                else {
                                    array_push($arrayRule[$fieldName], 'nullable');
                                }

                                if(isset($rules['type']) && $rules['type']) {
                                    array_push($arrayRule[$fieldName], $rules['type']);
                                }

                                if(isset($rules['rule']) && $rules['rule']) {
                                    array_push($arrayRule[$fieldName], $rules['rule']);
                                }

                            }
                        }
                    }
                    continue;
                }

                foreach($items As $groupName => $list) {

                    if(($groupName === 'index')) {
                        continue;
                    }

                    foreach($list As $fieldName => $rules) {
                        if(($fieldName === 'index') || ($fieldName === 'required')) {
                            continue;
                        }

                        $arrayRule[$fieldName] = array();

                        if(isset($rules['required']) && $rules['required']) {
                            array_push($arrayRule[$fieldName], 'required');
                        }
                        else {
                            array_push($arrayRule[$fieldName], 'nullable');
                        }

                        if(isset($rules['type']) && $rules['type']) {
                            array_push($arrayRule[$fieldName], $rules['type']);
                        }

                        if(isset($rules['rule']) && $rules['rule']) {
                            array_push($arrayRule[$fieldName], $rules['rule']);
                        }
                    }
                }
            }
        }

        return $arrayRule;
    }

    /**
     * @param $ruleList
     * @return array
     */
    static function createValidateMessages($ruleList){

        $messages = array();

        if(count($ruleList)>0) {
            foreach($ruleList as $field => $rules){
                foreach($rules as $rule){
                    $ary = explode(":", $rule);
                    $attribute = false; // 初期化
                    if(count($ary) > 1){
                        $rule = $ary[0];
                        $attribute = $ary[1];
                    }
                    $key = $field . '.' . $rule;
                    $msg = null;
                    switch($rule){
                        case 'required':
                            $msg = '必須項目です。';
                            break;
                        case 'numeric':
                        case 'integer':
                            $msg = '数値を入力してください';
                            break;
                        case 'email':
                            $msg = 'Eメールの形式で入力して下さい';
                            break;
                        case 'between':
                        case 'digits_between':
                            $min = null;
                            $max = null;
                            if($attribute) {
                              $minmax = explode(',' , $attribute);
                              $min = $minmax[0]??null;
                              $max = $minmax[1]??null;
                            }
                            if($min !== null && $max !== null) { //0の場合があるので厳密判定
                                if($rule == 'between') {
                                    $msg = $min.'から'.$max.'の間で入力してください。';
                                }
                                if($rule == 'digits_between') {
                                    $msg = $min.'桁から'.$max.'桁の間で入力してください。';
                                }
                            }
                            break;
                        case 'digits':
                            $msg = ( $attribute ? $attribute.'桁で入力してください。' : '' );
                            break;
                        case 'max':
                            $msg = ( $attribute ? $attribute.'文字以下で入力してください。' : '' );
                            break;
                        default:
                            break;
                    }
                    if($msg){
                        $messages[$key] = $msg;
                    }
                }
            }
            if(isset($messages['job_id.required'])){
                $messages['job_id.required']  = '対象の求人情報が取得できませんでした。';
            }
        }

        return $messages;
    }
}