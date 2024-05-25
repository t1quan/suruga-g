@props([
    'className' => '',
    'title' => [
        'ja' => '',
        'en' => ''
    ]
])


@if($title['ja'] || $title['en'])
    <h2 class="{{$className}}">
        @if(isset($title['en']))
            <span class="en">{{$title['en']}}</span>
        @endif
        @if(isset($title['ja']))
            <span class="ja">{{$title['ja']}}</span>
        @endif
    </h2>
@endif