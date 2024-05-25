@props(['prefAxis','isCustomArea','isDispCount'=>false])

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
            @foreach($prefAxis As $pref)
            <div class="areaBox">
                <a class="topmod1-area" href="{{$searchURL}}{{$pref->type}}{{ $isCustomArea ? '=' : '_' }}{{$pref->value}}">{{$pref->name}} @if($isDispCount && $pref->cnt)({{$pref->cnt}}) @endif</a>
                <ul class="sub-search-list">
                    @if($pref->children)
                    @foreach($pref->children As $children)
                    <li>
                        <a class="topmod1-city" href="{{$searchURL}}{{$children->type}}{{ $isCustomArea ? '=' : '_' }}{{$children->value}}">{{$children->name}} @if($isDispCount && $children->cnt)({{$children->cnt}}) @endif</a>
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</div>