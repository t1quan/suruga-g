@extends('layouts.app')

@section('title', $page->title ?? '')

@section('content')

    @if(isset($fEntJob))

    <div id="applyThanks">
        <div id="wrapJobDetail">
            <div id="applyArea">
                <div class="inner">
                    <section class="mod_jobDetailJob">
                        @php
                            /** @var $fEntJob */
                            /** @var $page */
                            $corpIndex = null;
                            $fEntConfig = $page->fEntConfig;
                            if($fEntConfig) {
                                $arrayCorpCd = $fEntConfig->frontendSettings['arrayCorpCd']??null;
                                if($arrayCorpCd && count($arrayCorpCd)>0) {
                                   foreach($fEntConfig->frontendSettings['arrayCorpCd'] As $index => $corpCd) {
                                        if($corpCd === $fEntJob->corpCd) {
                                            $corpIndex = $index;
                                            break;
                                        }
                                    }
                                }
                            }
                        @endphp

                        <section class="mod_apply_thanks">
                            <header>
                                <div class="entry-title">応募完了</div>
                                <div class="apply_navi">
                                    <ul><li class="text">STEP.1<br>応募情報の入力</li><li class="navi_sep">&nbsp;<br>&nbsp;</li><li class="text">STEP.2<br>応募情報の確認</li><li class="navi_sep">&nbsp;<br>&nbsp;</li><li class="text current">STEP.3<br>応募完了</li></ul>		</div>
                                <div>
                                    <h3>
                                        <a href="{{Route('top')}}/job/{{($fEntJob->jobId??'')}}">{{($fEntJob->corpMei??'')}}<br>{{($fEntJob->jobTitle??'')}}</a>
                                    </h3>
                                </div>
                            </header>
                            <div>
                                ご応募ありがとうございます。受付致しました。 <br />
                                応募時に入力されたメールアドレス宛てに、応募完了の案内メールを送信しました。<br />
                                @if(isset($fEntConfig->corporations[$corpIndex]))
                                5分以上経ってもメールが届かない場合は入力アドレス誤記等の可能性がありますので、<br class="PCbr" />ご面倒ですが再度ご応募下さい。<br />
                                @if(isset($fEntConfig->corporations[$corpIndex]['corpFullName']) && $fEntConfig->corporations[$corpIndex]['corpFullName'])
                                <div class="contact">
                                    <p>{{($fEntConfig->corporations[$corpIndex]['corpFullName'])}}</p>
                                </div>
                                @endif
                                @endif
                            </div>
                            <aside class="applyBtns">
                                <a class="goApplyJob" href="{{Route('top')}}/job/{{($fEntJob->jobId??'')}}">応募した求人情報を確認する</a>
                            </aside>
                        </section>

                        {{--「戻る」ボタンによるページバックの防止--}}
                        <script>
                            $(function(){
                                history.pushState(null, null, null);

                                $(window).on("popstate", function(){
                                    history.pushState(null, null, null);
                                });
                                window.onbeforeunload = function(e) {
                                    e.preventDefault();
                                    return false;
                                }
                                $(window).on("popstate", function(e){
                                    e.preventDefault();
                                    return false;
                                });
                            });
                        </script>
                    </section>
                </div>
            </div>
        </div>
    </div>

    @else
    <div id="applyThanks">
        <x-display.notFoundJobDetail />
    </div>
    @endif

@endsection
