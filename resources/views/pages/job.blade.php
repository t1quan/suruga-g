@extends('layouts.app')

@section('title', $page->title ?? '')

@section('content')

    @if(isset($fEntJobDetail))

    @php
    /**@var $page */
    /**@var \App\Models\FEnt\FEntJobDetail $fEntJobDetail */

    $bikoStr = '';
    if($fEntJobDetail->biko) {
        $bikoStr = mb_convert_kana(nl2br(mb_strtoupper($fEntJobDetail->biko)), "KVRA");
    }

    $applyTelNumber = null;
    //電話番号切り替えフラグが立っている、かつ備考欄に応募用TELの記載がある場合のみ、表示する電話番号を切り替える
    if(!(isset($page->fEntConfig->frontendSettings['isTelChanged']) && $page->fEntConfig->frontendSettings['isTelChanged'] && mb_strpos($bikoStr,'応募ＴＥＬ：')!==false)) {
        if(isset($page->fEntConfig->frontendSettings['arrayCorpCd']) && count($page->fEntConfig->frontendSettings['arrayCorpCd'])>0) {
            foreach($page->fEntConfig->frontendSettings['arrayCorpCd'] As $index => $corpCd) {
                if($corpCd === $fEntJobDetail->corpCd) {
                    $applyTelNumber = $page->fEntConfig->corporations[$index]['applyTel']??null; //対応する企業コードの応募用TELを設定する
                    break;
                }
            }
        }
    }
    else { //電話番号切り替え処理
        if(mb_strpos($bikoStr,'＜ｂｒ',mb_strpos($bikoStr,'応募ＴＥＬ：')+6)){ //電話番号の後に改行が含まれる場合
            $applyTelNumber = mb_substr($bikoStr ,
                mb_strpos($bikoStr,'応募ＴＥＬ：')+6,
                mb_strpos($bikoStr,'＜ｂｒ', mb_strpos($bikoStr,'応募ＴＥＬ：')+6) - (mb_strpos($bikoStr,'応募ＴＥＬ：')+6));
        }
        else{
            $applyTelNumber = mb_substr($bikoStr ,mb_strpos($bikoStr,'応募ＴＥＬ：')+6);
        }
        $applyTelNumber = mb_convert_kana($applyTelNumber,'ra');
    }

    @endphp

    <div id="jobDetailContent">
        <div id="wrapJobDetail">
            <div id="jobListArea">
                <div class="inner">
                    <section class="mod_jobDetailJob">
                        <div class="pcLayout">
                            <div class="jobBtns jobTopBtn">
                                <a class="goJoblist" href="">&nbsp;</a>
                            </div>
                            <header>
                                <h1 class="title_bg">{{$fEntJobDetail->jobTitle}}</h1>
                            </header>
                            <div class="horizontalTabBody">
                                <div id="jobone">
                                    <section class="area_header">
                                        <div class="employment">
                                            <i class="indicator{{$fEntJobDetail->koyKeitaiCode}}">{{$fEntJobDetail->koyKeitaiName}}</i>
                                        </div>
                                        @if($fEntJobDetail->updatedAt)
                                        <div class="updated">情報更新日：<x-atoms.date :date="$fEntJobDetail->updatedAt" /></div>
                                        @endif
                                    </section>
                                    <section class="area_introduction">
                                        @if($fEntJobDetail->mainGazoFilePath || $fEntJobDetail->arrayFEntSelfParam)
                                        <div class="introduction_left">
                                            @if($fEntJobDetail->mainGazoFilePath)
                                            <div class="main_gazo">
                                                <img src="{{asset('storage'.$fEntJobDetail->mainGazoFilePath)}}" alt="{{$fEntJobDetail->jobTitle}}">
                                            </div>
                                            <div class="main_text">{!! nl2br(e($fEntJobDetail->mainGazoCaption)) !!}</div>
                                            @endif
                                            @if($fEntJobDetail->arrayFEntSelfParam)
                                            <x-job.selfParam :selfParams="$fEntJobDetail->arrayFEntSelfParam" />
                                            @endif
                                        </div>
                                        @endif
                                        <div class="{{ ($fEntJobDetail->mainGazoFilePath || $fEntJobDetail->arrayFEntSelfParam) ? 'introduction_right' : 'introduction_all' }}">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <th>職種</th>
                                                    <td>{{$fEntJobDetail->jobCategoryGroupName}} > {{$fEntJobDetail->jobCategoryName}}</td>
                                                </tr>
                                                <tr>
                                                    <th>雇用形態</th>
                                                    <td>
                                                        <i class="indicator{{$fEntJobDetail->koyKeitaiCode}}">{{$fEntJobDetail->koyKeitaiName}}</i>
                                                        <br />{!! nl2br(e($fEntJobDetail->koyKeitaiBiko)) !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>給与</th>
                                                    <td>
                                                        @if($fEntJobDetail->kyuyoKbnName && $fEntJobDetail->kyuyoMin)
                                                            【{{$fEntJobDetail->kyuyoKbnName}}】
                                                            <x-atoms.salary :kyuyoMin="$fEntJobDetail->kyuyoMin" :kyuyoMax="$fEntJobDetail->kyuyoMax" dispType="char" />
                                                            <br />
                                                        @endif
                                                        @if($fEntJobDetail->salary)
                                                            【月収例】{!! nl2br(e($fEntJobDetail->salary)) !!}<br />
                                                            <br />
                                                        @endif
                                                        @if($fEntJobDetail->annualSalary)
                                                            【年収例】{!! nl2br(e($fEntJobDetail->annualSalary)) !!}<br />
                                                            <br />
                                                        @endif
                                                        @if($fEntJobDetail->kyuyoBiko)
                                                            {!! nl2br(e($fEntJobDetail->kyuyoBiko)) !!}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if($fEntJobDetail->arrayFEntTokucho)
                                                <tr>
                                                    <th>特徴</th>
                                                    <td>
                                                        <div class="inTokuchoArea">
                                                            @foreach($fEntJobDetail->arrayFEntTokucho as $tokuchoInfo)
                                                                <x-job.tokucho :tokucho="$tokuchoInfo" />
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                                @if($fEntJobDetail->arrayFEntKinmuti)
                                                <tr>
                                                    <th>勤務地</th>
                                                    <td>
                                                        @foreach($fEntJobDetail->arrayFEntKinmuti as $kinmtiInfo)
                                                            <x-job.kinmti :kinmti="$kinmtiInfo" />
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                @endif
                                                @if($fEntJobDetail->workingTimes)
                                                <tr>
                                                    <th>勤務時間</th>
                                                    <td>
                                                        {!! nl2br(e($fEntJobDetail->workingTimes)) !!}
                                                    </td>
                                                </tr>
                                                @endif
                                                @if($fEntJobDetail->holiday)
                                                <tr>
                                                    <th>休日・休暇</th>
                                                    <td>
                                                        {!! nl2br(e($fEntJobDetail->holiday)) !!}
                                                    </td>
                                                </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </section>
                                    <aside class="applyBtns">
                                        <a class="goApply" href="{{Route('top')}}/apply/{{$fEntJobDetail->jobId}}">
                                            @lang('textlist.webApply')
                                            <i class="fas fa-chevron-right"></i>
                                        </a>

                                        @if($applyTelNumber && mb_strlen($applyTelNumber) > 0)
                                        <a class="goApply telDialog" href="#" data-modaltarget="teldal" onclick="gtag('event', 'click', {'event_category': 'links','event_label': 'tel-tap-{{$fEntJobDetail->jobId}}-pc'});">
                                            @lang('textlist.telApply')
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                        @endif

                                        @if($fEntJobDetail->jisyaKoukokuNum)
                                        <x-molecules.favoriteBtn :favoriteList="$favoriteList" device="pc" :code="$fEntJobDetail->jisyaKoukokuNum" :jobId="$fEntJobDetail->jobId" />
                                        @endif

                                        @if($fEntJobDetail->jisyaKoukokuNum)
                                            <div class="adNumField">お仕事No.{{$fEntJobDetail->jisyaKoukokuNum}}</div>
                                        @endif
                                    </aside>
                                    <section class="area_information">
                                        <div class="areaInformationInner">
                                            <div class="catch">{{$fEntJobDetail->catchCopy}}</div>
                                            @if($fEntJobDetail->lead)
                                            <div class="information">
                                                {!! nl2br(e($fEntJobDetail->lead)) !!}
                                            </div>
                                            @endif
                                            @if($fEntJobDetail->subGazo1FilePath || $fEntJobDetail->subGazo2FilePath || $fEntJobDetail->subGazo3FilePath)
                                            <div class="sub_gazo_area">
                                                @if($fEntJobDetail->subGazo1FilePath)
                                                <div class="sub_gazo_box">
                                                    <div class="sub_gazo">
                                                        <p>
                                                            <img class="sub_gazo_image" src="{{asset('storage'.$fEntJobDetail->subGazo1FilePath)}}" alt="{{$fEntJobDetail->jobTitle}}">
                                                        </p>
                                                    </div>
                                                    <div class="sub_text">{!! nl2br(e($fEntJobDetail->subGazo1Caption)) !!}</div>
                                                </div>
                                                @endif
                                                @if($fEntJobDetail->subGazo2FilePath)
                                                    <div class="sub_gazo_box">
                                                        <div class="sub_gazo">
                                                            <p>
                                                                <img class="sub_gazo_image" src="{{asset('storage'.$fEntJobDetail->subGazo2FilePath)}}" alt="{{$fEntJobDetail->jobTitle}}">
                                                            </p>
                                                        </div>
                                                        <div class="sub_text">{!! nl2br(e($fEntJobDetail->subGazo2Caption)) !!}</div>
                                                    </div>
                                                @endif
                                                @if($fEntJobDetail->subGazo3FilePath)
                                                    <div class="sub_gazo_box">
                                                        <div class="sub_gazo">
                                                            <p>
                                                                <img class="sub_gazo_image" src="{{asset('storage'.$fEntJobDetail->subGazo3FilePath)}}" alt="{{$fEntJobDetail->jobTitle}}">
                                                            </p>
                                                        </div>
                                                        <div class="sub_text">{!! nl2br(e($fEntJobDetail->subGazo3Caption)) !!}</div>
                                                    </div>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                        @if($fEntJobDetail->fEntVideo)
                                        <section class="naviMovie">
                                            <div>
                                                @if($fEntJobDetail->fEntVideo->embedIframe)
                                                <div class="naviMovieTitle">職場ナビ動画 公開中！</div>
                                                <div class="naviMovieTag">
                                                    {!! $fEntJobDetail->fEntVideo->embedIframe !!}
                                                </div>
                                                @endif
                                                @if($fEntJobDetail->fEntVideo->videoCaption)
                                                <div class="naviMovieCaption">
                                                    {!! nl2br(e($fEntJobDetail->fEntVideo->videoCaption)) !!}
                                                </div>
                                                @endif
                                            </div>
                                        </section>
                                        @endif
                                    </section>
                                    <section class="area_detail">
                                        <table>
                                            <tbody>
                                            @if($fEntJobDetail->bosyuHaikei)
                                            <tr>
                                                <th>募集背景</th>
                                                <td>{!! nl2br(e($fEntJobDetail->bosyuHaikei)) !!}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th>仕事内容</th>
                                                <td>
                                                    {!! nl2br(e($fEntJobDetail->jobNaiyo)) !!}
                                                    {!! nl2br(PHP_EOL.PHP_EOL) !!}
                                                    @if($fEntJobDetail->daigomi)
                                                        【醍醐味】{!! nl2br(PHP_EOL) !!}
                                                        {!! nl2br(e($fEntJobDetail->daigomi)) !!}
                                                        {!! nl2br(PHP_EOL.PHP_EOL) !!}
                                                    @endif
                                                    @if($fEntJobDetail->kibishisa)
                                                        【厳しさ】{!! nl2br(PHP_EOL) !!}
                                                        {!! nl2br(e($fEntJobDetail->kibishisa)) !!}
                                                        {!! nl2br(PHP_EOL.PHP_EOL) !!}
                                                    @endif
                                                    @if($fEntJobDetail->ouboSikaku)
                                                        【応募資格】{!! nl2br(PHP_EOL) !!}
                                                        {!! nl2br(e($fEntJobDetail->ouboSikaku)) !!}
                                                        {!! nl2br(PHP_EOL.PHP_EOL) !!}
                                                    @endif
                                                    @if($fEntJobDetail->katuyaku)
                                                        【こんな人が活躍】{!! nl2br(PHP_EOL) !!}
                                                        {!! nl2br(e($fEntJobDetail->katuyaku)) !!}
                                                        {!! nl2br(PHP_EOL.PHP_EOL) !!}
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($fEntJobDetail->taiguFukurikosei)
                                            <tr>
                                                <th>待遇・福利厚生</th>
                                                <td>
                                                    {!! nl2br(e($fEntJobDetail->taiguFukurikosei)) !!}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($fEntJobDetail->appealPoint)
                                            <tr>
                                                <th>アピールポイント</th>
                                                <td>
                                                    {!! nl2br(e($fEntJobDetail->appealPoint)) !!}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($fEntJobDetail->senkoTejun)
                                            <tr>
                                                <th>選考手順</th>
                                                <td>
                                                    {!! nl2br(e($fEntJobDetail->senkoTejun)) !!}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($fEntJobDetail->mensetsuAddr)
                                            <tr>
                                                <th>面接地</th>
                                                <td>
                                                    {!! nl2br(e($fEntJobDetail->mensetsuAddr)) !!}
                                                </td>
                                            </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </section>
                                    <aside class="applyBtns">
                                        <a class="goApply" href="{{Route('top')}}/apply/{{$fEntJobDetail->jobId}}">
                                            @lang('textlist.webApply')
                                            <i class="fas fa-chevron-right"></i>
                                        </a>

                                        @if($applyTelNumber && mb_strlen($applyTelNumber) > 0)
                                        <a class="goApply telDialog" href="#" data-modaltarget="teldal" onclick="gtag('event', 'click', {'event_category': 'links','event_label': 'tel-tap-{{$fEntJobDetail->jobId}}-pc'});">
                                            @lang('textlist.telApply')
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                        @endif

                                        @if($fEntJobDetail->jisyaKoukokuNum)
                                        <x-molecules.favoriteBtn :favoriteList="$favoriteList" device="pc" :code="$fEntJobDetail->jisyaKoukokuNum" :jobId="$fEntJobDetail->jobId" />
                                        @endif

                                    </aside>

                                    @if($fEntJobDetail->jisyaKoukokuNum)
                                    <div class="adNumField">お仕事No.{{$fEntJobDetail->jisyaKoukokuNum}}</div>
                                    @endif

                                    <aside class="jobBtns">
                                        <a class="goJoblist" href="">&nbsp;</a>
                                    </aside>
                                    <div class="jobModal teldal">
                                        <div class="jobModalBody">
                                            <div class="jobModalBodyInner">
                                                <p class="jobModalTitle">@lang('textlist.telApply')</p>
                                                <p class="jobModalClose">×とじる</p>
                                                <div class="jobModalInputArea">
                                                    <div class="jobModalInputAreaInner">
                                                        <div class="call_announce_box">

                                                            @if($applyTelNumber && mb_strlen($applyTelNumber) > 0)
                                                            <p class="call_text">■お電話にて応募の場合は次の番号へお掛け下さい。</p>
                                                            <p class="call_telno">{{$applyTelNumber}}</p>
                                                            @endif

                                                            @if($fEntJobDetail->jisyaKoukokuNum)
                                                            <p class="call_text">■応募の際には次のお仕事番号をお伝え頂くと、スムーズに登録いただけます。</p>
                                                            <p class="call_jobno">お仕事No：{{$fEntJobDetail->jisyaKoukokuNum}}</p>
                                                            @endif
                                                        </div>
                                                        <div class="jobModalInputAreaFooter">
                                                            <div class="jobModalBtnBox">
                                                                <button type="button" class="jobModalClear">とじる</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="jobModalBK"></div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                // referrerの情報が自ドメインのパラメータ付き求人検索の場合対象のURLを返す
                                // それ以外のURLがreferrerの場合はすべて検索トップへリダイレクトする
                                let searchUrl = '{{route('search')}}';
                                let ref, backText;
                                let backButton = $('.goJoblist');

                                function getReferrer() {
                                    ref = document.referrer;
                                    if (ref.indexOf(searchUrl) === -1 || !ref) {
                                        backText = '{{ __('textlist.backSearchText') }}';
                                    } else {
                                        backText = '{{ __('textlist.backDirectText') }}';
                                    }
                                    backButton.text(backText);
                                }

                                $(window).on('load', function(){ // 表示テキストの初期化
                                    getReferrer();
                                });

                                backButton.click(function() { // 戻るボタン押された時の遷移先制御
                                    if (ref.indexOf(searchUrl) === -1 || !ref) {
                                        location.href = searchUrl;
                                        return false;
                                    } else {
                                        location.href = ref;
                                        return false;
                                    }
                                });
                            </script>
                        </div>
                        <div class="spLayout">
                            <header>
                                <h1 class="title_bg">{{$fEntJobDetail->jobTitle}}</h1>
                            </header>
                            <div class="horizontalTabBody">
                                <div id="jobone">
                                    <section class="area_header">
                                        @if($fEntJobDetail->updatedAt)
                                        <div class="updated">情報更新日：<x-atoms.date :date="$fEntJobDetail->updatedAt" /></div>
                                        @endif
                                    </section>
                                    <section class="area_introduction">
                                        <div class="introduction_right">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <th>職種</th>
                                                    <td>{{$fEntJobDetail->jobCategoryGroupName}} > {{$fEntJobDetail->jobCategoryName}}</td>
                                                </tr>
                                                <tr>
                                                    <th>雇用形態</th>
                                                    <td>
                                                        <i class="indicator{{$fEntJobDetail->koyKeitaiCode}}">
                                                            {{$fEntJobDetail->koyKeitaiName}}
                                                        </i><br />
                                                        {!! nl2br(e($fEntJobDetail->koyKeitaiBiko)) !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>給与</th>
                                                    <td>
                                                        @if($fEntJobDetail->kyuyoKbnName && $fEntJobDetail->kyuyoMin)
                                                            【{{$fEntJobDetail->kyuyoKbnName}}】
                                                            <x-atoms.salary :kyuyoMin="$fEntJobDetail->kyuyoMin" :kyuyoMax="$fEntJobDetail->kyuyoMax" type="char"/>
                                                            <br />
                                                        @endif
                                                        @if($fEntJobDetail->salary)
                                                            【月収例】{!! nl2br(e($fEntJobDetail->salary)) !!}<br />
                                                            <br />
                                                        @endif
                                                        @if($fEntJobDetail->annualSalary)
                                                            【年収例】{!! nl2br(e($fEntJobDetail->annualSalary)) !!}<br />
                                                            <br />
                                                        @endif
                                                        @if($fEntJobDetail->kyuyoBiko)
                                                            {!! nl2br(e($fEntJobDetail->kyuyoBiko)) !!}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if($fEntJobDetail->arrayFEntTokucho)
                                                <tr>
                                                    <th>特徴</th>
                                                    <td>
                                                        <div class="inTokuchoArea">
                                                            @foreach($fEntJobDetail->arrayFEntTokucho as $tokuchoInfo)
                                                                <x-job.tokucho :tokucho="$tokuchoInfo" />
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                                @if($fEntJobDetail->arrayFEntKinmuti)
                                                <tr>
                                                    <th>勤務地</th>
                                                    <td>
                                                        @foreach($fEntJobDetail->arrayFEntKinmuti as $kinmtiInfo)
                                                            <x-job.kinmti :kinmti="$kinmtiInfo" />
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                @endif
                                                @if($fEntJobDetail->workingTimes)
                                                <tr>
                                                    <th>勤務時間</th>
                                                    <td>
                                                        {!! nl2br(e($fEntJobDetail->workingTimes)) !!}
                                                    </td>
                                                </tr>
                                                @endif
                                                @if($fEntJobDetail->holiday)
                                                <tr>
                                                    <th>休日・休暇</th>
                                                    <td>
                                                        {!! nl2br(e($fEntJobDetail->holiday)) !!}
                                                    </td>
                                                </tr>
                                                @endif
                                                @if($fEntJobDetail->arrayFEntSelfParam)
                                                <tr>
                                                    <td colspan="2">
                                                        <x-job.selfParam :selfParams="$fEntJobDetail->arrayFEntSelfParam" />
                                                    </td>
                                                </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </section>
                                    @if($applyTelNumber && mb_strlen($applyTelNumber) > 0)
                                    <aside class="applyTelBtns">
                                        <a class="goApply" href="tel: {{$applyTelNumber}}" onclick="gtag('event', 'click', {'event_category': 'links','event_label': 'tel-tap-{{$fEntJobDetail->jobId}}-sp'});">@lang('textlist.telApply')<i class="fas fa-chevron-right"></i></a>
                                    </aside>
                                    @endif
                                    <aside class="applyBtns">
                                        <a class="goApply" href="{{Route('top')}}/apply/{{$fEntJobDetail->jobId}}">@lang('textlist.webApply')<i class="fas fa-chevron-right"></i></a>
                                    </aside>
                                    @if($fEntJobDetail->jisyaKoukokuNum)
                                    <x-molecules.favoriteBtn :favoriteList="$favoriteList" device="sp" :code="$fEntJobDetail->jisyaKoukokuNum" :jobId="$fEntJobDetail->jobId" />
                                    @endif
                                    @if($fEntJobDetail->jisyaKoukokuNum)
                                    <aside class="applyBtns">
                                        <div class="adNumField">お仕事No.{{$fEntJobDetail->jisyaKoukokuNum}}</div>
                                    </aside>
                                    @endif
                                    @if($fEntJobDetail->mainGazoFilePath || $fEntJobDetail->subGazo1FilePath || $fEntJobDetail->subGazo2FilePath || $fEntJobDetail->subGazo3FilePath)
                                    <section class="JobImgField">
                                        <div id="JobImg">
                                            <ul class="slider">
                                                @if($fEntJobDetail->mainGazoFilePath)
                                                <li>
                                                    <img src="{{asset('storage'.$fEntJobDetail->mainGazoFilePath)}}" alt="{{$fEntJobDetail->jobTitle}}">
                                                    <span class="caption">{!! nl2br(e($fEntJobDetail->mainGazoCaption)) !!}</span>
                                                </li>
                                                @endif
                                                @if($fEntJobDetail->subGazo1FilePath)
                                                <li>
                                                    <img src="{{asset('storage'.$fEntJobDetail->subGazo1FilePath)}}" alt="{{$fEntJobDetail->jobTitle}}">
                                                    <span class="caption">{!! nl2br(e($fEntJobDetail->subGazo1Caption)) !!}</span>
                                                </li>
                                                @endif
                                                @if($fEntJobDetail->subGazo2FilePath)
                                                <li>
                                                    <img src="{{asset('storage'.$fEntJobDetail->subGazo2FilePath)}}" alt="{{$fEntJobDetail->jobTitle}}">
                                                    <span class="caption">{!! nl2br(e($fEntJobDetail->subGazo2Caption)) !!}</span>
                                                </li>
                                                @endif
                                                @if($fEntJobDetail->subGazo3FilePath)
                                                <li>
                                                    <img src="{{asset('storage'.$fEntJobDetail->subGazo3FilePath)}}" alt="{{$fEntJobDetail->jobTitle}}">
                                                    <span class="caption">{!! nl2br(e($fEntJobDetail->subGazo3Caption)) !!}</span>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="ImgControl">
                                            <a href="javascript:;" id="ImgPrevBtn" class="backbtn">&lt; PREV</a>
                                            <a href="javascript:;" id="ImgNextBtn" class="nextbtn">NEXT &gt;</a>
                                            <div id="ImgCount">/</div>
                                        </div>
                                    </section>
                                    @endif
                                    <section class="area_information">
                                        <div class="catch">{{$fEntJobDetail->catchCopy}}</div>
                                        @if($fEntJobDetail->lead)
                                        <div class="information">{!! nl2br(e($fEntJobDetail->lead)) !!}</div>
                                        @endif
                                    </section>
                                    @if($fEntJobDetail->fEntVideo)
                                    <section class="naviMovie">
                                        <div>
                                            @if($fEntJobDetail->fEntVideo->embedIframe)
                                            <div class="naviMovieTitle">職場ナビ動画 公開中！</div>
                                            <div class="naviMovieTag">
                                                {!! $fEntJobDetail->fEntVideo->embedIframe !!}
                                            </div>
                                            @endif
                                            @if($fEntJobDetail->fEntVideo->videoCaption)
                                            <div class="naviMovieCaption">
                                                {!! nl2br(e($fEntJobDetail->fEntVideo->videoCaption)) !!}
                                            </div>
                                            @endif
                                        </div>
                                    </section>
                                    @endif
                                    <p class="Job_detail_title">募集情報</p>
                                    <section class="area_detail">
                                        <table>
                                            <tbody>
                                            @if($fEntJobDetail->bosyuHaikei)
                                            <tr>
                                                <th>募集背景</th>
                                                <td>{!! nl2br(e($fEntJobDetail->bosyuHaikei)) !!}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th>仕事内容</th>
                                                <td>
                                                    {!! nl2br(e($fEntJobDetail->jobNaiyo)) !!}
                                                    {!! nl2br(PHP_EOL.PHP_EOL) !!}
                                                    @if($fEntJobDetail->daigomi)
                                                        【醍醐味】{!! nl2br(PHP_EOL) !!}
                                                        {!! nl2br(e($fEntJobDetail->daigomi)) !!}
                                                        {!! nl2br(PHP_EOL.PHP_EOL) !!}
                                                    @endif
                                                    @if($fEntJobDetail->kibishisa)
                                                        【厳しさ】{!! nl2br(PHP_EOL) !!}
                                                        {!! nl2br(e($fEntJobDetail->kibishisa)) !!}
                                                        {!! nl2br(PHP_EOL.PHP_EOL) !!}
                                                    @endif
                                                    @if($fEntJobDetail->ouboSikaku)
                                                        【応募資格】{!! nl2br(PHP_EOL) !!}
                                                        {!! nl2br(e($fEntJobDetail->ouboSikaku)) !!}
                                                        {!! nl2br(PHP_EOL.PHP_EOL) !!}
                                                    @endif
                                                    @if($fEntJobDetail->katuyaku)
                                                        【こんな人が活躍】{!! nl2br(PHP_EOL) !!}
                                                        {!! nl2br(e($fEntJobDetail->katuyaku)) !!}
                                                        {!! nl2br(PHP_EOL.PHP_EOL) !!}
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($fEntJobDetail->taiguFukurikosei)
                                            <tr>
                                                <th>待遇・福利厚生</th>
                                                <td>
                                                    {!! nl2br(e($fEntJobDetail->taiguFukurikosei)) !!}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($fEntJobDetail->appealPoint)
                                            <tr>
                                                <th>アピールポイント</th>
                                                <td>
                                                    {!! nl2br(e($fEntJobDetail->appealPoint)) !!}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($fEntJobDetail->senkoTejun)
                                            <tr>
                                                <th>選考手順</th>
                                                <td>
                                                    {!! nl2br(e($fEntJobDetail->senkoTejun)) !!}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($fEntJobDetail->mensetsuAddr)
                                            <tr>
                                                <th>面接地</th>
                                                <td>
                                                    {!! nl2br(e($fEntJobDetail->mensetsuAddr)) !!}
                                                </td>
                                            </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </section>
                                    @if($applyTelNumber && mb_strlen($applyTelNumber) > 0)
                                        <aside class="applyTelBtns">
                                            <a class="goApply" href="tel: {{$applyTelNumber}}" onclick="gtag('event', 'click', {'event_category': 'links','event_label': 'tel-tap-{{$fEntJobDetail->jobId}}-sp'});">@lang('textlist.telApply')<i class="fas fa-chevron-right"></i></a>
                                        </aside>
                                    @endif
                                    <aside class="applyBtns">
                                        <a class="goApply" href="{{Route('top')}}/apply/{{$fEntJobDetail->jobId}}">@lang('textlist.webApply')<i class="fas fa-chevron-right"></i></a>
                                    </aside>
                                    @if($fEntJobDetail->jisyaKoukokuNum)
                                    <x-molecules.favoriteBtn :favoriteList="$favoriteList" device="sp" :code="$fEntJobDetail->jisyaKoukokuNum" :jobId="$fEntJobDetail->jobId" />
                                    @endif
                                    @if($fEntJobDetail->jisyaKoukokuNum)
                                    <aside class="applyBtns">
                                        <div class="adNumField">お仕事No.{{$fEntJobDetail->jisyaKoukokuNum}}</div>
                                    </aside>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    @if($page->fEntConfig->frontendSettings['isDispEqualJob']??null)
    @php
        $arrayPrefCode = array();
        /* @var $fEntJobDetail \App\Models\FEnt\FEntJobDetail */
        if(is_array($fEntJobDetail->arrayFEntKinmuti) && $fEntJobDetail->arrayFEntKinmuti) {
            /* @var $fEntKinmuti \App\Models\FEnt\FEntKinmuti */
            foreach($fEntJobDetail->arrayFEntKinmuti As $fEntKinmuti) {
                if($fEntKinmuti->prefCode) {
                    $arrayPrefCode[] = $fEntKinmuti->prefCode;
                }
            }
            if(count($arrayPrefCode)>0) {
                $arrayPrefCode = array_unique($arrayPrefCode);
            }
        }
    @endphp

    <x-sameAreaJob.index :jobId="$fEntJobDetail->jobId" :arrayPrefCode="$arrayPrefCode" />
    @endif

    @else {{--該当求人ヒットしなかった場合--}}
    <div id="jobDetailContent">
        <x-display.notFoundJobDetail />
    </div>
    @endif

    @if(isset($fEntSearchAxisData))
        <div id="jobDetailSearchBox">
            <x-searchBox :fEntSearchAxisData="$fEntSearchAxisData" :fEntConfig="$page->fEntConfig" />
        </div>
    @endif
@endsection
