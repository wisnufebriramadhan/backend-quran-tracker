<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Quran Journey</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}">
</head>

<body>

    <header>
        <div class="title">
            <h1>Quran Journey</h1>
            <span>Assalamualaikum</span>
        </div>

        <nav>
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
                <button class="logout">Logout</button>
            </form>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        Admin Panel • Laravel {{ app()->version() }}
    </footer>

</body>

</html>