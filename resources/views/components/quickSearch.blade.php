@props(['fEntSearchAxisData','fEntConfig'])

@php
    $ary = $fEntConfig->frontendSettings['quickTypes']['list']??null;
    $arrayQuickBoxItem = array();

    if($ary) {
        foreach($ary As $value) {
            $arrayQuickBoxItem[$value] = $value;
        }
    }

    /** @var $fEntSearchAxisData */
    if($fEntSearchAxisData->isCustomSearch) {
        $searchURL = Route('search.query').'?';
    }
    else {
        $searchURL = Route('search').'/';
    }

@endphp

@if(count($arrayQuickBoxItem) > 0)
    @if($fEntSearchAxisData->fEntSearchAxis)
    <div class="searchQuick">
        <div class="searchQuickWrapper">
            <h3>お仕事クイック検索</h3>
            <div class="selectBox">
                <div class="selectBoxInner">

                    @foreach($arrayQuickBoxItem As $quickBoxItem)
                        @switch($quickBoxItem)
                            @case('area')
                                @if(isset($fEntSearchAxisData->fEntSearchAxis->area))
                                    <x-quickSearch.quickArea :areaAxis="$fEntSearchAxisData->fEntSearchAxis->area" :isCustomSearch="$fEntSearchAxisData->isCustomSearch" :isDispCount=true />
                                    <span class="crossSelect PCdisp">×</span>
                                @endif
                            @break

                            @case('pref')
                                @if(isset($fEntSearchAxisData->fEntSearchAxis->pref))
                                    <x-quickSearch.quickPref :prefAxis="$fEntSearchAxisData->fEntSearchAxis->pref" :isCustomSearch="$fEntSearchAxisData->isCustomSearch" :isDispCount=true />
                                    <span class="crossSelect PCdisp">×</span>
                                @endif
                            @break

                            @case('city')
                                @if(isset($fEntSearchAxisData->fEntSearchAxis->city))
                                    <x-quickSearch.quickCity :cityAxis="$fEntSearchAxisData->fEntSearchAxis->city" :isCustomSearch="$fEntSearchAxisData->isCustomSearch" :isDispCount=true />
                                    <span class="crossSelect PCdisp">×</span>
                                @endif
                            @break

                            @case('jobbc')
                                @if(isset($fEntSearchAxisData->fEntSearchAxis->jobbc))
                                    <x-quickSearch.quickJobGroup :jobbcAxis="$fEntSearchAxisData->fEntSearchAxis->jobbc" :isCustomSearch="$fEntSearchAxisData->isCustomSearch" :isDispCount=true />
                                    <span class="crossSelect PCdisp">×</span>
                                @endif
                            @break

                            @case('job')
                                @if(isset($fEntSearchAxisData->fEntSearchAxis->job))
                                    <x-quickSearch.quickJob :jobAxis="$fEntSearchAxisData->fEntSearchAxis->job" :isCustomSearch="$fEntSearchAxisData->isCustomSearch" :isDispCount=true />
                                    <span class="crossSelect PCdisp">×</span>
                                @endif
                            @break

                            @case('koy')
                                @if(isset($fEntSearchAxisData->fEntSearchAxis->koy))
                                    <x-quickSearch.quickKoy :koyAxis="$fEntSearchAxisData->fEntSearchAxis->koy" :isCustomSearch="$fEntSearchAxisData->isCustomSearch" :isDispCount=false />
                                    <span class="crossSelect PCdisp">×</span>
                                @endif
                            @break

                            @case('kyuyo')
                                {{--todo 給与条件検索のコンポーネント呼び出し--}}
                            @break

                            @case('freeword')
                                <span>
                                    <input id="quicksearchWord" value="" placeholder="フリーワード">
                                </span>
                                <span class="crossSelect PCdisp">×</span>
                            @break

                            @default
                            @break

                        @endswitch
                    @endforeach

                    <span><button type="submit" id="{{ $fEntSearchAxisData->isCustomSearch ? 'quicksearchSubmitCustom' : 'quicksearchSubmit' }}">検 索</button></span>
                    <input type="hidden" id="quick_search_url" value="{{$searchURL}}">
                </div>
            </div>
        </div>
    </div>
    @endif
@endif