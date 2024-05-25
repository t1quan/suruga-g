@props(['cityAxis','isCustomArea','isDispCount'=>false])

@php
    /* @var $isCustomArea */
    if($isCustomArea) {
        $searchURL = Route('search.query').'?';
    }
    else {
        $searchURL = Route('search').'/';
    }
@endphp

<div class="search-box search-area">
    <div class="hgroup-other">
        <h4>エリアを選択してください</h4>
    </div>

    <div class="areaWrapper">
        {{--todo マップ表示コンポーネント実装--}}
        <div class="areaList">
            <ul class="sub-search-list">
                @foreach($cityAxis As $city)
                <li>
                    <a class="topmod1-city" href="{{$searchURL}}{{$city->type}}{{ $isCustomArea ? '=' : '_' }}{{$city->value}}">{{$city->name}} @if($isDispCount && $city->cnt)({{$city->cnt}}) @endif</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>