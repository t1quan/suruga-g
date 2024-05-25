@props(['koyAxis','isDispCount'=>false])

<div class="search-box search-employee">
    <div class="hgroup-other">
        <h4>雇用形態を選択してください</h4>
    </div>
    <div class="info-area__list tsearch-area__info">
        <ul class="sub-search-list">
            @foreach($koyAxis As $koy)
            <li>
                <a class="topmod3-koyo" href="{{Route('search')}}/{{$koy->value}}">{{$koy->name}} @if($isDispCount && $koy->cnt)({{$koy->cnt}}) @endif</a>
            </li>
            @endforeach
        </ul>
    </div>
</div>