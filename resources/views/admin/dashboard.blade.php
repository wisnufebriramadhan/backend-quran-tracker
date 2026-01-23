@extends('admin.layout')

@section('content')

<style>
    /* Modern Dashboard Styles */
    :root {
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --purple: #a855f7;
        --bg-card: #ffffff;
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --radius: 12px;
        --radius-lg: 16px;
    }

    /* Dashboard Header */
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: var(--radius-lg);
        padding: 32px;
        color: white;
        margin-bottom: 32px;
        box-shadow: var(--shadow-xl);
        animation: slideDown 0.6s ease;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .dashboard-header h3 {
        margin: 0 0 8px 0;
        font-size: 32px;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    .dashboard-header p {
        margin: 0;
        opacity: 0.95;
        font-size: 16px;
        position: relative;
        z-index: 1;
    }

    .dashboard-time {
        position: absolute;
        top: 32px;
        right: 32px;
        text-align: right;
        z-index: 1;
    }

    .dashboard-time .time {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .dashboard-time .date {
        font-size: 14px;
        opacity: 0.9;
    }

    /* Enhanced Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: var(--bg-card);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 2px solid transparent;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary);
        transition: width 0.3s ease;
    }

    .stat-card:hover::before {
        width: 8px;
    }

    .stat-card.users::before {
        background: var(--info);
    }

    .stat-card.logs::before {
        background: var(--purple);
    }

    .stat-card.active::before {
        background: var(--warning);
    }

    .stat-card.system::before {
        background: var(--success);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        background: rgba(99, 102, 241, 0.1);
        animation: pulse 2s ease-in-out infinite;
    }

    .stat-card.users .stat-icon {
        background: rgba(59, 130, 246, 0.1);
    }

    .stat-card.logs .stat-icon {
        background: rgba(168, 85, 247, 0.1);
    }

    .stat-card.active .stat-icon {
        background: rgba(245, 158, 11, 0.1);
    }

    .stat-card.system .stat-icon {
        background: rgba(16, 185, 129, 0.1);
    }

    .stat-badge {
        background: rgba(99, 102, 241, 0.1);
        color: var(--primary);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .stat-card.users .stat-badge {
        background: rgba(59, 130, 246, 0.1);
        color: var(--info);
    }

    .stat-card.logs .stat-badge {
        background: rgba(168, 85, 247, 0.1);
        color: var(--purple);
    }

    .stat-card.active .stat-badge {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }

    .stat-card.system .stat-badge {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .stat-title {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 36px;
        font-weight: 700;
        color: #1f2937;
        line-height: 1;
    }

    .stat-trend {
        margin-top: 12px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .stat-trend.up {
        color: var(--success);
    }

    .stat-trend.down {
        color: var(--danger);
    }

    /* Quick Actions Section */
    .quick-actions {
        margin-bottom: 32px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .action-card {
        background: var(--bg-card);
        border-radius: var(--radius);
        padding: 20px;
        text-decoration: none;
        color: inherit;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 16px;
        border: 2px solid transparent;
    }

    .action-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }

    .action-icon {
        width: 56px;
        height: 56px;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        flex-shrink: 0;
    }

    .action-card:nth-child(1) .action-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .action-card:nth-child(2) .action-icon {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .action-card:nth-child(3) .action-icon {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .action-card:nth-child(4) .action-icon {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .action-card:nth-child(5) .action-icon {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .action-card:nth-child(6) .action-icon {
        background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
    }

    .action-content h4 {
        margin: 0 0 4px 0;
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
    }

    .action-content p {
        margin: 0;
        font-size: 13px;
        color: #6b7280;
    }

    /* System Info Cards */
    .system-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
    }

    .info-card {
        background: var(--bg-card);
        border-radius: var(--radius);
        padding: 20px;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
    }

    .info-card:hover {
        box-shadow: var(--shadow-md);
    }

    .info-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .info-value {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
    }

    /* Recent Activity (Optional Enhancement) */
    .activity-card {
        background: var(--bg-card);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow-md);
        margin-bottom: 32px;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        border-radius: 8px;
        transition: background 0.2s ease;
    }

    .activity-item:hover {
        background: #f9fafb;
    }

    .activity-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--primary);
        animation: blink 2s ease-in-out infinite;
    }

    /* Animations */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.05);
            opacity: 0.8;
        }
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0) rotate(0deg);
        }

        50% {
            transform: translateY(-20px) rotate(10deg);
        }
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.3;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 24px;
        }

        .dashboard-header h3 {
            font-size: 24px;
        }

        .dashboard-time {
            position: static;
            margin-top: 16px;
            text-align: left;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-value {
            font-size: 28px;
        }
    }
</style>

