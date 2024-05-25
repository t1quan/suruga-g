@props(['jobbcAxis','isCustomJob','isDispCount'=>false,'isFirstViewJobAxis'])

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
        @foreach($jobbcAxis As $jobbc)
        <div class="jobBox">
            <a class="topmod2-jobbc" href="{{$searchURL}}{{$jobbc->type}}{{ $isCustomJob ? '=' : '_' }}{{$jobbc->value}}">{{$jobbc->name}} @if($isDispCount && $jobbc->cnt)({{$jobbc->cnt}}) @endif</a>
            <ul class="sub-search-list">
                @if($jobbc->children)
                @foreach($jobbc->children As $children)
                <li>
                    <a class="topmod2-job" href="{{$searchURL}}{{$children->type}}{{ $isCustomJob ? '=' : '_' }}{{$children->value}}">{{$children->name}} @if($isDispCount && $children->cnt)({{$children->cnt}}) @endif</a>
                </li>
                @endforeach
                @endif
            </ul>
        </div>
        @endforeach
    </div>
</div>