@extends('layouts.app')

@section('title', $page->title ?? '')

@section('content')

    @if(isset($fEntJobDetail))

    @php

    //表示項目の並び順の制御
    $tempApplyConfirmFormList = array();
    $arrayCustom = array();
    $isTrueConfig = true;

    /* @var $page */
    if(isset($page->fEntConfig->backendSettings['form']['apply']) && count($page->fEntConfig->backendSettings['form']['apply'])>0) {

        foreach($page->fEntConfig->backendSettings['form']['apply'] As $sectionName => $items) {
            if($sectionName === 'custom') {
                continue;
            }

            if(count($items)===0) {
                $isTrueConfig = false;
                break;
            }

            foreach($items As $groupName => $list) {
                if(count($list)===0) {
                    $isTrueConfig = false;
                    break 2;
                }

                foreach($list As $fieldName => $rules) {

                    if($fieldName !== 'index') {
                        if(!(array_key_exists('required', $rules) && array_key_exists('type', $rules) && array_key_exists('rule', $rules))) {
                            $isTrueConfig = false;
                            break 3;
                        }
                    }
                    $tempApplyConfirmFormList[$sectionName][$groupName]['index'] = $list['index']??null;
                    $tempApplyConfirmFormList[$sectionName][$groupName][$fieldName] = $rules['index']??null;
                }
            }
        }

        //カスタム項目の格納処理
        if(isset($page->fEntConfig->backendSettings['form']['apply']['custom']) && count($page->fEntConfig->backendSettings['form']['apply']['custom'])>0) {
            foreach($page->fEntConfig->backendSettings['form']['apply']['custom'] As $sectionName => $items) {
                foreach($items As $groupName => $list) {
                    foreach($list As $fieldName => $rules) {
                        if(($fieldName === 'index') || ($fieldName === 'label')) {
                            $tempApplyConfirmFormList[$sectionName][$groupName][$fieldName] = $rules??null;
                            continue;
                        }
                        $tempApplyConfirmFormList[$sectionName][$groupName][$fieldName] = $rules['index']??null;
                        $arrayCustom[$fieldName] = array(
                            'section' => $sectionName,
                            'fieldType' => $rules['fieldType']??null,
                            'hidden' => $rules['hidden']??null,
                            'master' => $rules['master']??null
                        );
                    }
                }
            }
        }

        foreach($tempApplyConfirmFormList AS $sectionName => $items) {

            $groupIdx = array();
            foreach($items As $groupName => $list) {
                $groupIdx[] = $list['index'] ?? 1;
            }
            array_multisort($groupIdx, SORT_ASC, SORT_NUMERIC, $items);

            foreach($items As $groupName => $list) {
                $idx = array();
                foreach($list As $fieldName => $index) {
                    $idx[] = $index ?? 1;
                }
                array_multisort($idx, SORT_ASC, SORT_NUMERIC, $list);
                $applyConfirmFormList[$sectionName][$groupName] = $list;
                unset($applyConfirmFormList[$sectionName][$groupName]['index']);
            }
        }
    }
    else {
        $applyConfirmFormList = config('applyConfirmForm');
    }

    if(!$isTrueConfig) {
        //validationと同じ条件でエラーを発生させ、項目と並び順を揃える
        $applyConfirmFormList = config('applyConfirmForm');
    }

    @endphp

    <div id="applyConfirm">
        <div id="wrapJobDetail">
            <div id="applyArea">
                <div class="inner">
                    <section class="mod_jobDetailJob">
                        <section class="mod_apply_confirm">
                            <header>
                                <div class="entry-title">応募情報の確認</div>
                                <div class="apply_navi">
                                    <ul><li class="text">STEP.1<br>応募情報の入力</li><li class="navi_sep">&nbsp;<br>&nbsp;</li><li class="text current">STEP.2<br>応募情報の確認</li><li class="navi_sep">&nbsp;<br>&nbsp;</li><li class="text">STEP.3<br>応募完了</li></ul>		</div>
                                <div>
                                    <h3>
                                        <a href="{{Route('top')}}/job/{{$fEntJobDetail->jobId}}">{{$fEntJobDetail->corpMei??""}}<br>{{$fEntJobDetail->jobTitle??""}}</a>
                                    </h3>
                                </div>
                            </header>
                            <form id="applyConfirmForm" name="fm" method="post" action="{{$page->action ?? '#'}}">
                                @csrf

                                @foreach($params as $key => $value)
                                    <input id="{{$key}}" type="hidden" name="{{$key}}" value="{{$value}}" />
                                @endforeach

                                @php
                            $arrayMultiParams = array();
                            $names = array('A','B','C','D','E');
                            $section2 = false;
                            $section3 = false;
                            $section4 = false;

                            //数値->名称に変換
                            /**@var \App\Models\FEnt\FEntApplyMasters $fEntApplyMasters */
                            if(isset($fEntApplyMasters) and isset($params)){
                                /**@var \App\Models\FEnt\FEntMst $fEntMst */
                                if(isset($params['gender'])){
                                    foreach($fEntApplyMasters->genderMst as $fEntMst){
                                        if($fEntMst->value == $params['gender']){
                                            $genderValue = $fEntMst->name;
                                            break;
                                        }
                                    }
                                }
                                if(isset($params['currentOccupation'])){
                                    foreach($fEntApplyMasters->occupationMst as $fEntMst){
                                        if($fEntMst->value == $params['currentOccupation']){
                                            $currentOccupationValue = $fEntMst->name;
                                            break;
                                        }
                                    }
                                }
                                if(isset($params['prefecture'])) {
                                    foreach($fEntApplyMasters->prefMst as $pref){
                                        if($pref->value == $params['prefecture']){
                                            $prefectureValue = $pref->name;
                                            if(isset($params['city'])) {
                                                foreach($fEntApplyMasters->cityMst as $city){
                                                    if($city->value == $params['city'] and $pref->value == $city->parent){
                                                        $cityValue = $city->name;
                                                        break;
                                                    }
                                                }
                                            }
                                            break;
                                        }
                                    }
                                }
                                if(isset($params['educationLevel'])){
                                    foreach($fEntApplyMasters->schoolMst as $fEntMst){
                                        if($fEntMst->value == $params['educationLevel']){
                                            $educationLevelValue = $fEntMst->name;
                                            $section4 = true;
                                            break;
                                        }
                                    }
                                }
                                if(isset($params['graduationStatus'])){
                                    foreach($fEntApplyMasters->educationMst as $fEntMst){
                                        if($fEntMst->value == $params['graduationStatus']){
                                            $graduationStatusValue = $fEntMst->name;
                                            $section4 = true;
                                            break;
                                        }
                                    }
                                }
                                if(isset($params['maritalStatus'])){
                                    foreach($fEntApplyMasters->maritalMst as $fEntMst){
                                        if((string)$fEntMst->value == (string)$params['maritalStatus']){
                                            $maritalStatusValue = $fEntMst->name;
                                            $section4 = true;
                                            break;
                                        }
                                    }
                                }

                                if(isset($params['station'])){
                                    $section4 = true;
                                }

                                if(isset($params['graduationYear'])){
                                    $section4 = true;
                                }

                                if(isset($params['schoolName'])){
                                    $section4 = true;
                                }

                                if(isset($params['departmentName'])){
                                    $section4 = true;
                                }

                                if(isset($params['englishConversation'])){
                                    foreach($fEntApplyMasters->kaiwaLvMst as $fEntMst){
                                        if($fEntMst->value == $params['englishConversation']){
                                            $englishConversationValue = $fEntMst->name;
                                            $section2 = true;
                                            break;
                                        }
                                    }
                                }
                                if(isset($params['businessEnglish'])){
                                    foreach($fEntApplyMasters->gyomLvMst as $fEntMst){
                                        if($fEntMst->value == $params['businessEnglish']){
                                            $businessEnglishValue = $fEntMst->name;
                                            $section2 = true;
                                            break;
                                        }
                                    }
                                }
                                if(isset($params['toeicScore'])){
                                    $section2 = true;
                                }
                                if(isset($params['toeflScore'])){
                                    $section2 = true;
                                }
                                if(isset($params['stepScore'])){
                                    foreach($fEntApplyMasters->eikenRankMst as $fEntMst){
                                        if($fEntMst->value == $params['stepScore']){
                                            $stepScoreValue = $fEntMst->name;
                                            $section2 = true;
                                            break;
                                        }
                                    }
                                }
                                if(isset($params['otherLanguage'])){
                                    foreach($fEntApplyMasters->langMst as $fEntMst){
                                        if($fEntMst->value == $params['otherLanguage']){
                                            $otherLanguageValue = $fEntMst->name;
                                            $section2 = true;
                                            break;
                                        }
                                    }
                                }
                                if(isset($params['otherConversation'])){
                                    foreach($fEntApplyMasters->kaiwaLvMst as $fEntMst){
                                        if($fEntMst->value == $params['otherConversation']){
                                            $otherConversationValue = $fEntMst->name;
                                            $section2 = true;
                                            break;
                                        }
                                    }
                                }
                                if(isset($params['otherBusiness'])){
                                    foreach($fEntApplyMasters->gyomLvMst as $fEntMst){
                                        if($fEntMst->value == $params['otherBusiness']){
                                            $otherBusinessValue = $fEntMst->name;
                                            $section2 = true;
                                            break;
                                        }
                                    }
                                }
                                foreach($fEntApplyMasters->skillRankMst as $fEntMst){
                                    if(isset($params['wordSkill'])){
                                        if($fEntMst->value == $params['wordSkill']){
                                            $wordSkillValue = $fEntMst->name;
                                            $section2 = true;
                                        }
                                    }
                                    if(isset($params['excelSkill'])){
                                        if($fEntMst->value == $params['excelSkill']){
                                            $excelSkillValue = $fEntMst->name;
                                            $section2 = true;
                                        }
                                    }
                                    if(isset($params['accessSkill'])){
                                        if($fEntMst->value == $params['accessSkill']){
                                            $accessSkillValue = $fEntMst->name;
                                            $section2 = true;
                                        }
                                    }
                                    if(isset($params['powerpointSkill'])){
                                        if($fEntMst->value == $params['powerpointSkill']){
                                            $powerpointSkillValue = $fEntMst->name;
                                            $section2 = true;
                                        }
                                    }
                                    if(isset($params['webSkill'])){
                                        if($fEntMst->value == $params['webSkill']){
                                            $webSkillValue = $fEntMst->name;
                                            $section2 = true;
                                        }
                                    }
                                }
                                if(isset($params['otherPCSkill'])){
                                    $section2 = true;
                                }
                                if(isset($params['qualification'])){
                                    $section2 = true;
                                }

                                // section3
                                $colNm = 'changeNumber';
                                if(isset($params[$colNm])) {
                                    foreach($fEntApplyMasters->changeCntMst as $fEntMst){
                                        if((string)$fEntMst->value === (string)$params[$colNm]){
                                            $arrayMultiParams[$colNm] = $fEntMst->name;
                                            $section3 = true;
                                            break;
                                        }
                                    }
                                }

                                $keyName = 'occupation';
                                for($i=1;$i<=5;$i++){
                                    $colNm = $keyName.$i;
                                    if(isset($params[$colNm])) {
                                        foreach($fEntApplyMasters->occupationGroupMst as $parentName => $fEntMst){
                                            foreach($fEntMst As $key => $value) {
                                                if((string)$key === (string)$params[$colNm]){
                                                    $arrayMultiParams[$colNm] = $value;
                                                    $section3 = true;
                                                    break 2;
                                                }
                                            }
                                        }
                                    }
                                }

                                $keyName = 'period';
                                for($i=1;$i<=5;$i++){
                                    $colNm = $keyName.$i;
                                    if(isset($params[$colNm])) {
                                        foreach($fEntApplyMasters->expYearMst as $fEntMst){
                                            if((string)$fEntMst->value === (string)$params[$colNm]){
                                                $arrayMultiParams[$colNm] = $fEntMst->name;
                                                $section3 = true;
                                                break;
                                            }
                                        }
                                    }
                                }

                                $keyName = 'industry';
                                for($i=1;$i<=3;$i++){
                                    $colNm = $keyName.$i;
                                    if(isset($params[$colNm])) {
                                        foreach($fEntApplyMasters->gyokaiMst as $fEntMst){
                                            if((string)$fEntMst->value === (string)$params[$colNm]){
                                                $arrayMultiParams[$colNm] = $fEntMst->name;
                                                $section3 = true;
                                                break;
                                            }
                                        }
                                    }
                                }

                                $colNm = 'managementExperience';
                                if(isset($params[$colNm])) {
                                    if((string)$params[$colNm] === '0') {
                                        $arrayMultiParams[$colNm] = 'なし';
                                        $section3 = true;
                                    }
                                    if((string)$params[$colNm] == '1') {
                                        $arrayMultiParams[$colNm] = 'あり';
                                        $section3 = true;
                                    }
                                }

                                $colNm = 'managementNumber';
                                if(isset($params[$colNm])) {
                                    foreach($fEntApplyMasters->mngCntMst as $fEntMst){
                                        if((string)$fEntMst->value === (string)$params[$colNm]){
                                            $arrayMultiParams[$colNm] = $fEntMst->name;
                                            $section3 = true;
                                            break;
                                        }
                                    }
                                }

                                $isOpenWorkExperience = false;
                                foreach($names as $name) {
                                    if(isset($params['companyName'.$name]) ||
                                      (isset($params['startYear'.$name]) && isset($params['startMonth'.$name]))||
                                      (isset($params['endYear'.$name]) && isset($params['endMonth'.$name])) ||
                                      isset($params['employmentStatus'.$name]) ||
                                      isset($params['jobDescription'.$name])) {
                                        $isOpenWorkExperience = true;
                                        $section3 = true;
                                        break;
                                    }
                                }

                                $keyName = 'employmentStatus';
                                foreach($names as $name){
                                    $colNm = $keyName.$name;
                                    if(isset($params[$colNm])) {
                                        foreach($fEntApplyMasters->koyKeitaiMst as $fEntMst){
                                            if((string)$fEntMst->value === (string)$params[$colNm]){
                                                $arrayMultiParams[$colNm] = $fEntMst->name;
                                                $section3 = true;
                                                break;
                                            }
                                        }
                                    }
                                }

                                //カスタム項目の入力値の変換処理
                                $customConfirmList = array();
                                /* @var $arrayCustom */
                                if($arrayCustom && count($arrayCustom)>0) {
                                    foreach($arrayCustom As $name => $rules) {
                                        if(isset($params[$name])) {
                                            if($rules['fieldType'] === 'input') {
                                                $customConfirmList[$rules['section']][$name]['value'] = $params[$name];
                                                $customConfirmList[$rules['section']][$name]['hidden'] = $rules['hidden'];
                                            }
                                            if($rules['fieldType'] === 'select') {
                                                $customConfirmList[$rules['section']][$name]['value'] = $rules['master'][$params[$name]]??null;
                                            }
                                        }
                                    }
                                }

                                $customSection2 = false;
                                $customSection3 = false;
                                $customSection4 = false;

                                if(isset($customConfirmList['skill']) && count($customConfirmList['skill'])>0) {
                                    $customSection2 = true;
                                }

                                if(isset($customConfirmList['career']) && count($customConfirmList['career'])>0) {
                                    $customSection3 = true;
                                }

                                if(isset($customConfirmList['others']) && count($customConfirmList['others'])>0) {
                                    $customSection4 = true;
                                }

                            }

                        @endphp

                                <section>
                                    <table  class="body open">
                                        <tbody>
                                        @foreach($applyConfirmFormList['profile'] As $groupName => $list)
                                        @switch($groupName)
                                            @case('name')
                                            @if(isset($params['lastName']) || isset($params['firstName']))
                                            <tr class="{{($groupName)}}">
                                                <th>氏名</th>
                                                <td>
                                                    {{$params['lastName'] ?? '' }} {{$params['firstName'] ?? '' }}
                                                </td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('nameRuby')
                                            @if(isset($params['lastKana']) || isset($params['firstKana']))
                                            <tr class="{{($groupName)}}">
                                                <th>氏名（カナ）</th>
                                                <td>
                                                    {{$params['lastKana'] ?? '' }}　{{$params['firstKana'] ?? '' }}
                                                </td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('birthday')
                                            @php
                                            $isTrueDate = true;
                                            @endphp
                                            @if(isset($params['dobYear']) || isset($params['dobMonth']) || isset($params['dobDay']))
                                            @php
                                            /* @var $params */
                                            if(!checkdate((int)$params['dobMonth']??null,(int)$params['dobDay']??null,(int)$params['dobYear']??null)) {
                                                $isTrueDate = false;
                                            }
                                            @endphp
                                            <tr class="{{($groupName)}}">
                                                <th>生年月日</th>
                                                <td>
                                                    @if($isTrueDate)
                                                    {{$params['dobYear'] ?? '' }}年 {{$params['dobMonth'] ?? '' }}月 {{$params['dobDay'] ?? '' }}日
                                                    @else
                                                        <span class="error">生年月日の形式が正しくありません</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('gender')
                                            @if(isset($genderValue))
                                            <tr class="{{($groupName)}}">
                                                <th>性別</th>
                                                <td>
                                                    {{$genderValue ?? '' }}
                                                </td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('address')
                                            @if(isset($params['zipCode']) || isset($prefectureValue) || isset($cityValue) || isset($params['street']))
                                            <tr class="{{($groupName)}}">
                                                <th>現在の住所</th>
                                                <td>
                                                    <dl>
                                                        @if(isset($params['zipCode']))
                                                        <div class="multi-item">
                                                            <dt>郵便番号</dt>
                                                            <dd>{{$params['zipCode'] ?? '' }}</dd>
                                                        </div>
                                                        @endif
                                                        @if(isset($prefectureValue))
                                                        <div class="multi-item">
                                                            <dt>都道府県</dt>
                                                            <dd>{{$prefectureValue ?? '' }}</dd>
                                                        </div>
                                                        @endif
                                                        @if(isset($cityValue))
                                                        <div class="multi-item">
                                                            <dt>市区町村</dt>
                                                            <dd>{{$cityValue ?? '' }}</dd>
                                                        </div>
                                                        @endif
                                                        @if(isset($params['street']))
                                                        <div class="multi-item">
                                                            <dt>以降の住所</dt>
                                                            <dd>{{$params['street'] ?? '' }}</dd>
                                                        </div>
                                                        @endif
                                                    </dl>
                                                </td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('telNumber')
                                            @if(isset($params['telNumber']))
                                            <tr class="{{($groupName)}}">
                                                <th>電話番号</th>
                                                <td>
                                                    {{$params['telNumber'] ?? '' }}
                                                </td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('mailAddress')
                                            @if(isset($params['mailAddress']))
                                            <tr class="{{($groupName)}}">
                                                <th>メールアドレス</th>
                                                <td>
                                                    {{$params['mailAddress'] ?? '' }}
                                                </td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('currentOccupation')
                                            @if(isset($currentOccupationValue))
                                            <tr class="{{($groupName)}}">
                                                <th>現在の職業</th>
                                                <td>{{$currentOccupationValue ?? '' }}</td>
                                            </tr>
                                            @endif
                                            @break

                                            @default
                                            @if(isset($customConfirmList['profile'][$groupName]))
                                            <tr class="{{($groupName)}}@if(isset($customConfirmList['profile'][$groupName]['hidden']) && $customConfirmList['profile'][$groupName]['hidden']) hidden @endif">
                                                <th>{{($list['label'])}}</th>
                                                <td>
                                                    {{$customConfirmList['profile'][$groupName]['value'] ?? '' }}
                                                </td>
                                            </tr>
                                            @endif
                                            @break
                                        @endswitch
                                        @endforeach

                                        </tbody>
                                    </table>
                                </section>

                                @if($section2 || $customSection2)

                                @php
                                    $isTableHidden = false;
                                @endphp

                                @if((!$section2) && $customSection2)
                                    {{--カスタム項目のみが渡ってきた場合の処理--}}
                                    @foreach($customConfirmList['skill'] As $name => $rules)
                                        @if(isset($rules['hidden']) && $rules['hidden'])
                                            @php
                                                $isTableHidden = true;
                                            @endphp
                                        @else
                                            @php
                                                $isTableHidden = false; /*一つでもhiddenでないものが存在する場合、非表示フラグを解除する*/
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif

                                <section>
                                    <table  class="body {{$isTableHidden ? 'hidden' : 'open'}}">
                                        <tbody>
                                        @foreach($applyConfirmFormList['skill'] As $groupName => $list)
                                        @switch($groupName)
                                            @case('language')
                                            @if(isset($englishConversationValue) || isset($businessEnglishValue) || isset($params['toeicScore']) || isset($params['toeflScore']) || isset($stepScoreValue) || isset($otherLanguageValue) || isset($otherConversationValue) || isset($otherBusinessValue))
                                            <tr class="{{($groupName)}}">
                                                <th>語学</th>
                                                <td>
                                                    <dl>
                                                    @foreach($list As $fieldName => $index)
                                                        @switch($fieldName)

                                                        @case('englishConversation')
                                                        @if(isset($englishConversationValue))
                                                        <div class="multi-item">
                                                            <dt>英語会話</dt>
                                                            <dd>{{$englishConversationValue}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('businessEnglish')
                                                        @if(isset($businessEnglishValue))
                                                        <div class="multi-item">
                                                            <dt>英語業務</dt>
                                                            <dd>{{$businessEnglishValue}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('toeicScore')
                                                        @if(isset($params['toeicScore']) && ($params['toeicScore'] !== ''))
                                                        <div class="multi-item">
                                                            <dt>TOEIC</dt>
                                                            <dd>{{$params['toeicScore']}}点</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('toeflScore')
                                                        @if(isset($params['toeflScore']) && ($params['toeflScore'] !== ''))
                                                        <div class="multi-item">
                                                            <dt>TOEFL</dt>
                                                            <dd>{{$params['toeflScore']}}点</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('stepScore')
                                                        @if(isset($stepScoreValue))
                                                        <div class="multi-item">
                                                            <dt>英検</dt>
                                                            <dd>{{$stepScoreValue}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('otherLanguage')
                                                        @if(isset($otherLanguageValue))
                                                        <div class="multi-item">
                                                            <dt>その他言語</dt>
                                                            <dd>{{$otherLanguageValue}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('otherConversation')
                                                        @if(isset($otherConversationValue))
                                                        <div class="multi-item">
                                                            <dt>その他会話</dt>
                                                            <dd>{{$otherConversationValue}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('otherBusiness')
                                                        @if(isset($otherBusinessValue))
                                                        <div class="multi-item">
                                                            <dt>その他業務</dt>
                                                            <dd>{{$otherBusinessValue}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @default
                                                        @break
                                                        @endswitch
                                                    @endforeach
                                                    </dl>
                                                </td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('pcSkill')
                                            @if(isset($wordSkillValue) || isset($excelSkillValue) || isset($accessSkillValue) || isset($powerpointSkillValue) || isset($webSkillValue) || isset($params['otherPCSkill']))
                                            <tr class="{{($groupName)}}">
                                                <th>PCスキル</th>
                                                <td>
                                                    <dl>
                                                    @foreach($list As $fieldName => $index)
                                                        @switch($fieldName)

                                                        @case('wordSkill')
                                                        @if(isset($wordSkillValue))
                                                        <div class="multi-item">
                                                            <dt>Word</dt>
                                                            <dd>{{$wordSkillValue}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('excelSkill')
                                                        @if(isset($excelSkillValue))
                                                        <div class="multi-item">
                                                            <dt>Excel</dt>
                                                            <dd>{{$excelSkillValue}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('accessSkill')
                                                        @if(isset($accessSkillValue))
                                                        <div class="multi-item">
                                                            <dt>Access</dt>
                                                            <dd>{{$accessSkillValue}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('powerpointSkill')
                                                        @if(isset($powerpointSkillValue))
                                                        <div class="multi-item">
                                                            <dt>PowerPoint</dt>
                                                            <dd>{{$powerpointSkillValue}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('webSkill')
                                                        @if(isset($webSkillValue))
                                                        <div class="multi-item">
                                                            <dt>WEB関連</dt>
                                                            <dd>{{$webSkillValue}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('otherPCSkill')
                                                        @if(isset($params['otherPCSkill']))
                                                        <dt>その他PCスキル</dt>
                                                        <dd>{!! nl2br(e($params['otherPCSkill'])) !!}</dd>
                                                        @endif
                                                        @break

                                                        @default
                                                        @break
                                                        @endswitch
                                                    @endforeach
                                                    </dl>
                                                </td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('qualification')
                                            @if(isset($params['qualification']))
                                            <tr class="{{($groupName)}}">
                                                <th>資格</th>
                                                <td>{!! nl2br(e($params['qualification'])) !!}</td>
                                            </tr>
                                            @endif
                                            @break

                                            @default
                                            @if(isset($customConfirmList['skill'][$groupName]))
                                            <tr class="{{($groupName)}}@if(isset($customConfirmList['skill'][$groupName]['hidden']) && $customConfirmList['skill'][$groupName]['hidden']) hidden @endif">
                                                <th>{{($list['label'])}}</th>
                                                <td>
                                                    {{$customConfirmList['skill'][$groupName]['value'] ?? '' }}
                                                </td>
                                            </tr>
                                            @endif
                                            @break
                                        @endswitch
                                        @endforeach

                                        </tbody>
                                    </table>
                                </section>
                                @endif

                                @if($section3 || $customSection3)

                                @php
                                    $isTableHidden = false;
                                @endphp

                                @if((!$section3) && $customSection3)
                                    {{--カスタム項目のみが渡ってきた場合の処理--}}
                                    @foreach($customConfirmList['career'] As $name => $rules)
                                        @if(isset($rules['hidden']) && $rules['hidden'])
                                            @php
                                                $isTableHidden = true;
                                            @endphp
                                        @else
                                            @php
                                                $isTableHidden = false; /*一つでもhiddenでないものが存在する場合、非表示フラグを解除する*/
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif

                                <section>
                                    <table  class="body {{$isTableHidden ? 'hidden' : 'open'}}">
                                        <tbody>
                                        @foreach($applyConfirmFormList['career'] As $groupName => $list)
                                        @switch($groupName)
                                            @case('changeNumber')
                                            @if(isset($arrayMultiParams['changeNumber']))
                                            <tr class="{{($groupName)}}">
                                                <th>転職回数</th>
                                                <td>{{$arrayMultiParams['changeNumber']}}</td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('occupation')
                                            @if(isset($arrayMultiParams['occupation1']) || isset($arrayMultiParams['occupation2']) ||  isset($arrayMultiParams['occupation3']) || isset($arrayMultiParams['occupation4']) || isset($arrayMultiParams['occupation5']))
                                            <tr class="jobExperience">
                                                <th>経験職種</th>
                                                <td>
                                                    <dl>
                                                        @for($i=1;$i<=5;$i++)
                                                            @if(isset($arrayMultiParams['occupation'.$i]))
                                                                <div class="multi-item">
                                                                    <dt>{{($arrayMultiParams['occupation'.$i])}}</dt>
                                                                    @if(isset($arrayMultiParams['period'.$i]))
                                                                        <dd>{{($arrayMultiParams['period'.$i])}}</dd>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        @endfor
                                                    </dl>
                                                </td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('industry')
                                            @if(isset($arrayMultiParams['industry1']) || isset($arrayMultiParams['industry2']) || isset($arrayMultiParams['industry3']))
                                            <tr class="{{($groupName)}}">
                                                <th>経験業界</th>
                                                <td>
                                                    <ul>
                                                        @for($i=1;$i<=3;$i++)
                                                            @if(isset($arrayMultiParams['industry'.$i]))
                                                                <li>{{($arrayMultiParams['industry'.$i])}}</li>
                                                            @endif
                                                        @endfor
                                                    </ul>
                                                </td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('managementExperience')
                                            @if(isset($arrayMultiParams['managementExperience']))
                                            <tr class="{{($groupName)}}">
                                                <th>マネージメント経験</th>
                                                <td>{{$arrayMultiParams['managementExperience']}}</td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('managementNumber')
                                            @if(isset($arrayMultiParams['managementNumber']))
                                            <tr class="{{($groupName)}}">
                                                <th>マネージメント人数</th>
                                                <td>{{$arrayMultiParams['managementNumber']}}</td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('jobHistories')
                                            @if($isOpenWorkExperience)
                                            <tr class="workExperience">
                                                <th>職務経歴</th>
                                                <td>
                                                @foreach($names as $name)
                                                @if(isset($params['companyName'.$name]) || (isset($params['startYear'.$name]) or isset($params['startMonth'.$name])) || (isset($params['endYear'.$name]) or isset($params['endMonth'.$name])) || isset($params['employmentStatus'.$name]) || isset($params['jobDescription'.$name]))
                                                    <div class="workExperienceBody">
                                                        <dl>
                                                            <div class="multi-item">
                                                                <dt>会社名</dt>
                                                                <dd>{{($params['companyName'.$name]??'')}}</dd>
                                                            </div>
                                                            <div class="multi-item">
                                                                <dt>勤務開始年月</dt>
                                                                @if(isset($params['startYear'.$name]) && isset($params['startMonth'.$name])) {{--年月どちらかのみの場合表示しない--}}
                                                                <dd>{{($params['startYear'.$name])}}年{{($params['startMonth'.$name])}}月</dd>
                                                                @endif
                                                            </div>
                                                            <div class="multi-item">
                                                                <dt>勤務終了年月</dt>
                                                                @if(isset($params['endYear'.$name]) && isset($params['endMonth'.$name])) {{--年月どちらかのみの場合表示しない--}}
                                                                <dd>{{($params['endYear'.$name])}}年{{($params['endMonth'.$name])}}月</dd>
                                                                @endif
                                                            </div>
                                                            <div class="multi-item">
                                                                <dt>雇用形態</dt>
                                                                <dd>{{($arrayMultiParams['employmentStatus'.$name]??'')}}</dd>
                                                            </div>
                                                            <dt>職務内容</dt>
                                                            <dd>{!! nl2br(e($params['jobDescription'.$name])) !!}</dd>
                                                        </dl>
                                                    </div>
                                                @endif
                                                @endforeach
                                                </td>
                                            </tr>
                                            @endif
                                            @break

                                            @default
                                            @if(isset($customConfirmList['career'][$groupName]))
                                            <tr class="{{($groupName)}}@if(isset($customConfirmList['career'][$groupName]['hidden']) && $customConfirmList['career'][$groupName]['hidden']) hidden @endif">
                                                <th>{{($list['label'])}}</th>
                                                <td>
                                                    {{$customConfirmList['career'][$groupName]['value'] ?? '' }}
                                                </td>
                                            </tr>
                                            @endif
                                            @break
                                        @endswitch
                                        @endforeach
                                        </tbody>
                                    </table>
                                </section>
                                @endif

                                @if(isset($params['pr']))
                                <section>
                                    <table  class="body open">
                                        <tbody>
                                        <tr class="pr">
                                            <th>自己PR</th>
                                            <td>{!! nl2br(e($params['pr'])) !!}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </section>
                                @endif

                                @if($section4 || $customSection4)

                                @php
                                $isTableHidden = false;
                                @endphp

                                @if((!$section4) && $customSection4)
                                {{--カスタム項目のみが渡ってきた場合の処理--}}
                                @foreach($customConfirmList['others'] As $name => $rules)
                                    @if(isset($rules['hidden']) && $rules['hidden'])
                                        @php
                                        $isTableHidden = true;
                                        @endphp
                                    @else
                                        @php
                                        $isTableHidden = false; /*一つでもhiddenでないものが存在する場合、非表示フラグを解除する*/
                                        @endphp
                                    @endif
                                @endforeach
                                @endif

                                <section>
                                    <table class="body {{$isTableHidden ? 'hidden' : 'open'}}">
                                        <tbody>
                                        @foreach($applyConfirmFormList['others'] As $groupName => $list)
                                        @switch($groupName)

                                            @case('maritalStatus')
                                            @if(isset($maritalStatusValue))
                                            <tr class="{{($groupName)}}">
                                                <th>結婚</th>
                                                <td>{{($maritalStatusValue)}}</td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('currentAddress')
                                            @if(isset($params['station']))
                                            <tr class="address">
                                                <th>現在の住所</th>
                                                <td>
                                                    <dl>
                                                    @foreach($list As $fieldName => $index)
                                                    @switch($fieldName)
                                                        @case('station')
                                                        @if(isset($params[$fieldName]))
                                                        <div class="multi-item">
                                                            <dt>最寄駅</dt>
                                                            <dd>{{($params['station'])}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @default
                                                        @break
                                                    @endswitch
                                                    @endforeach
                                                    </dl>
                                                </td>
                                            </tr>
                                            @endif
                                            @break

                                            @case('educationBackground')
                                            @if(isset($educationLevelValue) || isset($params['graduationYear']) || isset($graduationStatusValue) || isset($params['schoolName']) || isset($params['departmentName']))
                                            <tr class="{{($groupName)}}">
                                                <th>最終学歴</th>
                                                <td>
                                                    <dl>
                                                    @foreach($list As $fieldName => $index)
                                                    @switch($fieldName)
                                                        @case('educationLevel')
                                                        @if(isset($educationLevelValue))
                                                        <div class="multi-item">
                                                            <dt>学校区分</dt>
                                                            <dd>{{($educationLevelValue)}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('graduationYear')
                                                        @if(isset($params['graduationYear']))
                                                        <div class="multi-item">
                                                            <dt>年度</dt>
                                                            <dd>{{($params['graduationYear'])}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('graduationStatus')
                                                        @if(isset($graduationStatusValue))
                                                        <div class="multi-item">
                                                            <dt>状態</dt>
                                                            <dd>{{($graduationStatusValue)}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('schoolName')
                                                        @if(isset($params['schoolName']))
                                                        <div class="multi-item">
                                                            <dt>学校名</dt>
                                                            <dd>{{($params['schoolName'])}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @case('departmentName')
                                                        @if(isset($params['departmentName']))
                                                        <div class="multi-item">
                                                            <dt>学部／学科名</dt>
                                                            <dd>{{($params['departmentName'])}}</dd>
                                                        </div>
                                                        @endif
                                                        @break

                                                        @default
                                                        @break
                                                    @endswitch
                                                    @endforeach
                                                    </dl>
                                                </td>
                                            </tr>
                                            @endif
                                            @break

                                            @default
                                            @if(isset($customConfirmList['others'][$groupName]))
                                            <tr class="{{($groupName)}}@if(isset($customConfirmList['others'][$groupName]['hidden']) && $customConfirmList['others'][$groupName]['hidden']) hidden @endif">
                                                <th>{{($list['label'])}}</th>
                                                <td>
                                                    {{$customConfirmList['others'][$groupName]['value'] ?? '' }}
                                                </td>
                                            </tr>
                                            @endif
                                            @break
                                        @endswitch
                                        @endforeach
                                        </tbody>
                                    </table>
                                </section>
                                @endif

                                <aside class="applyBtns">
                                    <a class="back" href="javascript:void(0)" id="applyback">もどる</a>
                                    <button class="submitApply" type="submit" value="" {{$isTrueDate ? '' : 'disabled'}}>この内容で応募</button>
                                </aside>
                            </form>
                        </section><!-- .mod_apply_confirm -->

                    </section>
                </div>
            </div>
        </div>
    </div>

    <script>
        function pageBack(e) {
            e.preventDefault();
            let form = document.getElementById('applyConfirmForm');
            form.action = '{{Route('top')}}/apply/{{$fEntJobDetail->jobId}}';
            form.submit();
        }

        $('#applyback').on('click', function(event) {
            pageBack(event);
        });
    </script>

    @else
    <div id="applyConfirm">
        <x-display.notFoundJobDetail />
    </div>
    @endif

@endsection
