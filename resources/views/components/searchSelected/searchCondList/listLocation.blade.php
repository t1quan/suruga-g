@props(['fEntSearchAxisData','criteria'])

@php

    $axisType = null;
    $parentUrlKey = null;
    $childrenUrlKey = null;

    //表示優先順はpref > area > city としておく
    /** @var \App\Models\FEnt\FEntSearchAxisData $fEntSearchAxisData */
    if($fEntSearchAxisData->fEntSearchAxis->city) {
        $axisType = 'city';
        $parentUrlKey = 'city';
        $parentCriteria = 'cityCodes';
    }

    if($fEntSearchAxisData->isCustomArea) {
        if($fEntSearchAxisData->fEntSearchAxis->area) {
            $axisType = 'area';
            $parentUrlKey = 'bc';
            $childrenUrlKey = 'area';
            $parentCriteria = 'areaCodes';
            $childrenCriteria = 'prefCodes';
        }
        if($fEntSearchAxisData->fEntSearchAxis->pref) {
            $axisType = 'pref';
            $parentUrlKey = 'area';
            $childrenUrlKey = 'city';
            $parentCriteria = 'prefCodes';
            $childrenCriteria = 'cityCodes';
        }
    }
    else {
        if($fEntSearchAxisData->fEntSearchAxis->area && $fEntSearchAxisData->fEntSearchAxis->pref) {
            $axisType = 'area';
            $parentUrlKey = 'bc';
            $childrenUrlKey = 'area';
            $parentCriteria = 'areaCodes';
            $childrenCriteria = 'prefCodes';
        }
        if($fEntSearchAxisData->fEntSearchAxis->pref && $fEntSearchAxisData->fEntSearchAxis->city) {
            $axisType = 'pref';
            $parentUrlKey = 'area';
            $childrenUrlKey = 'city';
            $parentCriteria = 'prefCodes';
            $childrenCriteria = 'cityCodes';
        }
    }

@endphp

