<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @vite('resources/scss/admin/admin.scss')
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <div class="logo">⚡ ADMIN</div>

        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
            <i class="fa-solid fa-bars"></i> Dashboard
        </a>

        <a href="{{ route('companies.index') }}" class="nav-item {{ request()->is('admin/authors') ? 'active' : '' }}">
            <i class="fa-regular fa-building"></i> Company
        </a>

        <a href="{{ route('creator.index') }}" class="nav-item {{ request()->is('admin/authors') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i> Creator
        </a>

        <a href="{{ route('category.index') }}" class="nav-item {{ request()->is('admin/authors') ? 'active' : '' }}">
            <i class="fa-solid fa-layer-group"></i> Category
        </a>

        <a href="{{ route('game.index') }}" class="nav-item {{ request()->is('admin/authors') ? 'active' : '' }}">
            <i class="fa-solid fa-gamepad"></i> Game
        </a>

        <a href="{{ route('news.index') }}" class="nav-item {{ request()->is('control/news*') ? 'active' : '' }}">
            <i class="fa-solid fa-newspaper"></i> News
        </a>
        <a href="{{ route('settings.images') }}" class="nav-item {{ request()->is('control/settings*') ? 'active' : '' }}">
            <i class="fa-regular fa-image"></i> Image sizes
        </a>
    </div>
    <div class="main">
        <div class="header">
            <h1>@yield('title')</h1>
            <div class="user">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        Logout
                    </button>
                </form>
            </div>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>
<script src="https://kit.fontawesome.com/46a432ef36.js" crossorigin="anonymous"></script>
</body>
</html>