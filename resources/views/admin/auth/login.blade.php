<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login • WisnuFebri</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary: #2563eb;
            --primary-soft: #e0e7ff;
            --bg-dark: #020617;
            --card: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --danger: #dc2626;
            --success: #16a34a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: radial-gradient(circle at top, #1e293b, #020617);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 360px;
            background: var(--card);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, .35);
            animation: fadeUp .6s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 22px;
        }

        .login-header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
        }

        .login-header p {
            margin-top: 6px;
            font-size: 13px;
            color: var(--muted);
        }

        .form-group {
            margin-bottom: 14px;
            position: relative;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #334155;
        }

        input {
            width: 100%;
            padding: 11px 12px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            font-size: 14px;
            background: #f9fafb;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px var(--primary-soft);
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 36px;
            font-size: 13px;
            cursor: pointer;
            color: var(--primary);
            user-select: none;
        }

        .error {
            background: #fef2f2;
            color: var(--danger);
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 14px;
        }

        button {
            width: 100%;
            padding: 11px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        button:disabled {
            opacity: .7;
            cursor: not-allowed;
        }

        .captcha {
            background: #f8fafc;
            padding: 10px;
            border-radius: 8px;
            font-size: 14px;
            text-align: center;
            margin-bottom: 14px;
            font-weight: 700;
            letter-spacing: 3px;
        }

        .forgot-password {
            text-align: center;
            margin-top: 10px;
        }

        .forgot-password a {
            font-size: 13px;
            color: var(--primary);
            cursor: pointer;
            text-decoration: none;
        }

        .login-footer {
            text-align: center;
            margin-top: 16px;
            font-size: 12px;
            color: var(--muted);
        }

        /* MODAL */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-box {
            background: var(--card);
            width: 100%;
            max-width: 340px;
            border-radius: 18px;
            padding: 22px;
            text-align: center;
        }

        .modal-box h3 {
            margin-top: 0;
            margin-bottom: 12px;
        }

        .modal-box .msg {
            font-size: 13px;
            margin-top: 10px;
            min-height: 18px;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="login-header">
            <h1>Login</h1>
            <p>Secure access to system dashboard</p>
        </div>

        @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required autofocus>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" required>
                <span class="toggle-password" onclick="togglePassword()">Show</span>
            </div>

            <div class="captcha">{{ session('captcha_code') }}</div>

            <div class="form-group">
                <label>Captcha</label>
                <input type="text" name="captcha" required>
            </div>

            <button type="submit">Masuk</button>

            <div class="forgot-password">
                <a onclick="openForgot()">Lupa password?</a>
            </div>
        </form>

        <div class="login-footer">
            © {{ date('Y') }} WisnuFebri • Quran Journey
        </div>
    </div>

    <!-- MODAL RESET -->
    <div class="modal" id="forgotModal">
        <div class="modal-box">
            <h3>Reset Password</h3>
            <p style="font-size:13px;color:#64748b">Masukkan email</p>

            <input type="email" id="forgotEmail" placeholder="Email">

            <button style="margin-top:12px" onclick="sendReset(this)">
                Kirim Link Reset
            </button>

            <div class="msg" id="forgotMsg"></div>

            <div style="margin-top:10px">
                <a onclick="closeForgot()" style="font-size:13px;color:#64748b;cursor:pointer">
                    Batal
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const toggle = document.querySelector('.toggle-password');
            input.type = input.type === 'password' ? 'text' : 'password';
            toggle.textContent = input.type === 'password' ? 'Show' : 'Hide';
        }

        function openForgot() {
            document.getElementById('forgotModal').style.display = 'flex';
            document.getElementById('forgotMsg').textContent = '';
            document.getElementById('forgotEmail').value = '';
        }

        function closeForgot() {
            document.getElementById('forgotModal').style.display = 'none';
        }

        async function sendReset(btn) {
            const email = document.getElementById('forgotEmail').value.trim();
            const msg = document.getElementById('forgotMsg');
            const token = document.querySelector('meta[name="csrf-token"]').content;

            msg.textContent = '';

            if (!email) {
                msg.style.color = '#dc2626';
                msg.textContent = 'Email wajib diisi';
                return;
            }

            btn.disabled = true;
            btn.textContent = 'Mengirim...';

            try {
                const res = await fetch('/forgot-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email
                    })
                });

                let data = {};
                try {
                    data = await res.json();
                } catch (_) {}

                if (!res.ok) {
                    msg.style.color = '#dc2626';
                    msg.textContent = data.message ?? 'Terjadi kesalahan';
                    return;
                }

                msg.style.color = '#16a34a';
                msg.textContent =
                    data.message ??
                    'Jika email terdaftar, link reset password telah dikirim.';

            } catch (e) {
                msg.style.color = '#dc2626';
                msg.textContent = 'Gagal menghubungi server';
            } finally {
                btn.disabled = false;
                btn.textContent = 'Kirim Link Reset';
            }
        }
    </script>

</body>

</html>