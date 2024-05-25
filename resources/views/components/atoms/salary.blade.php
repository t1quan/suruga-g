@props(['kyuyoMin','kyuyoMax','dispType' => 'number'])

@php
    $kyuyoMin = (int)$kyuyoMin;
    $kyuyoMax = (int)$kyuyoMax;

    $textFlg = false;
    if($dispType === "char") {
        $textFlg=true;
    }

    $num = $kyuyoMin;
    $moneyStr = '';
    if($num == null or $num == '') {
        $moneyStr = '';
    }
    else {
        if((($num%10000) == 0) && ($num > 10000) && $textFlg) {
            $num = $num/10000;
            $num = number_format($num);
            $moneyStr .= sprintf("%s万",$num);
        } else {
            $num = number_format($num);
            $moneyStr .= sprintf("%s",$num);
        }
    }
    $kyuyoMin = $moneyStr;


    $num = $kyuyoMax;
    $moneyStr = '';
    if($num == null or $num == '') {
        $moneyStr = '';
    }
    else {
        if((($num%10000) == 0) && ($num > 10000) && $textFlg) {
            $num = $num/10000;
            $num = number_format($num);
            $moneyStr .= sprintf("%s万",$num);
        } else {
            $num = number_format($num);
            $moneyStr .= sprintf("%s",$num);
        }
    }
    $kyuyoMax = $moneyStr;

@endphp

@if($kyuyoMin)
    @if($kyuyoMin > 0 && $kyuyoMax > 0)
    {{($kyuyoMin)}}円 ~ {{($kyuyoMax)}}円
    @elseif($kyuyoMin > 0 && $kyuyoMax == -1)
    {{($kyuyoMin)}}円 ~
    @elseif($kyuyoMin > 0)
    {{($kyuyoMin)}}円
    @endif
    <br />
@endif
