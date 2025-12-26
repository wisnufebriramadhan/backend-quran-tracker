<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Wisnu Febri Ramadhan – System & Backend Engineer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Backend & System Engineer. Membangun sistem web, API, admin panel, dan deployment produksi.">

    <style>
        :root {
            --primary: #6366f1;
            --secondary: #22d3ee;
            --accent: #a855f7;
            --bg: #020617;
            --card: #020617;
            --text: #e5e7eb;
            --muted: #9ca3af;
            --border: rgba(255, 255, 255, .08);
        }

        * {
            box-sizing: border-box;
            transition: background-color .3s ease,
                color .3s ease,
                border-color .3s ease,
                transform .3s ease,
                box-shadow .3s ease,
                opacity .3s ease;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: radial-gradient(1200px 600px at top, #1e293b, #020617);
            color: var(--text);
            line-height: 1.7;
        }

        a {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 500;
        }

        /* ================= HEADER ================= */
        header {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(2, 6, 23, .75);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            padding: 18px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header strong {
            font-size: 18px;
            letter-spacing: .5px;
        }

        nav a {
            margin-left: 18px;
            color: var(--text);
            opacity: .85;
            position: relative;
        }

        nav a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -6px;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--secondary), var(--accent));
        }

        nav a:hover {
            opacity: 1;
            color: var(--secondary);
        }

        nav a:hover::after {
            width: 100%;
        }

        /* ================= MAIN ================= */
        main {
            max-width: 1200px;
            margin: auto;
            padding: 90px 24px;
        }

        section {
            margin-bottom: 110px;
        }

        h1 {
            font-size: 52px;
            line-height: 1.15;
            margin-bottom: 18px;
        }

        h2 {
            font-size: 32px;
            margin-bottom: 24px;
        }

        h3 {
            font-size: 18px;
            margin-bottom: 8px;
        }

        p {
            color: var(--muted);
            max-width: 760px;
        }

        /* ================= HERO ================= */
        .hero {
            animation: fadeUp .8s ease-out forwards;
        }

        .hero span {
            display: inline-block;
            background: linear-gradient(90deg, var(--secondary), var(--accent));
            color: #020617;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .hero p {
            font-size: 18px;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ================= GRID & CARD ================= */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
        }

        .card {
            background: linear-gradient(180deg, #020617, #020617) padding-box,
                linear-gradient(135deg, transparent, rgba(99, 102, 241, .4), transparent) border-box;
            border: 1px solid transparent;
            padding: 28px;
            border-radius: 18px;
            position: relative;
            overflow: hidden;
        }

        .card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(400px circle at var(--x, 50%) var(--y, 50%),
                    rgba(99, 102, 241, .14),
                    transparent 40%);
            opacity: 0;
        }

        .card:hover::after {
            opacity: 1;
        }

        .card:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: 0 30px 70px rgba(99, 102, 241, .22);
        }

        /* ================= TAG ================= */
        .tag {
            display: inline-block;
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(99, 102, 241, .15);
            color: var(--secondary);
            margin: 6px 6px 0 0;
        }

        .tag:hover {
            background: linear-gradient(90deg, var(--secondary), var(--accent));
            color: #020617;
            transform: translateY(-2px);
        }

        /* ================= FLOW ================= */
        .flow {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
        }

        .flow div {
            text-align: center;
            padding: 18px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .03);
            border: 1px solid var(--border);
            font-size: 14px;
        }

        .flow div:hover {
            transform: translateY(-4px);
            background: rgba(99, 102, 241, .08);
            border-color: rgba(99, 102, 241, .4);
        }

        footer {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted);
            font-size: 13px;
        }
    </style>
</head>

<body>

    <header>
        <strong>Wisnu Febri Ramadhan</strong>
        <nav>
            <a href="#about">About</a>
            <a href="#projects">Projects</a>
            <a href="#services">Services</a>
            <a href="#contact">Contact</a>
        </nav>
    </header>

    <main>

        <!-- HERO -->
        <section class="hero">
            <span>Backend • System • DevOps</span>
            <h1>Membangun Sistem Digital<br>Siap Produksi & Siap Diskalakan</h1>
            <p>
                Backend & system engineer dengan fokus pada API, admin panel,
                mobile integration, dan deployment production.
            </p>
        </section>

        <!-- ABOUT -->
        <section id="about">
            <h2>Tentang Saya</h2>
            <p>
                Saya membangun sistem dari nol: perencanaan, backend API,
                admin dashboard, integrasi mobile, hingga server production.
                Fokus pada struktur rapi, aman, dan scalable.
            </p>
        </section>

        <!-- PROJECTS -->
        <section id="projects">
            <h2>Selected Projects</h2>

            <div class="grid">

                <div class="card">
                    <h3>Quran Tracker System</h3>
                    <p>Sistem pencatatan ibadah dengan API, admin panel, streak & kalender.</p>
                    <div>
                        <span class="tag">Laravel API</span>
                        <span class="tag">Sanctum</span>
                        <span class="tag">Admin Panel</span>
                        <span class="tag">Mobile Ready</span>
                    </div>
                </div>

                <div class="card">
                    <h3>Digital Identity & e-KYC</h3>
                    <p>Selfie liveness, face verification, KTP scan & API identity.</p>
                    <div>
                        <span class="tag">AI</span>
                        <span class="tag">Face Liveness</span>
                        <span class="tag">API Service</span>
                    </div>
                </div>

                <div class="card">
                    <h3>Admin & User Management</h3>
                    <p>Role, permission, soft delete, monitoring & audit data.</p>
                    <div>
                        <span class="tag">RBAC</span>
                        <span class="tag">Soft Delete</span>
                        <span class="tag">Secure</span>
                    </div>
                </div>

                <div class="card">
                    <h3>Automation & Integration</h3>
                    <p>Workflow backend, cron job, webhook & notifikasi otomatis.</p>
                    <div>
                        <span class="tag">n8n</span>
                        <span class="tag">Cron</span>
                        <span class="tag">Webhook</span>
                    </div>
                </div>

            </div>
        </section>

        <!-- SERVICES -->
        <section id="services">
            <h2>Layanan</h2>

            <div class="grid">
                <div class="card">
                    <h3>Backend API</h3>REST API, Auth, Security
                </div>
                <div class="card">
                    <h3>System Planning</h3>Flow bisnis & arsitektur
                </div>
                <div class="card">
                    <h3>Admin Dashboard</h3>Monitoring & management
                </div>
                <div class="card">
                    <h3>Deployment</h3>VPS, Linux, CI/CD
                </div>
            </div>
        </section>

        <!-- FLOW -->
        <section>
            <h2>Workflow</h2>
            <div class="flow">
                <div>Diskusi</div>
                <div>Perencanaan</div>
                <div>Design API</div>
                <div>Development</div>
                <div>Testing</div>
                <div>Production</div>
            </div>
        </section>

        <!-- CONTACT -->
        <section id="contact">
            <h2>Kontak</h2>
            <p>
                📧 <a href="mailto:wisnufebriramadhan@gmail.com">wisnufebriramadhan@gmail.com</a><br>
                💻 <a href="https://github.com/wisnufebriramadhan" target="_blank">github.com/wisnufebriramadhan</a>
            </p>
        </section>

    </main>

    <footer>
        © {{ date('Y') }} Wisnu Febri Ramadhan • Built with Laravel
    </footer>

</body>

</html>