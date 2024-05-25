@props(['jobAxis','isCustomSearch','isDispCount'=>false])

@if($jobAxis)
<span>
    <select id="quickSearchSyksy" title="職種選択">
        <option value="-1">職種を選択してください</option>
        @foreach($jobAxis As $job)
            <option class="parent" value="{{$job->type}}{{ $isCustomSearch ? '=' : '_' }}{{$job->value}}">{{$job->name}} @if($isDispCount && $job->cnt)({{$job->cnt}}) @endif</option>
        @endforeach
    </select>
</span>
@endif