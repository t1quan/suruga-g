@props(['fEntSearchAxisData'])

<ul class="jobAxisSp">
@foreach($fEntSearchAxisData->fEntSearchAxis->jobbc As $index => $jobAxis)
    <li class="parentSP close" data-id="{{$index}}-sp">
        <span class="spCheckParent"></span>
        <input type="checkbox" name="modal-jobbcCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="{{$jobAxis->value}}" id="jmod2-{{$index}}-modal-sp">
        <p>{{$jobAxis->name}}</p>
        <ul class="close">
        @foreach($jobAxis->children As $childrenIndex => $childrenAxis)
            <li class="childSP" data-id="{{$index}}-sp">
                <label for="jmod2-{{$index}}-{{$childrenIndex}}-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-{{$jobAxis->type}}CheckboxSP" class="jmod-areacheck areaOverlayLabel" value="{{$childrenAxis->value}}" id="jmod2-{{$index}}-{{$childrenIndex}}-modal-sp">
                    {{$childrenAxis->name}}
                </label>
            </li>
        @endforeach
        </ul>
    </li>
@endforeach
</ul>