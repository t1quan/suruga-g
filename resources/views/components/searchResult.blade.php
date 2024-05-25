@props([
    'arrayFEntJob' => [],
    'favoriteList' => [],
    'fEntPager' => null,
    'className' => '',
    'title' => [
        'ja' => '',
        'en' => ''
    ]
])
<x-display.contentsTitle :className="$className" :title="$title" />
<section class="mod_jobSummariesJob">

    <x-navigation.pagination :fEntPager="$fEntPager" />

    @if($arrayFEntJob)
        @foreach($arrayFEntJob as $fEntJob)
        <x-jobItem :fEntJob="$fEntJob" :favoriteList="$favoriteList"/>
        @endforeach

        @if($fEntPager)
            <x-navigation.pagination :fEntPager="$fEntPager" />
        @endif
    @else
        <section class="jobZero">
            <div class="textArea">
                <div class="alert">条件にあてはまる求人情報はありませんでした。</div>
            </div>
        </section>
    @endif

</section>
