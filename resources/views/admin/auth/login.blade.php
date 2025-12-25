<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: #fff;
            padding: 24px;
            border-radius: 8px;
            width: 320px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .1);
        }

        h2 {
            margin-bottom: 16px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="card">
        <h2>Admin Login</h2>

        @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input
                type="email"
                name="email"
                placeholder="Email"
                required
                autofocus>

            <input
                type="password"
                name="password"
                placeholder="Password"
                required>

            <button type="submit">Login</button>
        </form>
    </div>

</body>

</html>