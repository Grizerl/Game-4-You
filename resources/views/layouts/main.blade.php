<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="images" href="/assets/images/logo-vAIZT_ch.png">
    <link rel="stylesheet" crossorigin href="/assets/css/index.css">
    <link rel="stylesheet" crossorigin href="/assets/css/details.css">
    @stack('styles')
    <title>@yield('title', 'Games 4 You')</title>
    @stack('head')
</head>
<body>
    @include('partials.header')
    @include('partials.footer')
    <script src="/assets/js/details/btn.js"></script>
    <script src="/assets/js/menu/menu.js"></script>
    @stack('scripts')
</body>
</html>