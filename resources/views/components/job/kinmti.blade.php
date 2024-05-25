@props(['kinmti'])

@if(isset($kinmti))

    @if($kinmti->kinmutiName)
        {{$kinmti->kinmutiName}}<br>
    @endif

    @php
        $address = null;
        if($kinmti->prefName) {
            $address .= '・';
            $address .= $kinmti->prefName;
            if($kinmti->cityName) {
                $address .= $kinmti->cityName;
                if($kinmti->kinmutiAddress) {
                    $address .= $kinmti->kinmutiAddress;
                }
            }
            echo($address);
            echo('<br>');
        }
    @endphp

    @if($kinmti->kotu)
        ・{{$kinmti->kotu}}<br>
    @endif

    @if($kinmti->arrayFEntStation)
        【最寄り駅】<br>
        @foreach($kinmti->arrayFEntStation as $station)
            @if(isset($station->lineName))
                @if(isset($station->stationName))
                ・{{$station->lineName}}「{{$station->stationName}}駅」<br>
                @else
                ・{{$station->lineName}}<br>
                @endif
            @endif
        @endforeach
    @endif
    <br>
    
@endif
