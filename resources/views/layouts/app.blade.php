<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" type="image/png" href="{{ asset('images/omega.png') }}">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">
    <div id="app">
        @include('components.header')

        <main class="py-4">
            @yield('content')
        </main>

        @include('components.footer')
    </div>
</body>
</html>
