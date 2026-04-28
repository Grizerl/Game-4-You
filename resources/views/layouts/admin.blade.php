<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            background: radial-gradient(circle at top left, #0f172a, #020617);
            color: #e2e8f0;
        }

        .sidebar {
            width: 270px;
            height: 100vh;
            padding: 30px 20px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(255,255,255,0.05);
            position: fixed;
        }

        .logo {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 40px;
            letter-spacing: 1px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            color: #94a3b8;
            text-decoration: none;
            margin-bottom: 8px;
            transition: all 0.25s ease;
        }

        .nav-item:hover {
            background: rgba(59,130,246,0.15);
            color: #fff;
            transform: translateX(6px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: #fff;
            box-shadow: 0 8px 20px rgba(59,130,246,0.4);
        }

        .main {
            margin-left: 270px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .header h1 {
            font-size: 18px;
            font-weight: 500;
        }

        .user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .content {
            padding: 30px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
        }

        .card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(255,255,255,0.05);
            transition: 0.25s;
        }

        .card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        .card h3 {
            font-size: 13px;
            color: #94a3b8;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 28px;
            font-weight: 600;
            color: #fff;
        }

        .hero {
            margin-top: 30px;
            padding: 30px;
            border-radius: 18px;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            box-shadow: 0 20px 50px rgba(59,130,246,0.5);
        }

        .hero h2 {
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 14px;
            opacity: 0.9;
        }

        .user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logout-btn {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.2);
            color: #e2e8f0;
            padding: 6px 10px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.15);
            border-color: #ef4444;
            color: #ef4444;
        }
    </style>
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