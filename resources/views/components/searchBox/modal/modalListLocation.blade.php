@props(['fEntSearchAxisData'])

<div class="grandParentBox">
@foreach($fEntSearchAxisData->fEntSearchAxis->area As $locationAxis)
    <li class="grandParent" data-id="{{$locationAxis->value}}">
        <label for="jmod1-{{$locationAxis->value}}-modal">
            <input type="checkbox" name="modal-bcCheckbox" class="jmod-areacheck areaOverlayLabel" value="{{$locationAxis->value}}" id="jmod1-{{$locationAxis->value}}-modal">
            {{$locationAxis->name}}
        </label>
    </li>
@endforeach
</div>

@foreach($fEntSearchAxisData->fEntSearchAxis->area As $locationAxis)
<div id="area-{{$locationAxis->value}}" class="parentBox" data-id="{{$locationAxis->value}}">
    @foreach($locationAxis->children As $childrenAxis)
    <li class="parent" data-id="{{$childrenAxis->value}}">
        <label for="jmod1-{{$locationAxis->value}}-{{$childrenAxis->value}}-modal">
            <input type="checkbox" name="modal-areaCheckbox" class="jmod-areacheck areaOverlayLabel" value="{{$childrenAxis->value}}" id="jmod1-{{$locationAxis->value}}-{{$childrenAxis->value}}-modal">
            {{$childrenAxis->name}}
        </label>
    </li>
    @endforeach
</div>
@endforeach

@foreach($fEntSearchAxisData->fEntSearchAxis->pref As $locationAxis)
<div id="pref-{{$locationAxis->value}}" class="childrenBox">
    <span class="select-all">全て選択する</span>
    @foreach($locationAxis->children As $childrenAxis)
    <li class="child" data-id="{{$locationAxis->value}}">
        <label for="jmod1-{{$locationAxis->value}}-{{$childrenAxis->value}}-modal">
            <input type="checkbox" name="modal-cityCheckbox" class="jmod-areacheck areaOverlayLabel" value="{{$childrenAxis->value}}" id="jmod1-{{$locationAxis->value}}-{{$childrenAxis->value}}-modal">
            {{$childrenAxis->name}}
        </label>
    </li>
    @endforeach
</div>
@endforeach