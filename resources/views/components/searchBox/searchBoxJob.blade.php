@props(['jobAxis','isCustomJob','isDispCount'=>false,'isFirstViewJobAxis'])

@php
    /* @var $isCustomJob */
    if($isCustomJob) {
        $searchURL = Route('search.query').'?';
    }
    else {
        $searchURL = Route('search').'/';
    }
@endphp

<div class="search-box search-job" {{$isFirstViewJobAxis ? ' style=display:block' : ''}}>
    <div class="hgroup-other">
        <h4>職種を選択してください</h4>
    </div>
    <div class="info-area__list tsearch-area__info">
        <div class="jobBox">
            <ul class="sub-search-list">
                @foreach($jobAxis As $job)
                <li>
                    <a class="topmod2-job" href="{{$searchURL}}{{$job->type}}{{ $isCustomJob ? '=' : '_' }}{{$job->value}}">{{$job->name}} @if($isDispCount && $job->cnt)({{$job->cnt}}) @endif</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>