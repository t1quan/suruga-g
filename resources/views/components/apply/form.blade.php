@props(['fEntJobDetail', 'fEntUserApplyInfo', 'fEntApplyMasters', 'action', 'fEntConfig'])

@php
$agreeLabel = "個人情報の取り扱いに同意する";
$mode = 'apply';
@endphp

@php
$applyFormList = array();
$formApplySettings = array();
$isTrueConfig = true;

/** @var $fEntConfig */
if(isset($fEntConfig->backendSettings['form']['apply']) && count($fEntConfig->backendSettings['form']['apply'])>0) {

    foreach($fEntConfig->backendSettings['form']['apply'] As $sectionName => $items) {

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
                    if($rules['required']) {
                        $isRequired = true;
                    }
                }
                $formApplySettings[$sectionName][$groupName][$fieldName] = $rules;
            }
        }
    }

    //カスタム項目の格納処理
    if(isset($fEntConfig->backendSettings['form']['apply']['custom']) && count($fEntConfig->backendSettings['form']['apply']['custom'])>0) {
        foreach($fEntConfig->backendSettings['form']['apply']['custom'] As $sectionName => $items) {
            foreach($items As $groupName => $list) {
                foreach($list As $fieldName => $rules) {
                    $formApplySettings[$sectionName][$groupName][$fieldName] = $rules;
                }
            }
        }
    }

    foreach($formApplySettings AS $sectionName => $items) {

        $groupIdx = array();
        foreach($items As $groupName => $list) {
            $groupIdx[] = $list['index'] ?? 1;
        }
        array_multisort($groupIdx, SORT_ASC, SORT_NUMERIC, $items);

        foreach($items As $groupName => $list) {
            $isRequired = false; //必須項目表示を初期化
            $idx = array();
            foreach($list As $fieldName => $rules) {
                $idx[] = $rules['index'] ?? 1;

                 if(isset($rules['required']) && $rules['required']) {
                    $isRequired = true;
                }
            }
            array_multisort($idx, SORT_ASC, SORT_NUMERIC, $list);
            $applyFormList[$sectionName][$groupName] = $list;
            $applyFormList[$sectionName][$groupName]['required'] = $isRequired; //グループの中に1つでも必須項目があれば必須の表示をする
            unset($applyFormList[$sectionName][$groupName]['index']);
        }
    }
}
else {
    //config内で応募フォーム設定の記載がない場合、デフォルトの設定を反映する
    $applyFormList = config('applyForm');
}

@endphp

@if($isTrueConfig)
<script src="{{ asset('js/validation.min.js') }}" defer></script>
<div id="applyForm">
    <div id="wrapJobDetail">
        <div id="applyArea">
            <div class="inner">
                <section class="mod_jobDetailJob">
                    <section class="mod_apply">
                        <header>
                            <div class="entry-title">応募情報の入力</div>
                            <div class="apply_navi">
                                <ul><li class="text current">STEP.1<br>応募情報の入力</li><li class="navi_sep">&nbsp;<br>&nbsp;</li><li class="text">STEP.2<br>応募情報の確認</li><li class="navi_sep">&nbsp;<br>&nbsp;</li><li class="text">STEP.3<br>応募完了</li></ul>		</div>
                            <div>
                                <h3>
                                    <a href="{{Route('top')}}/job/{{$fEntJobDetail->jobId}}">{{$fEntJobDetail->corpMei??""}}<br>{{$fEntJobDetail->jobTitle??""}}</a>
                                </h3>
                            </div>
                            <small class="pcLayout"><i class="required">*</i>…必須項目</small>
                        </header>
                        <form method="post" action="{{$action}}" class="form01">
                            @csrf

                            <x-molecules.input id="job_id" type="hidden" name="job_id" :value="old('job_id' , $fEntJobDetail->jobId)" />
                            <x-molecules.input id="agree" type="hidden" name="agree" :value="old('agree' , $agree ?? '')" />

                            <input type="hidden" id="open" value="1">

                            @php
                                $isOpen = true;
                            @endphp

                            @if(isset($applyFormList['profile']) && count($applyFormList['profile'])>0)
                                <x-form.profile :fEntUserApplyInfo="$fEntUserApplyInfo" :fEntApplyMasters="$fEntApplyMasters" :items="$applyFormList['profile']" :isOpen=$isOpen />
                            @endif

                            <x-form.privacyPolicy agreeId="agree_flg2" :fEntJobDetail="$fEntJobDetail" :fEntConfig="$fEntConfig" />

                            @php
                                $isOpen = false;
                            @endphp

                            @if(isset($applyFormList['skill']) && count($applyFormList['skill'])>0)
                                <x-form.skill :fEntUserApplyInfo="$fEntUserApplyInfo" :fEntApplyMasters="$fEntApplyMasters" :items="$applyFormList['skill']" :isOpen=$isOpen />
                            @endif

                            @if(isset($applyFormList['career']) && count($applyFormList['career'])>0)
                                <x-form.career :fEntUserApplyInfo="$fEntUserApplyInfo" :fEntApplyMasters="$fEntApplyMasters" :items="$applyFormList['career']" :isOpen=$isOpen />
                            @endif

                            @if(isset($applyFormList['pr']) && count($applyFormList['pr'])>0)
                                <x-form.jikoPr :fEntUserApplyInfo="$fEntUserApplyInfo" :fEntApplyMasters="$fEntApplyMasters" :items="$applyFormList['pr']" :isOpen=$isOpen />
                            @endif

                            @if(isset($applyFormList['others']) && count($applyFormList['others'])>0)
                                <x-form.others :fEntUserApplyInfo="$fEntUserApplyInfo" :fEntApplyMasters="$fEntApplyMasters" :items="$applyFormList['others']" :isOpen=$isOpen />
                            @endif

                            <x-form.privacyPolicy agreeId="agree_flg1" :fEntJobDetail="$fEntJobDetail" :fEntConfig="$fEntConfig" />
                        </form>
                    </section><!-- .mod_apply -->

                </section>
            </div>
        </div>
    </div>

</div>

<script>
    function clickAgree(){
        if ($('#agree').val() == '1') {
            $('#agree').val('');
            $('.agree').removeClass('is-checked');
            $('button[type="submit"]').attr('disabled','disabled');
            $('button[type="submit"]').addClass('locked');
        } else {
            $('#agree').val('1');
            $('.agree').addClass('is-checked');
            $('button[type="submit"]').removeAttr('disabled');
            $('button[type="submit"]').removeClass('locked');
        }
    }
    $(function(){
        document.getElementById('agree_flg1').addEventListener('click', clickAgree);
        document.getElementById('agree_flg2').addEventListener('click', clickAgree);
    })
</script>
@else
    {{--応募フォーム項目設定不備--}}
    <x-apply.applyMaintenance />
@endif
