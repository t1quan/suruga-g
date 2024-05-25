@props(['areaAxis','isCustomArea','isDispCount'=>false])

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
            @foreach($areaAxis As $area)
            <div class="areaBox">
                <a class="topmod1-bc" href="{{$searchURL}}{{$area->type}}{{ $isCustomArea ? '=' : '_' }}{{$area->value}}">{{$area->name}} @if($isDispCount && $area->cnt)({{$area->cnt}}) @endif</a>
                <ul class="sub-search-list">
                    @if($area->children)
                    @foreach($area->children As $children)
                    <li>
                        <a class="topmod1-area" href="{{$searchURL}}{{$children->type}}{{ $isCustomArea ? '=' : '_' }}{{$children->value}}">{{$children->name}} @if($isDispCount && $children->cnt)({{$children->cnt}}) @endif</a>
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</div>