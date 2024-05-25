@props(['fEntSearchAxisData'])

<ul class="kodawariAxisSp">
    @foreach($fEntSearchAxisData->fEntSearchAxis->kodawari As $index => $kodawariAxis)
    <li class="childSP" data-id="{{$index}}">
        <label for="jmod3-{{$index}}-modal-sp">
            <span class="spCheck"></span>
            <input type="checkbox" name="modal-{{$kodawariAxis->type}}CheckboxSP" class="jmod-areacheck areaOverlayLabel" value="{{$kodawariAxis->value}}" id="jmod3-{{$index}}-modal-sp">
            {{$kodawariAxis->name}}
        </label>
    </li>
    @endforeach
</ul>