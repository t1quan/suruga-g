@props(['fEntSearchAxisData','criteria'])

@php

$axisType = null;

//表示優先順はjobbc > job としておく
if($fEntSearchAxisData->fEntSearchAxis->job) {
    $axisType = 'job';
}

if($fEntSearchAxisData->fEntSearchAxis->jobbc) {
    $axisType = 'jobbc';
}

@endphp

@if($axisType)
<div class="searchCondListJob">
    <div class="searchListLabel close">職種</div>
    <div class="searchListBody">
        <ul>
            {{--デフォルト検索軸 start--}}
            @if(!$fEntSearchAxisData->isCustomJob)
                @foreach($fEntSearchAxisData->fEntSearchAxis->$axisType As $jobAxis)
                    @if($axisType === 'jobbc')
                        @php
                            $isCheckedParent = false;
                            foreach(explode("[]", $criteria->jobGroupCodes) As $jobGroupCodesCriteria) {
                                if($jobGroupCodesCriteria == $jobAxis->value) {
                                $isCheckedParent = true;
                                break;
                                }
                            }
                        @endphp
                    @endif
                    <li class="parent">
                        @if($axisType === 'jobbc')
                        <label for="jmod2-{{$jobAxis->value}}">
                            <input type="checkbox" name="{{$jobAxis->type}}Checkbox" class="jmod-jobcheck {{$jobAxis->type}}OverlayLabel" value="{{$jobAxis->value}}" id="jmod2-{{$jobAxis->value}}" {{$isCheckedParent ? 'checked' : ''}}>
                            {{$jobAxis->name}}
                        </label>
                        @endif
                        <ul>
                            @if($axisType === 'jobbc')
                                @if($jobAxis->children)
                                @foreach($jobAxis->children As $childrenAxis)
                                    @php
                                        $isChecked = false;
                                        if($isCheckedParent) {
                                            $isChecked = true; //親要素にチェックが入っていれば自身もチェックを入れる
                                        }
                                        else {
                                            foreach(explode("[]", $criteria->jobCodes) As $jobCodesCriteria) {
                                                if($jobCodesCriteria == $childrenAxis->value) {
                                                    $isChecked = true;
                                                    break;
                                                }
                                            }
                                        }
                                    @endphp
                                    <li class="child">
                                        <label for="jmod2-{{$jobAxis->value}}-{{$childrenAxis->value}}">
                                            <input type="checkbox" name="jobCheckbox" class="jmod-jobcheck jobOverlayLabel" value="{{$childrenAxis->value}}" id="jmod2-{{$jobAxis->value}}-{{$childrenAxis->value}}" {{$isChecked ? 'checked' : ''}}>
                                            {{$childrenAxis->name}}
                                        </label>
                                    </li>
                                @endforeach
                                @endif
                            @else {{--職種のみ表示--}}
                                @foreach($fEntSearchAxisData->fEntSearchAxis->$axisType As $jobAxis)
                                    @php
                                        $isChecked = false;
                                        foreach(explode("[]", $criteria->jobCodes) As $jobCodesCriteria) {
                                            if($jobCodesCriteria == $jobAxis->value) {
                                                $isChecked = true;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <li class="child">
                                        <label for="jmod2-{{$jobAxis->value}}">
                                            <input type="checkbox" name="{{$jobAxis->type}}Checkbox" class="jmod-jobcheck jobOverlayLabel" value="{{$jobAxis->value}}" id="jmod2-{{$jobAxis->value}}" {{$isChecked ? 'checked' : ''}}>
                                            {{$jobAxis->name}}
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
                @foreach($fEntSearchAxisData->fEntSearchAxis->$axisType As $index => $jobAxis)
                    @php
                        $isCheckedParent = false;
                        if($jobAxis->type == 'jobbc') {
                            $parentCriteria = 'jobGroupCodes';
                        }
                        if($jobAxis->type == 'job') {
                            $parentCriteria = 'jobCodes';
                        }
                        if($jobAxis->type == 'kw') {
                            $parentCriteria = 'keyword';
                        }
                        if(strpos($criteria->$parentCriteria, strval($jobAxis->value)) !== false) {
                            $isCheckedParent = true;
                        }
                    @endphp
                    <li class="parent">
                        <label for="jmod2-{{$index}}">
                            <input type="checkbox" name="{{$jobAxis->type}}Checkbox" class="jmod-jobcheck jobOverlayLabel" value="{{$jobAxis->value}}" id="jmod2-{{$index}}" {{$isCheckedParent ? 'checked' : ''}}>
                            {{$jobAxis->name}}
                        </label>
                        @if($jobAxis->children) {{--子要素が存在するか--}}
                        <ul>
                            @foreach($jobAxis->children As $childIndex => $childrenAxis)
                                @php
                                    $isChecked = false;
                                    if($childrenAxis->type == 'jobbc') {
                                        $childrenCriteria = 'jobGroupCodes';
                                    }
                                    if($childrenAxis->type == 'job') {
                                        $childrenCriteria = 'jobCodes';
                                    }
                                    if($childrenAxis->type == 'kw') {
                                        $childrenCriteria = 'keyword';
                                    }
                                    if($isCheckedParent) {
                                        $isChecked = true; //親要素にチェックが入っていれば自身もチェックを入れる
                                    }
                                    else {
                                        if($criteria->$childrenCriteria) {
                                            if($childrenAxis->type !== 'kw') {
                                                $arrayCriteriaJobCodes = explode('[]', $criteria->$childrenCriteria);
                                                if(in_array(strval($childrenAxis->value), $arrayCriteriaJobCodes)) {
                                                    $isChecked = true;
                                                }
                                            }
                                            else {
                                                //検索条件文字列内での完全一致でチェックを入れるか判定
                                                if(strpos($criteria->$childrenCriteria, strval($childrenAxis->value)) !== false) {
                                                    $isChecked = true;
                                                }
                                            }
                                        }
                                    }
                                @endphp
                                <li class="child">
                                    <label for="jmod2-{{$index}}-{{$childIndex}}">
                                        <input type="checkbox" name="{{$childrenAxis->type}}Checkbox" class="jmod-jobcheck jobOverlayLabel" value="{{$childrenAxis->value}}" id="jmod2-{{$index}}-{{$childIndex}}" {{$isChecked ? 'checked' : ''}}>
                                        {{$childrenAxis->name}}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
@endif
