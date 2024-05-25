@extends('layouts.app')

@section('title', $page->title ?? '')

@section('content')

    @php
        /* @var $page */
        $path = str_replace('_thanks', '', $page->id);
    @endphp

    @if(isset($fEntJob))

    <div id="{{$path}}Thanks">
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
                    <div class="step_guide">
                        WEBスタッフ登録 送信完了
                    </div>
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
                            <div class="notice">
                                ご応募ありがとうございます。受付いたしました。 <br />
                                応募時に入力されたメールアドレス宛てに、応募完了の案内メールを送信しました。<br />
                                @if(isset($fEntConfig->corporations[$corpIndex]))
                                5分以上経ってもメールが届かない場合は入力アドレス誤記等の可能性がありますので、<br />
                                ご面倒ですが以下までご連絡頂くか、再度ご応募下さい。<br />
                                @if((isset($fEntConfig->corporations[$corpIndex]['tel'])) || (isset($fEntConfig->corporations[$corpIndex]['corpFullName'])))
                                    <div class="contact">
                                        @if(isset($fEntConfig->corporations[$corpIndex]['corpFullName']))
                                            <p>{{($fEntConfig->corporations[$corpIndex]['corpFullName'])}}</p>
                                        @endif
                                        @if(isset($fEntConfig->corporations[$corpIndex]['tel']) && $fEntConfig->corporations[$corpIndex]['tel'])
                                            <p>TEL：{{($fEntConfig->corporations[$corpIndex]['tel'])}}</p>
                                        @endif
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
    <div id="{{$path}}Thanks">
        <x-display.notFoundJobDetail />
    </div>
    @endif

@endsection