@if($axisType)
<div class="searchCondListLocation">
    <div class="searchListLabel close">勤務地</div>
    <div class="searchListBody">
        <ul>
            {{--デフォルト検索軸 start--}}
            @if(!$fEntSearchAxisData->isCustomArea)
                @foreach($fEntSearchAxisData->fEntSearchAxis->$axisType As $locationAxis)
                    @if($axisType === 'area' || $axisType === 'pref')
                        @if($axisType === 'pref')
                            @php
                                $isCheckedRoot = false; //上位要素が検索済みか
                                if($criteria->areaCodes) {
                                    foreach(explode("[]", $criteria->areaCodes) As $rootCodesCriteria) {
                                        if($rootCodesCriteria == $locationAxis->parent) {
                                            $isCheckedRoot = true;
                                            break;
                                        }
                                    }
                                }
                            @endphp
                        @endif
                        @php
                            $isCheckedParent = false;
                            if($axisType === 'pref') {
                                if($isCheckedRoot) {
                                    $isCheckedParent = true;
                                }
                            }
                            if(!$isCheckedParent) {
                                if($criteria->$parentCriteria) {
                                    foreach(explode("[]", $criteria->$parentCriteria) As $parentCodesCriteria) {
                                        if($parentCodesCriteria == $locationAxis->value) {
                                            $isCheckedParent = true;
                                            break;
                                        }
                                    }
                                }
                            }
                        @endphp
                    @endif
                    <li class="parent">
                        @if($axisType === 'area' || $axisType === 'pref')
                        <label for="jmod1-{{$locationAxis->value}}">
                            <input type="checkbox" name="{{$parentUrlKey}}Checkbox" class="jmod-areacheck areaOverlayLabel" value="{{$locationAxis->value}}" id="jmod1-{{$locationAxis->value}}" {{$isCheckedParent ? 'checked' : ''}}>
                            {{$locationAxis->name}}
                        </label>
                        @endif
                        <ul>
                            @if($axisType === 'area' || $axisType === 'pref')
                                @if($locationAxis->children)
                                @foreach($locationAxis->children As $childrenAxis)
                                    @php
                                        $isChecked = false;
                                        if($isCheckedParent) {
                                            $isChecked = true; //親要素にチェックが入っていれば自身もチェックを入れる
                                        }
                                        else {
                                            if($criteria->$childrenCriteria) {
                                                foreach(explode("[]", $criteria->$childrenCriteria) As $childrenCodesCriteria) {
                                                    if($childrenCodesCriteria == $childrenAxis->value) {
                                                        $isChecked = true;
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    @endphp
                                    <li class="child">
                                        <label for="jmod1-{{$locationAxis->value}}-{{$childrenAxis->value}}">
                                            <input type="checkbox" name="{{$childrenUrlKey}}Checkbox" class="jmod-areacheck areaOverlayLabel" value="{{$childrenAxis->value}}" id="jmod1-{{$locationAxis->value}}-{{$childrenAxis->value}}" {{$isChecked ? 'checked' : ''}}>
                                            {{$childrenAxis->name}}
                                        </label>
                                    </li>
                                @endforeach
                                @endif
                            @else {{--市区町村のみ表示--}}
                                @foreach($fEntSearchAxisData->fEntSearchAxis->$axisType As $locationAxis)
                                    @php
                                        $isCheckedRoot = false; //上位要素が検索済みか
                                        if($criteria->prefCodes) {
                                            foreach(explode("[]", $criteria->prefCodes) As $rootCodesCriteria) {
                                                if($rootCodesCriteria == $locationAxis->parent) {
                                                    $isCheckedRoot = true;
                                                    break;
                                                }
                                            }
                                        }
                                        $isChecked = false;
                                        if($isCheckedRoot) {
                                            $isChecked = true;
                                        }
                                        if(!$isChecked) {
                                            if($criteria->$parentCriteria) {
                                                foreach(explode("[]", $criteria->$parentCriteria) As $parentCodesCriteria) {
                                                    if($parentCodesCriteria == $locationAxis->value) {
                                                        $isChecked = true;
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    @endphp
                                    <li class="child">
                                        <label for="jmod1-{{$locationAxis->value}}">
                                            <input type="checkbox" name="{{$parentUrlKey}}Checkbox" class="jmod-areacheck areaOverlayLabel" value="{{$locationAxis->value}}" id="jmod1-{{$locationAxis->value}}" {{$isChecked ? 'checked' : ''}}>
                                            {{$locationAxis->name}}
                                        </label>
                                    </li>
                                @endforeach
                                @break {{--外側のループを抜ける(複数表示防止)--}}
                            @endif
                        </ul>
                    </li>
                @endforeach
            {{--デフォルト検索軸 end--}}

            {{--カスタム検索軸 start--}}
            @else
                @foreach($fEntSearchAxisData->fEntSearchAxis->$axisType As $index => $locationAxis)
                    @php
                        $isCheckedParent = false;
                        if($locationAxis->type == 'bc') {
                            $parentCriteria = 'areaCodes';
                        }
                        elseif($locationAxis->type == 'area') {
                            $parentCriteria = 'prefCodes';
                        }
                        else {
                            $parentCriteria = 'cityCodes';
                        }
                        if(strpos($criteria->$parentCriteria, strval($locationAxis->value)) !== false) {
                            $isCheckedParent = true;
                        }
                    @endphp
                    <li class="parent">
                        <label for="jmod1-{{$index}}">
                            <input type="checkbox" name="{{$locationAxis->type}}Checkbox" class="jmod-areacheck areaOverlayLabel" value="{{$locationAxis->value}}" id="jmod1-{{$index}}" {{$isCheckedParent ? 'checked' : ''}}>
                            {{$locationAxis->name}}
                        </label>
                        @if($locationAxis->children) {{--子要素が存在するか--}}
                        <ul>
                            @foreach($locationAxis->children As $childIndex => $childrenAxis)
                                @php
                                    $isChecked = false;
                                    if($childrenAxis->type == 'area') {
                                        $childrenCriteria = 'prefCodes';
                                    }
                                    else {
                                        $childrenCriteria = 'cityCodes';
                                    }
                                    if($isCheckedParent) {
                                        $isChecked = true; //親要素にチェックが入っていれば自身もチェックを入れる
                                    }
                                    else {
                                        //検索条件文字列内での完全一致でチェックを入れるか判定
                                        if(strpos($criteria->$childrenCriteria, strval($childrenAxis->value)) !== false) {
                                            $isChecked = true;
                                        }
                                    }
                                @endphp
                                <li class="child">
                                    <label for="jmod1-{{$index}}-{{$childIndex}}">
                                        <input type="checkbox" name="{{$childrenAxis->type}}Checkbox" class="jmod-areacheck cityOverlayLabel" value="{{$childrenAxis->value}}" id="jmod1-{{$index}}-{{$childIndex}}" {{$isChecked ? 'checked' : ''}}>
                                        {{$childrenAxis->name}}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                @endforeach
            @endif
            {{--カスタム検索軸 end--}}
        </ul>
    </div>
</div>
@endif