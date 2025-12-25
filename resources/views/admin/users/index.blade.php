<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: system-ui;
            background: #f4f6f8;
            padding: 30px;
        }

        table {
            width: 100%;
            background: #fff;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f9fafb;
            text-align: left;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .admin {
            background: #2563eb;
            color: white;
        }

        .user {
            background: #6b7280;
            color: white;
        }

        .active {
            color: green;
        }

        .inactive {
            color: red;
        }

        button {
            padding: 6px 10px;
            margin-right: 6px;
        }

        .top {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="top">
        <h2>User Management</h2>
        <a href="{{ route('admin.dashboard') }}">← Dashboard</a>
    </div>

    @if (session('success'))
    <p style="color:green">{{ session('success') }}</p>
    @endif

    @if (session('error'))
    <p style="color:red">{{ session('error') }}</p>
    @endif

    <table>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <span class="badge {{ $user->role }}">
                    {{ strtoupper($user->role) }}
                </span>
            </td>
            <td>
                <strong class="{{ $user->is_active ? 'active' : 'inactive' }}">
                    {{ $user->is_active ? 'ACTIVE' : 'INACTIVE' }}
                </strong>
            </td>
            <td>
                <form method="POST" action="{{ route('admin.users.toggleActive', $user) }}" style="display:inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit">
                        {{ $user->is_active ? 'Disable' : 'Enable' }}
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.users.toggleRole', $user) }}" style="display:inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit">
                        {{ $user->role === 'admin' ? 'Jadikan User' : 'Jadikan Admin' }}
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

</body>

</html>