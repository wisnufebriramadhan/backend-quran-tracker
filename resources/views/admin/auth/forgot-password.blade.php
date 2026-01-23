<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <h2>Lupa Password</h2>

    @if (session('status'))
    <p style="color:green">{{ session('status') }}</p>
    @endif

    @if ($errors->any())
    <p style="color:red">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <label>Email</label><br>
        <input type="email" name="email" required><br><br>

        <button type="submit">Kirim Link Reset</button>
    </form>

</body>

</html>