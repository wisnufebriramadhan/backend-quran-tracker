<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --primary: #2563eb;
            --bg: #f4f6f8;
            --card: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        header {
            background: var(--card);
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .06);
        }

        header h1 {
            font-size: 20px;
            margin: 0;
        }

        main {
            padding: 32px;
            max-width: 1200px;
            margin: auto;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .card {
            background: var(--card);
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .06);
        }

        .card h2 {
            margin: 0;
            font-size: 14px;
            color: var(--muted);
            font-weight: 500;
        }

        .card .value {
            margin-top: 8px;
            font-size: 32px;
            font-weight: bold;
        }

        .actions {
            margin-top: 32px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        a.button {
            background: var(--primary);
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        button.logout {
            background: transparent;
            border: 1px solid #ddd;
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            font-size: 13px;
            color: var(--muted);
        }
    </style>
</head>

<body>

    <header>
        <h1>Admin Dashboard</h1>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout" type="submit">Logout</button>
        </form>
    </header>

    <main>

        <div class="grid">
            <div class="card">
                <h2>Total Users</h2>
                <div class="value">{{ $totalUsers }}</div>
            </div>

            {{-- nanti bisa nambah --}}
            <div class="card">
                <h2>Status Sistem</h2>
                <div class="value" style="color: green;">Normal</div>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('admin.users.index') }}" class="button">
                User Management
            </a>
        </div>

        <footer>
            Admin Panel • Laravel {{ app()->version() }}
        </footer>

    </main>

</body>

</html>