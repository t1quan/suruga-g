@props(['areaAxis','isCustomSearch','isDispCount'=>false])

@if($areaAxis)
<span>
    <select id="quickSearchArea" title="エリア選択">
        <option value="-1">エリアを選択してください</option>
        @foreach($areaAxis As $area)
            <option class="parent" value="{{$area->type}}{{ $isCustomSearch ? '=' : '_' }}{{$area->value}}">{{$area->name}} @if($isDispCount && $area->cnt)({{$area->cnt}}) @endif</option>
            @if($area->children)
            @foreach($area->children As $children)
                <option class="child" value="{{$children->type}}{{ $isCustomSearch ? '=' : '_' }}{{$children->value}}">　{{$children->name}} @if($isDispCount && $children->cnt)({{$children->cnt}}) @endif</option>
            @endforeach
            @endif
        @endforeach
    </select>
</span>
@endif