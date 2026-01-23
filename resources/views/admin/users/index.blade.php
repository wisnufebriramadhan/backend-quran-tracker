@extends('admin.layout')

@section('content')

<style>
    /* Modern User Management Styles */
    :root {
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --purple: #a855f7;
        --bg-card: #ffffff;
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --radius: 12px;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: var(--radius);
        padding: 28px 32px;
        color: white;
        margin-bottom: 24px;
        box-shadow: var(--shadow-lg);
        animation: slideDown 0.5s ease;
    }

    .page-header h3 {
        margin: 0 0 8px 0;
        font-size: 28px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header p {
        margin: 0;
        opacity: 0.95;
        font-size: 15px;
    }

    /* Stats Bar */
    .stats-bar {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-item {
        background: white;
        border-radius: var(--radius);
        padding: 20px;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.3s ease;
        border-left: 4px solid var(--primary);
    }

    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-item:nth-child(1) {
        border-left-color: var(--info);
    }

    .stat-item:nth-child(2) {
        border-left-color: var(--success);
    }

    .stat-item:nth-child(3) {
        border-left-color: var(--warning);
    }

    .stat-item:nth-child(4) {
        border-left-color: var(--danger);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        background: rgba(99, 102, 241, 0.1);
    }

    .stat-item:nth-child(1) .stat-icon {
        background: rgba(59, 130, 246, 0.1);
    }

    .stat-item:nth-child(2) .stat-icon {
        background: rgba(16, 185, 129, 0.1);
    }

    .stat-item:nth-child(3) .stat-icon {
        background: rgba(245, 158, 11, 0.1);
    }

    .stat-item:nth-child(4) .stat-icon {
        background: rgba(239, 68, 68, 0.1);
    }

    .stat-content h4 {
        margin: 0 0 4px 0;
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }

    .stat-content p {
        margin: 0;
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }

    /* Enhanced Alerts */
    .alert {
        padding: 16px 20px;
        border-radius: var(--radius);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        font-weight: 500;
        animation: slideDown 0.4s ease;
        box-shadow: var(--shadow);
    }

    .alert.success {
        background: #d1fae5;
        color: #065f46;
        border-left: 4px solid var(--success);
    }

    .alert.error {
        background: #fee2e2;
        color: #991b1b;
        border-left: 4px solid var(--danger);
    }

    .alert::before {
        font-size: 20px;
    }

    .alert.success::before {
        content: '✅';
    }

    .alert.error::before {
        content: '❌';
    }

    /* Search & Filter Bar */
    .filter-bar {
        background: white;
        border-radius: var(--radius);
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: var(--shadow);
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-box {
        flex: 1;
        min-width: 250px;
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .search-box::before {
        content: '🔍';
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 16px;
    }

    .filter-select {
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary);
    }

    /* Enhanced Table */
    .table-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .enhanced-table {
        width: 100%;
        border-collapse: collapse;
    }

    .enhanced-table thead {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    }

    .enhanced-table thead th {
        padding: 16px;
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e5e7eb;
    }

    .enhanced-table tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.2s ease;
    }

    .enhanced-table tbody tr:hover {
        background: #f9fafb;
    }

    .enhanced-table tbody td {
        padding: 16px;
        font-size: 14px;
        color: #1f2937;
    }

    /* User Info Cell */
    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
    }

    .user-details h4 {
        margin: 0 0 2px 0;
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
    }

    .user-details p {
        margin: 0;
        font-size: 13px;
        color: #6b7280;
    }

    /* Enhanced Badges */
    .role-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .role-badge.admin {
        background: rgba(168, 85, 247, 0.1);
        color: #a855f7;
        border: 1px solid rgba(168, 85, 247, 0.2);
    }

    .role-badge.user {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    /* Enhanced Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        animation: pulse 2s ease-in-out infinite;
    }

    .status-badge.active {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-badge.active::before {
        background: #10b981;
    }

    .status-badge.inactive {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .status-badge.inactive::before {
        background: #f59e0b;
    }

    .status-badge.deleted {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .status-badge.deleted::before {
        background: #ef4444;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .action-btn.primary {
        background: var(--primary);
        color: white;
    }

    .action-btn.primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .action-btn.secondary {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #e5e7eb;
    }

    .action-btn.secondary:hover {
        background: #e5e7eb;
    }

    .action-btn.danger {
        background: var(--danger);
        color: white;
    }

    .action-btn.danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    .action-btn.success {
        background: var(--success);
        color: white;
    }

    .action-btn.success:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-top: 1px solid #f3f4f6;
    }

    /* Animations */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 20px;
        }

        .stats-bar {
            grid-template-columns: 1fr;
        }

        .filter-bar {
            flex-direction: column;
        }

        .search-box {
            width: 100%;
        }

        .enhanced-table {
            font-size: 13px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

{{-- PAGE HEADER --}}
<div class="page-header">
    <h3>👥 User Management</h3>
    <p>Kelola akun pengguna, role, status aktif, dan data yang dihapus dengan mudah</p>
</div>

{{-- STATS BAR --}}
<div class="stats-bar">
    <div class="stat-item">
        <div class="stat-icon">👥</div>
        <div class="stat-content">
            <h4>{{ $users->total() }}</h4>
            <p>Total Users</p>
        </div>
    </div>

    <div class="stat-item">
        <div class="stat-icon">✅</div>
        <div class="stat-content">
            <h4>{{ $users->where('is_active', true)->where('deleted_at', null)->count() }}</h4>
            <p>Active Users</p>
        </div>
    </div>

    <div class="stat-item">
        <div class="stat-icon">⏸️</div>
        <div class="stat-content">
            <h4>{{ $users->where('is_active', false)->where('deleted_at', null)->count() }}</h4>
            <p>Inactive Users</p>
        </div>
    </div>

    <div class="stat-item">
        <div class="stat-icon">🗑️</div>
        <div class="stat-content">
            <h4>{{ $users->whereNotNull('deleted_at')->count() }}</h4>
            <p>Deleted Users</p>
        </div>
    </div>
</div>

{{-- ALERTS --}}
@if (session('success'))
<div class="alert success">
    <span>{{ session('success') }}</span>
</div>
@endif

@if (session('error'))
<div class="alert error">
    <span>{{ session('error') }}</span>
</div>
@endif

{{-- SEARCH & FILTER BAR --}}
<div class="filter-bar">
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Cari nama atau email..." onkeyup="filterTable()">
    </div>

    <select class="filter-select" id="roleFilter" onchange="filterTable()">
        <option value="">Semua Role</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
    </select>

    <select class="filter-select" id="statusFilter" onchange="filterTable()">
        <option value="">Semua Status</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
        <option value="deleted">Deleted</option>
    </select>
</div>

{{-- ENHANCED TABLE --}}
<div class="table-card">
    <table class="enhanced-table" id="userTable">
        <thead>
            <tr>
                <th style="width:280px">User</th>
                <th style="width:140px">Role</th>
                <th style="width:140px">Status</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
            <tr>
                {{-- USER INFO --}}
                <td>
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="user-details">
                            <h4>{{ $user->name }}</h4>
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>
                </td>

                {{-- ROLE --}}
                <td>
                    <span class="role-badge {{ $user->role === 'admin' ? 'admin' : 'user' }}">
                        {{ $user->role === 'admin' ? '👑 Admin' : '👤 User' }}
                    </span>
                </td>

                {{-- STATUS --}}
                <td>
                    @if ($user->deleted_at)
                    <span class="status-badge deleted">Deleted</span>
                    @elseif ($user->is_active)
                    <span class="status-badge active">Active</span>
                    @else
                    <span class="status-badge inactive">Inactive</span>
                    @endif
                </td>

                {{-- ACTIONS --}}
                <td>
                    <div class="action-buttons">
                        @if (!$user->deleted_at)
                        {{-- ENABLE / DISABLE --}}
                        <form method="POST" action="{{ route('admin.users.toggleActive', $user) }}" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button class="action-btn {{ $user->is_active ? 'secondary' : 'success' }}"
                                onclick="return confirm('Yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} user ini?')">
                                {{ $user->is_active ? '⏸️ Disable' : '▶️ Enable' }}
                            </button>
                        </form>

                        {{-- TOGGLE ROLE --}}
                        <form method="POST" action="{{ route('admin.users.toggleRole', $user) }}" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button class="action-btn primary"
                                onclick="return confirm('Yakin ingin mengubah role user ini?')">
                                {{ $user->role === 'admin' ? '👤 Jadikan User' : '👑 Jadikan Admin' }}
                            </button>
                        </form>

                        {{-- DELETE --}}
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                            onsubmit="return confirm('⚠️ Yakin ingin menghapus user ini?\n\nData user akan di-soft delete dan bisa di-restore kembali.')"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="action-btn danger">
                                🗑️ Delete
                            </button>
                        </form>
                        @else
                        {{-- RESTORE --}}
                        <form method="POST" action="{{ route('admin.users.restore', $user->id) }}" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button class="action-btn success"
                                onclick="return confirm('Yakin ingin restore user ini?')">
                                ♻️ Restore
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- PAGINATION --}}
    <div class="pagination-wrapper">
        {{ $users->links() }}
    </div>
</div>

{{-- FILTER SCRIPT --}}
<script>
    function filterTable() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase();
        const roleFilter = document.getElementById('roleFilter').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();

        const table = document.getElementById('userTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (let row of rows) {
            const userInfo = row.cells[0].textContent.toLowerCase();
            const role = row.cells[1].textContent.toLowerCase();
            const status = row.cells[2].textContent.toLowerCase();

            const matchesSearch = userInfo.includes(searchValue);
            const matchesRole = roleFilter === '' || role.includes(roleFilter);
            const matchesStatus = statusFilter === '' || status.includes(statusFilter);

            if (matchesSearch && matchesRole && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }

    // Animate rows on load
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.enhanced-table tbody tr');
        rows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateX(-10px)';

            setTimeout(() => {
                row.style.transition = 'all 0.3s ease';
                row.style.opacity = '1';
                row.style.transform = 'translateX(0)';
            }, index * 50);
        });
    });
</script>

@endsection