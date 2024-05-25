@props(['fEntSearchAxisData'])

<ul class="salaryAxisSp">
{{--@foreach($fEntSearchAxisData->fEntSearchAxis->jobbc As $index => $jobAxis)--}}
{{--    <li class="parentSP" data-id="{{$index}}-sp">--}}
{{--        <span class="spCheckParent"></span>--}}
{{--        <input type="checkbox" name="modal-jobbcCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="{{$jobAxis->value}}" id="jmod2-{{$index}}-modal-sp">--}}
{{--        <p>{{$jobAxis->name}}</p>--}}
{{--        <ul class="close">--}}
{{--        @foreach($jobAxis->children As $childrenIndex => $childrenAxis)--}}
{{--            <li class="childSP" data-id="{{$index}}-sp">--}}
{{--                <label for="jmod2-{{$index}}-{{$childrenIndex}}-modal-sp">--}}
{{--                    <span class="spCheck"></span>--}}
{{--                    <input type="checkbox" name="modal-{{$jobAxis->type}}CheckboxSP" class="jmod-areacheck areaOverlayLabel" value="{{$childrenAxis->value}}" id="jmod2-{{$index}}-{{$childrenIndex}}-modal-sp">--}}
{{--                    {{$childrenAxis->name}}--}}
{{--                </label>--}}
{{--            </li>--}}
{{--        @endforeach--}}
{{--        </ul>--}}
{{--    </li>--}}
{{--@endforeach--}}

    <li class="parentSP close" data-id="1-sp">
        <input type="checkbox" name="modal-salaryTypeCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="0" id="jmod4-1-modal-sp">
        <p>時給</p>
        <ul class="close">
            <li class="childSP" data-id="1">
                <label for="jmod4-1-0-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=1&kyuyomin=800" id="jmod4-1-0-modal-sp">
                    800円以上
                </label>
            </li>
            <li class="childSP" data-id="1">
                <label for="jmod4-1-1-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=1&kyuyomin=900" id="jmod4-1-1-modal-sp">
                    900円以上
                </label>
            </li>
            <li class="childSP" data-id="1">
                <label for="jmod4-1-2-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=1&kyuyomin=1000" id="jmod4-1-2-modal-sp">
                    1,000円以上
                </label>
            </li>
            <li class="childSP" data-id="1">
                <label for="jmod4-1-3-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=1&kyuyomin=1100" id="jmod4-1-3-modal-sp">
                    1,100円以上
                </label>
            </li>
            <li class="childSP" data-id="1">
                <label for="jmod4-1-4-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=1&kyuyomin=1200" id="jmod4-1-4-modal-sp">
                    1,200円以上
                </label>
            </li>
            <li class="childSP" data-id="1">
                <label for="jmod4-1-5-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=1&kyuyomin=1300" id="jmod4-1-5-modal-sp">
                    1,300円以上
                </label>
            </li>
            <li class="childSP" data-id="1">
                <label for="jmod4-1-6-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=1&kyuyomin=1400" id="jmod4-1-6-modal-sp">
                    1,400円以上
                </label>
            </li>
            <li class="childSP" data-id="1">
                <label for="jmod4-1-7-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=1&kyuyomin=1500" id="jmod4-1-7-modal-sp">
                    1,500円以上
                </label>
            </li>
            <li class="childSP" data-id="1">
                <label for="jmod4-1-8-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=1&kyuyomin=2000" id="jmod4-1-8-modal-sp">
                    2,000円以上
                </label>
            </li>
        </ul>
    </li>

    <li class="parentSP close" data-id="3-sp">
        <input type="checkbox" name="modal-salaryTypeCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="1" id="jmod4-3-modal-sp">
        <p>月給</p>
        <ul class="close">
            <li class="childSP" data-id="3">
                <label for="jmod4-3-0-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=3&kyuyomin=170000" id="jmod4-3-0-modal-sp">
                    17万円以上
                </label>
            </li>
            <li class="childSP" data-id="3">
                <label for="jmod4-3-1-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=3&kyuyomin=180000" id="jmod4-3-1-modal-sp">
                    18万円以上
                </label>
            </li>
            <li class="childSP" data-id="3">
                <label for="jmod4-3-2-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=3&kyuyomin=190000" id="jmod4-3-2-modal-sp">
                    19万円以上
                </label>
            </li>
            <li class="childSP" data-id="3">
                <label for="jmod4-3-3-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=3&kyuyomin=200000" id="jmod4-3-3-modal-sp">
                    20万円以上
                </label>
            </li>
            <li class="childSP" data-id="3">
                <label for="jmod4-3-4-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=3&kyuyomin=210000" id="jmod4-3-4-modal-sp">
                    21万円以上
                </label>
            </li>
            <li class="childSP" data-id="3">
                <label for="jmod4-3-5-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=3&kyuyomin=220000" id="jmod4-3-5-modal-sp">
                    22万円以上
                </label>
            </li>
            <li class="childSP" data-id="3">
                <label for="jmod4-3-6-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=3&kyuyomin=230000" id="jmod4-3-6-modal-sp">
                    23万円以上
                </label>
            </li>
            <li class="childSP" data-id="3">
                <label for="jmod4-3-7-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=3&kyuyomin=240000" id="jmod4-3-7-modal-sp">
                    24万円以上
                </label>
            </li>
            <li class="childSP" data-id="3">
                <label for="jmod4-3-8-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=3&kyuyomin=250000" id="jmod4-3-8-modal-sp">
                    25万円以上
                </label>
            </li>
            <li class="childSP" data-id="3">
                <label for="jmod4-3-9-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=3&kyuyomin=300000" id="jmod4-3-9-modal-sp">
                    30万円以上
                </label>
            </li>
            <li class="childSP" data-id="3">
                <label for="jmod4-3-10-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=3&kyuyomin=350000" id="jmod4-3-10-modal-sp">
                    35万円以上
                </label>
            </li>
            <li class="childSP" data-id="3">
                <label for="jmod4-3-11-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=3&kyuyomin=400000" id="jmod4-3-11-modal-sp">
                    40万円以上
                </label>
            </li>
            <li class="childSP" data-id="3">
                <label for="jmod4-3-12-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=3&kyuyomin=500000" id="jmod4-3-12-modal-sp">
                    50万円以上
                </label>
            </li>
            <li class="childSP" data-id="3">
                <label for="jmod4-3-13-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=3&kyuyomin=600000" id="jmod4-3-13-modal-sp">
                    60万円以上
                </label>
            </li>
            <li class="childSP" data-id="3">
                <label for="jmod4-3-14-modal-sp">
                    <span class="spCheck"></span>
                    <input type="checkbox" name="modal-salaryCheckboxSP" class="jmod-areacheck areaOverlayLabel" value="kyuyo=3&kyuyomin=700000" id="jmod4-3-14-modal-sp">
                    70万円以上
                </label>
            </li>
        </ul>
    </li>
</ul>