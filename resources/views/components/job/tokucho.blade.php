@props(['tokucho'])

@if(isset($tokucho))
<div class="tokucho_job_block">
    <i class="indicatorFeature">
        <div class="tokucho_icon_image">
            <img src="{{asset('images/icon/icon_tokucho_'.$tokucho->tokuchoCode.'.png')}}" alt="{{$tokucho->tokuchoName}}" title="{{$tokucho->tokuchoName}}">
        </div>
        <div class="tokucho_icon_text">{{$tokucho->tokuchoName}}</div>
    </i>
</div>
@endif
