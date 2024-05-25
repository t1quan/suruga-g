@extends('layouts.app')

@section('title', $page->title)

@section('description', $page->description)

@section('content')

    @if (isset($arrayFEntJob))
    <div id="searchBody">
        <div id="wrapJobList">
            <div id="jobListArea">
                <div class="inner">
                    <x-searchSelected.accordion :fEntSearchAxisData="$fEntSearchAxisData" :searchSelectedMasterList="$searchSelectedMasterList" :criteria="$page->criteria" :resultTitle="$resultTitle" />

                    <x-searchResult :arrayFEntJob="$arrayFEntJob" :favoriteList="$favoriteList" :fEntPager="$fEntPager" />
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(isset($fEntSearchAxisData))
    <div id="searchSearchBox">
        <x-searchBox :fEntSearchAxisData="$fEntSearchAxisData" :fEntConfig="$page->fEntConfig" />
    </div>
    @endif

{{--    @if($page->fEntConfig->frontendSettings['isDispLatestJob']??null)--}}
{{--    <div id="searchLatestJobBox">--}}
{{--        <x-latestJob.oneLineStyle />--}}
{{--    </div>--}}
{{--    @endif--}}



@endsection
