<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" type="image/png" href="{{ asset('images/omega.png') }}">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    @auth
        @if(auth()->user()->isAdmin())
            <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
        @elseif(auth()->user()->isVendor())
            <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
        @endif
    @endauth
</head>
<body id="top" class="dark-mode @if(auth()->check() && !auth()->user()->isAdmin() && !auth()->user()->isVendor()) user-theme @endif">
    @include('components.header')

    
        @auth
            @include('components.leftbar')
        @endauth
        <main class="main-content">
            @include('components.alerts')
            @yield('content')
        </main>
    </div>
    
    <!-- Footer include removed -->
    
    <a href="#top" class="scroll-button scroll-top" title="Scroll to top">▲</a>
    <a href="#bottom" class="scroll-button scroll-bottom" title="Scroll to bottom">▼</a>
    <div id="bottom"></div>
</body>
</html>
