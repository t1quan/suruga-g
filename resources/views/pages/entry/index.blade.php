@php
    $registFormList = array();
    $formRegistSettings = array();
    $isTrueConfig = true;

    /** @var $page */
    $path = $page->id;
    $fEntConfig = $page->fEntConfig;
    if(isset($fEntConfig->backendSettings['form'][$path]) && count($fEntConfig->backendSettings['form'][$path])>0) {

        foreach($fEntConfig->backendSettings['form'][$path] As $sectionName => $items) {

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
                    $formRegistSettings[$sectionName][$groupName][$fieldName] = $rules;
                }
            }
        }

        //カスタム項目の格納処理
        if(isset($fEntConfig->backendSettings['form'][$path]['custom']) && count($fEntConfig->backendSettings['form'][$path]['custom'])>0) {
            foreach($fEntConfig->backendSettings['form'][$path]['custom'] As $sectionName => $items) {
                foreach($items As $groupName => $list) {
                    foreach($list As $fieldName => $rules) {
                        $formRegistSettings[$sectionName][$groupName][$fieldName] = $rules;
                    }
                }
            }
        }

        foreach($formRegistSettings AS $sectionName => $items) {

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
                $registFormList[$sectionName][$groupName] = $list;
                $registFormList[$sectionName][$groupName]['required'] = $isRequired; //グループの中に1つでも必須項目があれば必須の表示をする
                unset($registFormList[$sectionName][$groupName]['index']);
            }
        }
    }
    else {
        //config内で応募フォーム設定の記載がない場合、デフォルトの設定を反映する
        $registFormList = config('applyForm');
    }
@endphp

@extends('layouts.app')

@section('title', $page->title ?? '')

@section('content')

    @if($isTrueConfig)
        <script src="{{ asset('js/validation.min.js') }}" defer></script>
        <div id="{{$path}}Form">
            <div id="wrapJobDetail">
                <div id="{{$path}}Area">
                    <header>
                        <div class="entry-title">
                            <div class="en">ENTRY</div>
                            <div class="ja">WEBスタッフ登録</div>
                        </div>
                        <div class="entry-introduction">
                            お気軽にご登録ください！
                        </div>
                    </header>
                    <div class="inner">
                        <section class="mod_jobDetailJob">
                            <section class="mod_apply">
                                <form method="post" action="{{$page->action}}" class="form01">
                                    @csrf

{{--                                    <x-molecules.input id="job_id" type="hidden" name="job_id" :value="old('job_id' , $fEntJobDetail->jobId)" />--}}
                                    <x-molecules.input id="agree" type="hidden" name="agree" :value="old('agree' , $agree ?? '')" />

                                    <input type="hidden" id="open" value="1">

                                    @php
                                        $isOpen = true;
                                    @endphp

                                    @if(isset($registFormList['profile']) && count($registFormList['profile'])>0)
                                        <x-entryForm.profile :fEntUserApplyInfo="$fEntUserApplyInfo" :fEntApplyMasters="$fEntApplyMasters" :items="$registFormList['profile']" :isOpen=$isOpen />
                                    @endif

{{--                                    <x-entryForm.privacyPolicy agreeId="agree_flg2" :fEntJobDetail="$fEntJobDetail" :fEntConfig="$page->fEntConfig" />--}}

                                    @php
                                        $isOpen = false;
                                    @endphp

                                    @if(isset($registFormList['skill']) && count($registFormList['skill'])>0)
                                        <x-entryForm.skill :fEntUserApplyInfo="$fEntUserApplyInfo" :fEntApplyMasters="$fEntApplyMasters" :items="$registFormList['skill']" :isOpen=$isOpen />
                                    @endif

                                    @if(isset($registFormList['career']) && count($registFormList['career'])>0)
                                        <x-entryForm.career :fEntUserApplyInfo="$fEntUserApplyInfo" :fEntApplyMasters="$fEntApplyMasters" :items="$registFormList['career']" :isOpen=$isOpen />
                                    @endif

                                    @if(isset($registFormList['pr']) && count($registFormList['pr'])>0)
                                        <x-entryForm.jikoPr :fEntUserApplyInfo="$fEntUserApplyInfo" :fEntApplyMasters="$fEntApplyMasters" :items="$registFormList['pr']" :isOpen=$isOpen />
                                    @endif

                                    @if(isset($registFormList['others']) && count($registFormList['others'])>0)
                                        <x-entryForm.others :fEntUserApplyInfo="$fEntUserApplyInfo" :fEntApplyMasters="$fEntApplyMasters" :items="$registFormList['others']" :isOpen=$isOpen />
                                    @endif

                                    <x-entryForm.privacyPolicy agreeId="agree_flg1" :fEntJobDetail="$fEntJobDetail" :fEntConfig="$page->fEntConfig" />
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
                } else {
                    $('#agree').val('1');
                    $('.agree').addClass('is-checked');
                    $('button[type="submit"]').removeAttr('disabled');
                }
            }
            $(function(){
                document.getElementById('agree_flg1').addEventListener('click', clickAgree);
                // document.getElementById('agree_flg2').addEventListener('click', clickAgree);
            })
        </script>
    @else
        {{--応募フォーム項目設定不備--}}
        <x-apply.applyMaintenance />
    @endif

@endsection
