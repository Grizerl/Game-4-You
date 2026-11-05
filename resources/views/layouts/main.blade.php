<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="images" href="/assets/images/logo-vAIZT_ch.png">
    {{-- Шрифти підключаються тегом, а не @import у CSS: так вони вантажаться паралельно зі стилями, а не після них. --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&amp;family=Righteous&amp;display=swap">
    @vite(['resources/scss/public/index.scss', 'resources/scss/public/details.scss', 'resources/scss/public/search.scss'])
    @stack('styles')
    <title>@yield('title', 'Games 4 You')</title>
    @stack('head')
</head>
<body>
    @include('partials.header')
    @include('partials.footer')
    <script src="/assets/js/details/btn.js"></script>
    <script src="/assets/js/search/header.js" defer></script>
    <script src="/assets/js/search/search.js" defer></script>
    @stack('scripts')
</body>
</html>