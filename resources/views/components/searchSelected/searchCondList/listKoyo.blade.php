@props(['fEntSearchAxisData','criteria'])

@php

    $koyParams = array(
        '1' => 'rs',
        '2' => 'ks',
        '3' => 'ap',
        '4' => 'hs',
        '5' => 'sy',
        '6' => 'th',
        '7' => 'js',
        '8' => 'is',
        '99' => 'ss',
    );

@endphp

@if(is_array($fEntSearchAxisData->fEntSearchAxis->koy) && (count($fEntSearchAxisData->fEntSearchAxis->koy) > 0))
<div class="searchCondListKoyo">
    <div class="searchListLabel close">雇用形態</div>
    <div class="searchListBody">
        <ul>
            <li class="parent">
                <ul>
                    @foreach($fEntSearchAxisData->fEntSearchAxis->koy As $koyAxis)
                        @php
                            $isChecked = false;
                            if($criteria->koyKeitaiCodes) {
                                foreach(explode("[]", $criteria->koyKeitaiCodes) As $koyKeitaiCodesCriteria) {
                                    if($koyParams[$koyKeitaiCodesCriteria] == $koyAxis->value) {
                                        $isChecked = true;
                                    break;
                                    }
                                }
                            }
                        @endphp
                        <li class="child">
                            <label for="jmod4-{{$koyAxis->value}}">
                                <input type="checkbox" name="koyoCheckbox" class="jmod-koyocheck koyoOverlayLabel" value="{{$koyAxis->value}}" id="jmod4-{{$koyAxis->value}}" {{$isChecked ? 'checked' : ''}}>
                                {{$koyAxis->name}}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </div>
</div>
@endif
