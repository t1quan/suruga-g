@props(['koyAxis','isCustomSearch','isDispCount'=>false])

@if($koyAxis)
<span>
    <select id="quickSearchKoy" title="雇用形態選択">
        <option value="-1">雇用形態を選択してください</option>
        @foreach($koyAxis As $koy)
            <option class="parent" value="{{$koy->value}}{{ $isCustomSearch ? '=1' : '' }}">{{$koy->name}} @if($isDispCount)({{$koy->cnt}}) @endif</option>
        @endforeach
    </select>
</span>
@endif