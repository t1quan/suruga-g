@extends('layouts.app')

@section('title', $page->title)

@section('description', $page->description)

@section('content')

        <div id="{{$page->id}}Body">
            <div id="wrapJobList">
                <div id="jobListArea">
                    <div class="inner">
                        @php
                            /** @var  \App\Models\FEnt\FEntPage $page */
                            $className = $page->class.'Title';
                            $page->fEntConfig->frontendSettings['favorite']['title']['ja'] = "お気に入りの求人";
                        @endphp
                        @if(isset($arrayFEntJob) && count($arrayFEntJob)>0)
                            <x-searchResult :arrayFEntJob="$arrayFEntJob" :favoriteList="$favoriteList" :className="$className" :title="$page->fEntConfig->frontendSettings['favorite']['title']?? ''" :fEntPager="$fEntPager"></x-searchResult>
                        @else
                            <x-display.contentsTitle :className="$className" :title="$page->fEntConfig->frontendSettings['favorite']['title']?? ''" />
                            <section class="mod_jobSummariesJob">
                                <section class="favoriteZero">
                                    <div class="textArea">
                                        <div class="alert">条件にあてはまる求人情報はありませんでした。</div>
                                    </div>
                                </section>
                            </section>
                        @endif
                    </div>
                </div>
            </div>
        </div>

@endsection

