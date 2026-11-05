@php
    $nav = [
        'Overview' => [
            ['Dashboard', 'dashboard', 'fa-solid fa-chart-pie', 'dashboard'],
        ],
        'Catalog' => [
            ['Games', 'game.index', 'fa-solid fa-gamepad', 'game.*'],
            ['Categories', 'category.index', 'fa-solid fa-layer-group', 'category.*'],
            ['Creators', 'creator.index', 'fa-solid fa-user-pen', 'creator.*'],
            ['Companies', 'companies.index', 'fa-regular fa-building', 'companies.*'],
        ],
        'Content' => [
            ['News', 'news.index', 'fa-solid fa-newspaper', 'news.*'],
        ],
        'System' => [
            ['Users', 'users.index', 'fa-solid fa-users', 'users.*'],
            ['Image sizes', 'settings.images', 'fa-regular fa-image', 'settings.*'],
        ],
    ];
    $currentUser = auth()->user();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin') · Game 4 You Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/scss/admin/admin.scss')
    @stack('styles')
</head>
<body>
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="logo">
            <span class="logo-mark"><i class="fa-solid fa-bolt"></i></span>
            <span>Game 4 You <small>Admin</small></span>
        </a>

        <nav class="nav">
            @foreach ($nav as $group => $items)
                <div class="nav-group">{{ $group }}</div>
                @foreach ($items as [$label, $route, $icon, $pattern])
                    <a href="{{ route($route) }}" class="nav-item {{ request()->routeIs($pattern) ? 'active' : '' }}">
                        <i class="{{ $icon }}"></i> <span>{{ $label }}</span>
                    </a>
                @endforeach
            @endforeach
        </nav>

        <a href="{{ route('home.page') }}" class="nav-item nav-site" target="_blank" rel="noopener">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> <span>View site</span>
        </a>
    </aside>

    <div class="main">
        <header class="header">
            <h1>@yield('title')</h1>
            <div class="user">
                <div class="user-info">
                    <strong>{{ $currentUser?->name }}</strong>
                    <span>{{ $currentUser?->email }}</span>
                </div>
                <div class="avatar">{{ mb_strtoupper(mb_substr($currentUser?->name ?? '?', 0, 1)) }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                </form>
            </div>
        </header>

        <main class="content">
            @if (session('status'))
                <div class="flash flash-success" role="status"><i class="fa-solid fa-circle-check"></i> {{ session('status') }}</div>
            @endif
            @if (session('error'))
                <div class="flash flash-error" role="alert"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
<script src="https://kit.fontawesome.com/46a432ef36.js" crossorigin="anonymous"></script>
</body>
</html>
