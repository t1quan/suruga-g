@if(isset($fEntJob))
<section class="jobSummary">
    <div class="summary02">
        <div class="summaryTitleArea">

            @if($fEntJob->corpMei)
            <div class="corpMei">
                <a class="corpMei" href="{{Route('top')}}/job/{{ $fEntJob->jobId ?? '' }}"><h3>{{$fEntJob->corpMei}}</h3></a>
            </div>
            @endif
            <div class="jobTitle">
                <a class="title" href="{{Route('top')}}/job/{{ $fEntJob->jobId ?? '' }}"><h3>{{$fEntJob->jobTitle}}</h3></a>
            </div>
            <div class="koy">
                <i class="indicator{{$fEntJob->koyKeitaiCode}}">{{$fEntJob->koyKeitaiName}}</i>
            </div>
        </div>
        @if($fEntJob->catchCopy)
        <div class="summaryCatchArea">
            <div class="catch_copy">{{$fEntJob->catchCopy}}</div>
        </div>
        @endif
        <div class="summaryJobDataArea">
            @if($fEntJob->mainGazoFilePath)
            <div class="summaryImgArea">
                <img src="{{asset('storage'.$fEntJob->mainGazoFilePath)}}" alt="{{$fEntJob->jobTitle}}">
            </div>
            @endif
            <div class="summaryJobDataList @if(!$fEntJob->mainGazoFilePath) summaryFull @endif">
                <ul>
                    <li class="data">
                        <span class="item">職種</span>
                        <span class="text">{{$fEntJob->jobCategoryName}}</span>
                    </li>
                    <li class="data">
                        <span class="item">給与</span>
                        <span class="text">
							@if($fEntJob->kyuyoKbnName && $fEntJob->kyuyoMin)
                                【{{$fEntJob->kyuyoKbnName}}】
                                <x-atoms.salary :kyuyoMin="$fEntJob->kyuyoMin" :kyuyoMax="$fEntJob->kyuyoMax" dispType="char" />
                            @endif
                        </span>
                    </li>
                    @if($fEntJob->arrayFEntKinmuti)
                    <li class="data">
                        <span class="item">勤務地</span>
                        <x-search.kinmti :arrayKinmti="$fEntJob->arrayFEntKinmuti" />
                    </li>
                    @endif
                    @if($fEntJob->workingTimes)
                    <li class="data">
                        <span class="item">勤務時間</span>
                        <span class="text">{!! nl2br(e($fEntJob->workingTimes)) !!}</span>
                    </li>
                    @endif
                    @if($fEntJob->jobNaiyo)
                    <li class="data">
                        <span class="item">仕事内容</span>
                        <span class="text">{!! nl2br(e($fEntJob->jobNaiyo)) !!}</span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="summaryJobBtns">
            <div class="detailBtn">
                <a class="goJob" href="{{Route('top')}}/job/{{ $fEntJob->jobId ?? '' }}">詳しく見る<i class="fas fa-chevron-right"></i></a>
                @if($fEntJob->jisyaKoukokuNum)
                    <x-molecules.favoriteBtn :favoriteList="$favoriteList" :code="$fEntJob->jisyaKoukokuNum" :jobId="$fEntJob->jobId" />
                @endif
            </div>
            @if($fEntJob->jisyaKoukokuNum)
            <div class="adNumField">お仕事No.{{$fEntJob->jisyaKoukokuNum}}</div>
            @endif
        </div>
    </div>
</section>
@endif
