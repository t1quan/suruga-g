@props([
'for',
'errors'
])

@if ($errors->any())
@if (isset($for))
    @if ($errors->has($for))
    <ul class="error_message" style="font-size: 14px;line-height: 1.25;">
        @foreach($errors->get($for) as $msg)
        <li>
            <span class="error">{{ $msg }}</span>
        </li>
        @endforeach
    </ul>
    @endif
@endif
@endif
