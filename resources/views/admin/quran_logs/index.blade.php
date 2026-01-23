@extends('admin.layout')

@section('content')

<style>
    /* Modern Table Styles */
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

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
        border-radius: var(--radius-lg);
        padding: 32px;
        color: white;
        margin-bottom: 32px;
        box-shadow: var(--shadow-xl);
        animation: slideDown 0.6s ease;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
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

    .page-header h2 {
        margin: 0 0 8px 0;
        font-size: 32px;
        font-weight: 700;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-header p {
        margin: 0;
        opacity: 0.95;
        font-size: 16px;
        position: relative;
        z-index: 1;
    }

    /* Modern Card */
    .modern-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        animation: fadeIn 0.5s ease;
    }

    /* Table Styles */
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .modern-table thead th {
        padding: 20px;
        text-align: left;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #1f2937;
        border-bottom: 2px solid #e5e7eb;
    }

    .modern-table thead th:first-child {
        padding-left: 24px;
        border-top-left-radius: var(--radius-lg);
    }

    .modern-table thead th:last-child {
        padding-right: 24px;
        border-top-right-radius: var(--radius-lg);
    }

    .modern-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f3f4f6;
    }

    .modern-table tbody tr:hover {
        background: #f9fafb;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .modern-table tbody tr:last-child {
        border-bottom: none;
    }

    .modern-table tbody td {
        padding: 20px;
        font-size: 14px;
        color: #374151;
    }

    .modern-table tbody td:first-child {
        padding-left: 24px;
    }

    .modern-table tbody td:last-child {
        padding-right: 24px;
    }

    /* User Badge */
    .user-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    /* Date Badge */
    .date-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f0fdf4;
        color: #16a34a;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
    }

    /* Surah Badge */
    .surah-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fef3c7;
        color: #d97706;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
    }

    /* Ayat Badge */
    .ayat-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #dbeafe;
        color: #1d4ed8;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
    }

    /* Duration Badge */
    .duration-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fce7f3;
        color: #be185d;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #9ca3af;
    }

    .empty-state-icon {
        font-size: 64px;
        margin-bottom: 16px;
        opacity: 0.5;
        animation: pulse 2s ease-in-out infinite;
    }

    .empty-state-title {
        font-size: 20px;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .empty-state-text {
        font-size: 14px;
        color: #9ca3af;
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 24px;
        display: flex;
        justify-content: center;
    }

    /* Stats Summary */
    .stats-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: var(--radius);
        padding: 20px;
        text-align: center;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        border-color: var(--purple);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-item-icon {
        font-size: 32px;
        margin-bottom: 8px;
    }

    .stat-item-value {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .stat-item-label {
        font-size: 13px;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
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

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
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

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.5;
            transform: scale(0.95);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 24px;
        }

        .page-header h2 {
            font-size: 24px;
        }

        .modern-table {
            font-size: 13px;
        }

        .modern-table thead th,
        .modern-table tbody td {
            padding: 12px;
        }

        .user-badge,
        .date-badge,
        .surah-badge,
        .ayat-badge,
        .duration-badge {
            font-size: 12px;
            padding: 4px 10px;
        }
    }
</style>

{{-- PAGE HEADER --}}
<div class="page-header">
    <h2>
        <span>📖</span>
        @if(Auth::user()->isAdmin())
        Quran Logs - All Users
        @else
        My Quran Reading Logs
        @endif
    </h2>
    <p>
        @if(Auth::user()->isAdmin())
        Monitor dan kelola catatan bacaan Al-Quran dari semua pengguna
        @else
        Catatan bacaan Al-Quran pribadi Anda
        @endif
    </p>
</div>

{{-- STATS SUMMARY --}}
<div class="stats-summary">
    <div class="stat-item">
        <div class="stat-item-icon">📊</div>
        <div class="stat-item-value">{{ number_format($logs->total()) }}</div>
        <div class="stat-item-label">Total Logs</div>
    </div>

    @if(Auth::user()->isAdmin())
    <div class="stat-item">
        <div class="stat-item-icon">👥</div>
        <div class="stat-item-value">{{ number_format($logs->unique('user_id')->count()) }}</div>
        <div class="stat-item-label">Active Users</div>
    </div>
    @endif

    <div class="stat-item">
        <div class="stat-item-icon">📅</div>
        <div class="stat-item-value">{{ number_format($logs->where('date', '>=', now()->subDays(7))->count()) }}</div>
        <div class="stat-item-label">Last 7 Days</div>
    </div>

    <div class="stat-item">
        <div class="stat-item-icon">⏱️</div>
        <div class="stat-item-value">{{ number_format($logs->sum('duration')) }}</div>
        <div class="stat-item-label">Total Minutes</div>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="modern-card">
    <table class="modern-table">
        <thead>
            <tr>
                @if(Auth::user()->isAdmin())
                <th>👤 User</th>
                @endif
                <th>📅 Date</th>
                <th>📖 Surah</th>
                <th>🔢 Ayat</th>
                <th>⏱️ Duration</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
            <tr>
                @if(Auth::user()->isAdmin())
                <td>
                    <span class="user-badge">
                        <span>👤</span>
                        <span>{{ $log->user->email ?? '-' }}</span>
                    </span>
                </td>
                @endif
                <td>
                    <span class="date-badge">
                        <span>📅</span>
                        <span>{{ \Carbon\Carbon::parse($log->date)->format('d M Y') }}</span>
                    </span>
                </td>
                <td>
                    <span class="surah-badge">
                        <span>📖</span>
                        <span>{{ $log->surah }}</span>
                    </span>
                </td>
                <td>
                    <span class="ayat-badge">
                        <span>🔢</span>
                        <span>{{ $log->ayat_from }} - {{ $log->ayat_to }}</span>
                    </span>
                </td>
                <td>
                    <span class="duration-badge">
                        <span>⏱️</span>
                        <span>{{ $log->duration ?? '-' }} min</span>
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->isAdmin() ? '5' : '4' }}">
                    <div class="empty-state">
                        <div class="empty-state-icon">📭</div>
                        <div class="empty-state-title">No Quran Logs Found</div>
                        <div class="empty-state-text">
                            @if(Auth::user()->isAdmin())
                            Belum ada catatan bacaan Al-Quran dari pengguna
                            @else
                            Anda belum memiliki catatan bacaan Al-Quran
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- PAGINATION --}}
<div class="pagination-wrapper">
    {{ $logs->links() }}
</div>

<script>
    // Animate table rows on load
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.modern-table tbody tr');

        rows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateX(-20px)';

            setTimeout(() => {
                row.style.transition = 'all 0.4s ease';
                row.style.opacity = '1';
                row.style.transform = 'translateX(0)';
            }, index * 50);
        });
    });
</script>

@endsection