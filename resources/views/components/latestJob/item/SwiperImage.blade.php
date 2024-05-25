@if($newJobs)
<div id="latestJob" class="latestJob">
    <div class="latestJobInner">
        <h2 class="latestJobTitle">
            <span class="en">NEW JOBS</span>
            <span class="ja">新着の求人情報</span>
        </h2>
        <div class="latestJobBox swiper-latestOneLine">
            <div class="latestJobList swiper-wrapper">

                <div class="latestJobItem swiper-slide">
                    <a href="{{url('job/18268453/')}}">
                        <span class="latestJobDate">2022.08.02</span>
                        <span class="latestJobTag">
                            岡山県津山市／果物用クッション材の製造スタッフ急募
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <a href="{{route('search.query')}}" class="latestJobMoreButton">
            <span class="buttonText">MORE</span>
        </a>
    </div>
</div>
@endif