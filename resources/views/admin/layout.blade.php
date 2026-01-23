<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Quran Journey - {{ auth()->user()->name ?? 'Admin' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}">

    <style>
        /* Modern Layout Enhancement */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --purple: #a855f7;
            --purple-dark: #7c3aed;
            --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Compact Header - Single Row */
        header {
            background: var(--bg-gradient);
            color: white;
            box-shadow: var(--shadow-xl);
            position: sticky;
            top: 0;
            z-index: 1000;
            animation: slideDown 0.6s ease;
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            gap: 32px;
        }

        /* Compact Title */
        .title {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .title-icon {
            font-size: 32px;
            animation: float 3s ease-in-out infinite;
        }

        .title-text h1 {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            line-height: 1;
        }

        .title-text span {
            font-size: 11px;
            opacity: 0.85;
            font-weight: 400;
        }

        /* Compact Navigation */
        nav {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            overflow-x: auto;
            scrollbar-width: none;
        }

        nav::-webkit-scrollbar {
            display: none;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            white-space: nowrap;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid transparent;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        nav a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        nav a.active {
            background: white;
            color: var(--purple);
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Icon untuk setiap menu */
        nav a::before {
            font-size: 16px;
        }

        nav a[href*="dashboard"]::before {
            content: '📊';
        }

        nav a[href*="users"]::before {
            content: '👥';
        }

        nav a[href*="quran"]::before {
            content: '📖';
        }

        nav a[href*="learning"]::before {
            content: '🎓';
        }

        nav form {
            margin: 0;
        }

        nav button.logout {
            background: rgba(239, 68, 68, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: inherit;
            white-space: nowrap;
        }

        nav button.logout::before {
            content: '🚪';
            font-size: 16px;
        }

        nav button.logout:hover {
            background: rgba(239, 68, 68, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* Compact User Info */
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 8px 16px;
            border-radius: 50px;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .user-info:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            color: var(--purple);
        }

        .user-details {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .user-name {
            font-weight: 600;
            font-size: 13px;
            line-height: 1;
        }

        .user-role {
            font-size: 10px;
            opacity: 0.85;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 24px;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            flex-shrink: 0;
        }

        /* Enhanced Main Content */
        main {
            flex: 1;
            max-width: 1400px;
            margin: 0 auto;
            padding: 32px 24px;
            width: 100%;
            animation: fadeIn 0.8s ease;
        }

        /* Enhanced Footer */
        footer {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
            text-align: center;
            padding: 32px 24px;
            margin-top: auto;
            box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .footer-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 700;
        }

        .footer-brand::before {
            content: '🕌';
            font-size: 32px;
        }

        .footer-links {
            display: flex;
            gap: 24px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
            transform: translateY(-2px);
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
        }

        .footer-tech {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-tech span {
            background: rgba(255, 255, 255, 0.1);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        /* Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-100%);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-5px) rotate(5deg);
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .header-container {
                gap: 16px;
            }

            nav a,
            nav button.logout {
                padding: 8px 16px;
                font-size: 13px;
            }

            .footer-top {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }
        }

        @media (max-width: 768px) {
            .header-container {
                gap: 12px;
                flex-wrap: wrap;
            }

            .title-text span {
                display: none;
            }

            .user-details {
                display: none;
            }

            nav {
                display: none;
                position: fixed;
                top: 72px;
                left: 0;
                right: 0;
                background: var(--bg-gradient);
                flex-direction: column;
                padding: 20px;
                gap: 12px;
                box-shadow: var(--shadow-xl);
                border-radius: 0 0 20px 20px;
                order: 4;
                width: 100%;
            }

            nav.active {
                display: flex;
            }

            nav a {
                width: 100%;
                justify-content: center;
            }

            nav form {
                width: 100%;
            }

            nav button.logout {
                width: 100%;
                justify-content: center;
            }

            .mobile-menu-toggle {
                display: block;
            }

            main {
                padding: 20px 16px;
            }

            .footer-links {
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="header-container">
            <!-- Title Section -->
            <div class="title">
                <div class="title-icon">🕌</div>
                <div class="title-text">
                    <h1>Quran Journey</h1>
                    <span>Assalamualaikum ✨</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav id="mainNav">
                {{-- DASHBOARD (ADMIN & USER) --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                {{-- USERS (ADMIN ONLY) --}}
                @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('admin.users.index') }}"
                    class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    Users
                </a>
                @endif

                {{-- QURAN LOGS --}}
                <a href="{{ route('admin.quran.logs') }}"
                    class="{{ request()->routeIs('admin.quran.*') ? 'active' : '' }}">
                    Quran Logs
                </a>

                {{-- LEARNING --}}
                <a href="{{ route('admin.learning.index') }}"
                    class="{{ request()->routeIs('admin.learning.*') ? 'active' : '' }}">
                    Pembelajaran
                </a>

                {{-- LOGOUT --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout">Logout</button>
                </form>
            </nav>

            <!-- User Info -->
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="user-details">
                    <div class="user-name">{{ auth()->user()->name ?? 'User' }}</div>
                    <div class="user-role">
                        {{ auth()->user()->isAdmin() ? '👑 Admin' : '👤 User' }}
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                ☰
            </button>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-top">
                <div class="footer-brand">
                    Quran Journey
                </div>
                <div class="footer-links">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a href="{{ route('admin.quran.logs') }}">Quran Logs</a>
                    <a href="{{ route('admin.learning.index') }}">Pembelajaran</a>
                    <a href="#" onclick="alert('Coming soon!'); return false;">Help</a>
                </div>
            </div>
            <div class="footer-bottom">
                <div>
                    &copy; {{ date('Y') }} Quran Journey. All rights reserved.
                </div>
                <div class="footer-tech">
                    <span>Laravel {{ app()->version() }}</span>
                    <span>PHP {{ PHP_VERSION }}</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const nav = document.getElementById('mainNav');
            nav.classList.toggle('active');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const nav = document.getElementById('mainNav');
            const toggle = document.querySelector('.mobile-menu-toggle');

            if (!nav.contains(event.target) && !toggle.contains(event.target)) {
                nav.classList.remove('active');
            }
        });

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add animation to navigation items on load
        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('nav a, nav form');
            navItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    item.style.transition = 'all 0.4s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 50);
            });
        });
    </script>

</body>

</html>