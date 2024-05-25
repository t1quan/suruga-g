@props(['jobbcAxis','isCustomSearch','isDispCount'=>false])

@if($jobbcAxis)
<span>
    <select id="quickSearchSyksy" title="職種選択">
        <option value="-1">職種を選択してください</option>
        @foreach($jobbcAxis As $jobbc)
            <option class="parent" value="{{$jobbc->type}}{{ $isCustomSearch ? '=' : '_' }}{{$jobbc->value}}">{{$jobbc->name}} @if($isDispCount && $jobbc->cnt)({{$jobbc->cnt}}) @endif</option>
            @if($jobbc->children)
            @foreach($jobbc->children As $children)
                <option class="child" value="{{$children->type}}{{ $isCustomSearch ? '=' : '_' }}{{$children->value}}">　{{$children->name}} @if($isDispCount && $children->cnt)({{$children->cnt}}) @endif</option>
            @endforeach
            @endif
        @endforeach
    </select>
</span>
@endif