@php

@endphp

@extends('layouts.app')

@section('title', $page->title ?? '')

@section('content')

    @if(isset($fEntJobDetail))

        <x-apply.form :fEntJobDetail="$fEntJobDetail" :fEntUserApplyInfo="$fEntUserApplyInfo" :action="$page->action ?? ''" :fEntApplyMasters="$fEntApplyMasters" :fEntConfig="$page->fEntConfig" />

        <div id="applySearchBox">

        </div>

    @else {{--該当求人ヒットしなかった場合--}}
        <div id="applyForm">
            <x-display.notFoundJobDetail />
        </div>
    @endif

@endsection
