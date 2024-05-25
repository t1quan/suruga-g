@props(['fEntSearchAxisData'])

<div class="parentBox">
    @foreach($fEntSearchAxisData->fEntSearchAxis->jobbc As $index => $jobAxis)
        <li class="parent" data-id="{{$index}}">
            <label for="jmod2-{{$index}}-modal">
                <input type="checkbox" name="modal-jobbcCheckbox" class="jmod-areacheck areaOverlayLabel" value="{{$jobAxis->value}}" id="jmod2-{{$index}}-modal">
                {{$jobAxis->name}}
            </label>
        </li>
    @endforeach
</div>

@foreach($fEntSearchAxisData->fEntSearchAxis->jobbc As $parentIndex => $jobAxis)
<div id="job-{{$parentIndex}}" class="childrenBox">
    <span class="select-all">全て選択する</span>
    @foreach($jobAxis->children As $childrenIndex => $childrenAxis)
    <li class="child" data-id="{{$parentIndex}}">
        <label for="jmod2-{{$parentIndex}}-{{$childrenIndex}}-modal">
            <input type="checkbox" name="modal-{{$jobAxis->type}}Checkbox" class="jmod-areacheck areaOverlayLabel" value="{{$childrenAxis->value}}" id="jmod2-{{$parentIndex}}-{{$childrenIndex}}-modal">
            {{$childrenAxis->name}}
        </label>
    </li>
    @endforeach
</div>
@endforeach