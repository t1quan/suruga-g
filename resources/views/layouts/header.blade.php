@php
/** @var \App\Models\FEnt\FEntPage $page */
$frontendSettings = $page->fEntConfig->frontendSettings;
$pcLogo = $frontendSettings['header']['pcImg'] ?? $frontendSettings['logo'] ?? '';
$spLogo = $frontendSettings['header']['spImg'] ?? $frontendSettings['logo'] ?? '';
$displayLogo = $frontendSettings['header']['displayLogo'] ?? false;
@endphp

<header id="headerMenu" class="headerMenu">
    <div class="headerNav header_navitems">
        <a href="{{route('top')}}">
        <h1 class="headerLogo" style="display: none;">
            @if(isset($frontendSettings['cpnameType']) and $frontendSettings['cpnameType'] === 1 && $displayLogo && $pcLogo)
{{--            <a href="{{route('top')}}">--}}
                <picture>
                    <source media="(max-width: 767px)" srcset="{{asset($spLogo)}} 2x">
                    <source media="(min-width: 768px)" srcset="{{asset($pcLogo)}} 2x">
                    <img class="sizes" src="{{asset($pcLogo)}}" alt="{{$page->title}}">
                </picture>
{{--            </a>--}}
            @else
            <span class="noLogoText">
                <a href="{{route('top')}}">
                    <span class="corpUrl">{{$page->title}}</span>採用情報
                </a>
            </span>
            @endif
        </h1>
        </a>

        <x-headerMenu :frontendSettings="$frontendSettings" :favoriteJobCnt="$page->favoriteJobCnt??0"/>

    </div>
</header>