@props(['fEntSearchAxisData'])

<div class="childrenBox">
    <span class="select-all">全て選択する</span>
    @foreach($fEntSearchAxisData->fEntSearchAxis->kodawari As $index => $kodawariAxis)
    <li class="child" data-id="{{$index}}">
        <label for="jmod3-{{$index}}-modal">
            <input type="checkbox" name="modal-{{$kodawariAxis->type}}Checkbox" class="jmod-areacheck areaOverlayLabel" value="{{$kodawariAxis->value}}" id="jmod3-{{$index}}-modal">
            {{$kodawariAxis->name}}
        </label>
    </li>
    @endforeach
</div>