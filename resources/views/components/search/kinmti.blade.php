@props(['arrayKinmti'])

@if(is_array($arrayKinmti) && count($arrayKinmti)>0)

    @php
    $arrayAddress = array();
    foreach($arrayKinmti As $kinmti) {
        $address = '';
        if($kinmti->prefName) {
            $address .= $kinmti->prefName;
            if($kinmti->cityName) {
                $address .= $kinmti->cityName;
            }
            $arrayAddress[] = $address;
        }
    }
    $kinmtiData = implode(' / ', $arrayAddress);
    @endphp

    @if($kinmtiData)
        <span class="text">{{$kinmtiData}}</span>
    @endif

@endif