@props(['disabled' => false])

@if($disabled)
<div>
    <input type="hidden">
    {{$attributes->value ?? ''}}
</div>
@else
<input {!! $attributes !!}>
@endif
