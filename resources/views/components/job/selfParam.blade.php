@props(['selfParams'])

@if(is_array($selfParams) && count($selfParams) > 0)
    @if($selfParams[0]->selfParamCode && $selfParams[0]->percentCode)
    <div class="self_barometer">
        <img class="self_barometer_logo" alt="" src="{{asset('images/self/barometer2.png')}}" title="&quot自分力&quotバロメータ">
        <div class="self_parameter_list">
            @foreach($selfParams as $selfParamInfo)
                @if($selfParamInfo->selfParamCode && $selfParamInfo->percentCode)
                <div class="self_parameter">
                    <img class="self_parameter_text" src="{{asset('images/self/w'.$selfParamInfo->selfParamCode.'.png')}}" alt="{{$selfParamInfo->selfParamName}}" title="{{$selfParamInfo->selfParamName}}">
                    <img class="self_parameter_gauge" src="{{asset('images/self/p'.$selfParamInfo->percentCode.'.png')}}" alt="{{$selfParamInfo->percentCode}}">
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif
@endif