{{-- DASHBOARD HEADER --}}
<div class="dashboard-header">
    <div class="dashboard-time">
        <div class="time" id="currentTime">--:--</div>
        <div class="date">{{ now()->timezone('Asia/Jakarta')->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</div>
    </div>
    <h3>📊 Dashboard Overview</h3>
    <p>Selamat datang kembali! Berikut ringkasan aktivitas dan status sistem Quran Tracker</p>
</div>

{{-- ENHANCED STAT CARDS --}}
<div class="stats-grid">
    <div class="stat-card users">
        <div class="stat-header">
            <div class="stat-icon">👥</div>
            <span class="stat-badge">Users</span>
        </div>
        <div class="stat-title">Total Pengguna</div>
        <div class="stat-value">{{ number_format($totalUsers) }}</div>
        <div class="stat-trend up">
            <span>↗</span>
            <span>Aktif terdaftar</span>
        </div>
    </div>

    <div class="stat-card logs">
        <div class="stat-header">
            <div class="stat-icon">📖</div>
            <span class="stat-badge">Logs</span>
        </div>
        <div class="stat-title">Total Quran Logs</div>
        <div class="stat-value">{{ number_format($totalLogs ?? 0) }}</div>
        <div class="stat-trend up">
            <span>↗</span>
            <span>Bacaan tercatat</span>
        </div>
    </div>

    <div class="stat-card active">
        <div class="stat-header">
            <div class="stat-icon">⚡</div>
            <span class="stat-badge">Active</span>
        </div>
        <div class="stat-title">Pengguna Aktif</div>
        <div class="stat-value">{{ number_format($activeUsers ?? 0) }}</div>
        <div class="stat-trend">
            <span>📅</span>
            <span>7 hari terakhir</span>
        </div>
    </div>

    <div class="stat-card system">
        <div class="stat-header">
            <div class="stat-icon">✅</div>
            <span class="stat-badge">System</span>
        </div>
        <div class="stat-title">Status Sistem</div>
        <div class="stat-value" style="font-size: 24px; color: var(--success);">Normal</div>
        <div class="stat-trend up">
            <span>●</span>
            <span>Berjalan lancar</span>
        </div>
    </div>
</div>

{{-- QUICK ACTIONS --}}
<div class="quick-actions">
    <h3 class="section-title">⚡ Quick Actions</h3>

    <div class="actions-grid">
        <a href="{{ route('admin.users.index') }}" class="action-card">
            <div class="action-icon">👥</div>
            <div class="action-content">
                <h4>User Management</h4>
                <p>Kelola data pengguna</p>
            </div>
        </a>

        <a href="{{ route('admin.quran.logs') }}" class="action-card">
            <div class="action-icon">📖</div>
            <div class="action-content">
                <h4>Quran Logs</h4>
                <p>Lihat catatan bacaan</p>
            </div>
        </a>

        <a href="#" class="action-card" onclick="alert('Settings page coming soon!'); return false;">
            <div class="action-icon">⚙️</div>
            <div class="action-content">
                <h4>Settings</h4>
                <p>Pengaturan sistem</p>
            </div>
        </a>

        <a href="#" class="action-card" onclick="alert('Analytics coming soon!'); return false;">
            <div class="action-icon">📊</div>
            <div class="action-content">
                <h4>Analytics</h4>
                <p>Statistik & laporan</p>
            </div>
        </a>

        <a href="#" class="action-card" onclick="alert('Notifications coming soon!'); return false;">
            <div class="action-icon">🔔</div>
            <div class="action-content">
                <h4>Notifications</h4>
                <p>Kelola notifikasi</p>
            </div>
        </a>
    </div>
</div>

{{-- SYSTEM INFO --}}
<div>
    <h3 class="section-title">🖥️ System Information</h3>

    <div class="system-info-grid">
        <div class="info-card">
            <div class="info-label">
                <span>🕐</span>
                <span>Server Time (WIB)</span>
            </div>
            <div class="info-value">
                {{ now()->timezone('Asia/Jakarta')->format('H:i:s') }}
            </div>
        </div>

        <div class="info-card">
            <div class="info-label">
                <span>🌍</span>
                <span>Environment</span>
            </div>
            <div class="info-value" style="text-transform: uppercase;">
                {{ app()->environment() }}
            </div>
        </div>

        <div class="info-card">
            <div class="info-label">
                <span>🌐</span>
                <span>Timezone</span>
            </div>
            <div class="info-value">
                Asia/Jakarta
            </div>
        </div>

        <div class="info-card">
            <div class="info-label">
                <span>🔒</span>
                <span>Security Status</span>
            </div>
            <div class="info-value" style="color: var(--success);">
                Protected
            </div>
        </div>
    </div>
</div>

{{-- REAL-TIME CLOCK SCRIPT --}}
<script>
    // Update clock every second
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            timeElement.textContent = `${hours}:${minutes}:${seconds}`;
        }
    }

    // Update immediately and then every second
    updateClock();
    setInterval(updateClock, 1000);

    // Animate stat values on load
    document.addEventListener('DOMContentLoaded', function() {
        const statValues = document.querySelectorAll('.stat-value');

        statValues.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(10px)';

            setTimeout(() => {
                element.style.transition = 'all 0.5s ease';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>

@endsection