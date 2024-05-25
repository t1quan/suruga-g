@props(['fEntSearchAxisData'])

<ul class="areaAxisSp">
@foreach($fEntSearchAxisData->fEntSearchAxis->area As $locationAxis)
    <li class="grandParentSP close" data-id="{{$locationAxis->value}}-sp">
        <label for="jmod1-{{$locationAxis->value}}-modal-sp">
            <input type="checkbox" name="modal-bcCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="{{$locationAxis->value}}" id="jmod1-{{$locationAxis->value}}-modal-sp">
            {{$locationAxis->name}}
        </label>
        <ul>
        @foreach($locationAxis->children As $childrenAxis)
            <li class="parentSP close" data-id="{{$childrenAxis->value}}-sp">
                <span class="spCheckParent"></span>
{{--                <label for="jmod1-{{$locationAxis->value}}-{{$childrenAxis->value}}-sp">--}}
                    <input type="checkbox" name="modal-areaCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="{{$childrenAxis->value}}" id="jmod1-{{$locationAxis->value}}-{{$childrenAxis->value}}-modal-sp">
                    <p>{{$childrenAxis->name}}</p>
{{--                </label>--}}
                <ul>
                @foreach($fEntSearchAxisData->fEntSearchAxis->pref As $prefAxis)
                @if($prefAxis->value === $childrenAxis->value)
                    @foreach($prefAxis->children As $cityAxis)
                    <li class="childSP" data-id="{{$prefAxis->value}}-sp">
                        <label for="jmod1-{{$prefAxis->value}}-{{$cityAxis->value}}-modal-sp">
                            <span class="spCheck"></span>
                            <input type="checkbox" name="modal-cityCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="{{$cityAxis->value}}" id="jmod1-{{$prefAxis->value}}-{{$cityAxis->value}}-modal-sp">
                            {{$cityAxis->name}}
                        </label>
                    </li>
                    @endforeach
                @endif
                @endforeach
                </ul>
            </li>
        @endforeach
        </ul>
    </li>
@endforeach
</ul>