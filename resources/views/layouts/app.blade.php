<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<body id="{{$page->id ?? ''}}">
    <div id="{{$page->id ?? ''}}Layout">
        <section class="container">

            <div id="{{$page->id ?? ''}}Nav">
                @include('layouts.header')
            </div>

            @yield('content')

            @include('layouts.footer')

        </section>
    </div>

</body>
</html>
