<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: radial-gradient(circle at top, #020617, #000);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .card {
            background: #ffffff;
            border-radius: 18px;
            padding: 32px 28px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.45);
        }

        .title {
            text-align: center;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #111827;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            font-size: 14px;
            transition: border .2s, box-shadow .2s;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        button {
            width: 100%;
            margin-top: 6px;
            padding: 12px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: transform .15s, box-shadow .15s, opacity .15s;
        }

        button:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, .35);
            opacity: .95;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .footer-text {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>

<body>

    <div class="auth-wrapper">
        <div class="card">
            <div class="title">Reset Password</div>
            <div class="subtitle">
                Silakan masukkan password baru Anda
            </div>

            @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-group">
                    <label>Password Baru</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password baru"
                        required>
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Ulangi password"
                        required>
                </div>

                <button type="submit">
                    Reset Password
                </button>
            </form>

            <div class="footer-text">
                © {{ date('Y') }} Quran Tracker
            </div>
        </div>
    </div>

</body>

</html>