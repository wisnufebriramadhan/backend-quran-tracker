<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}">
</head>

<body>

    <header>
        <div class="title">
            <h1>Admin Panel</h1>
            <span>Quran Journey</span>
        </div>

        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Users</a>
            <a href="{{ route('admin.quran.logs') }}" class="{{ request()->routeIs('admin.quran.*') ? 'active' : '' }}">Quran Logs</a>
            <a href="{{ route('admin.learning.index') }}" class="{{ request()->routeIs('admin.learning.*') ? 'active' : '' }}">Pembelajaran</a>

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