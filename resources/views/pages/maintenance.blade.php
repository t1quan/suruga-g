@extends('layouts.app')

@section('title', $page->title)

@section('description', $page->description)

@section('content')

<div id="maintenanceNotice">
    <div class="inner">
        <ul class="alert">
            <li>ただいまメンテナンスを行っております</li>
            <li>ご迷惑をおかけします</li>
        </ul>
    </div>
</div>

@endsection