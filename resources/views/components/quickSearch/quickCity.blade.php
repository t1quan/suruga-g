@props(['cityAxis','isCustomSearch','isDispCount'=>false])

@if($cityAxis)
<span>
    <select id="quickSearchArea" title="エリア選択">
        <option value="-1">エリアを選択してください</option>
        @foreach($cityAxis As $city)
            <option class="parent" value="{{$city->type}}{{ $isCustomSearch ? '=' : '_' }}{{$city->value}}">{{$city->name}} @if($isDispCount && $city->cnt)({{$city->cnt}}) @endif</option>
        @endforeach
    </select>
</span>
@endif