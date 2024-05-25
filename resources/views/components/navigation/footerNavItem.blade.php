
@if($navItem)
@php
$linkUrl = $navItem['url'] ?? '';
$needle   = '/';
$pos = strpos($linkUrl, $needle);
if($pos === false){ // スラッシュを含まないURLは想定しないためURLなし
    $linkUrl = '';
}elseif($pos === 0){ // システム内の相対パスのためURL生成
    $linkUrl = url($linkUrl);
}

$target = '';
if(isset($navItem['target'])){
$target = 'js-clickitem';
    if($navItem['target'] === '_blank'){
        $target = 'js-clickitemBlank blankIcon';
    }
}

$text = $navItem['text'] ?? '';

@endphp
<li class="footerRemoteNavItem {{$navItem['class'] ?? ''}}">
    @if($text || $linkUrl)
    <span class="letter {{$target}}">
        {{$text}}
        <a href="{{$linkUrl}}"></a>
    </span>
    @endif
</li>
@endif