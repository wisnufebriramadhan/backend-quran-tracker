@extends('admin.layout')

@section('content')

{{-- PAGE TITLE --}}
<div class="section" style="margin-top:0">
    <h3>Dashboard Overview</h3>
    <p style="color:var(--muted);font-size:14px;">
        Ringkasan aktivitas dan status sistem Quran Tracker
    </p>
</div>

{{-- STAT CARDS --}}
<div class="grid">
    <div class="card">
        <span class="badge">Users</span>
        <h2>Total Users</h2>
        <div class="value">{{ $totalUsers }}</div>
    </div>

    <div class="card">
        <span class="badge">Quran Logs</span>
        <h2>Total Quran Logs</h2>
        <div class="value">{{ $totalLogs ?? 0 }}</div>
    </div>

    <div class="card">
        <span class="badge">Active</span>
        <h2>Active Users (7 hari)</h2>
        <div class="value">{{ $activeUsers ?? 0 }}</div>
    </div>

    <div class="card success">
        <span class="badge">System</span>
        <h2>Status Sistem</h2>
        <div class="value">Normal</div>
    </div>
</div>

{{-- QUICK ACTIONS --}}
<div class="section">
    <h3>Quick Actions</h3>

    <div class="card">
        <div class="actions">
            <a href="{{ route('admin.users.index') }}" class="btn">
                👥 User Management
            </a>

            <a href="{{ route('admin.quran.logs') }}" class="btn secondary">
                📖 Quran Logs
            </a>

            <a href="#" class="btn secondary">
                ⚙️ Settings
            </a>
        </div>
    </div>
</div>

{{-- SYSTEM INFO --}}
<div class="section">
    <h3>System Info</h3>

    <div class="grid">
        <div class="card">
            <h2>Server Time (WIB)</h2>
            <div class="value" style="font-size:18px;font-weight:500;">
                {{ now()->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
            </div>
        </div>

        <div class="card">
            <h2>Environment</h2>
            <div class="value" style="font-size:18px;font-weight:500;">
                {{ app()->environment() }}
            </div>
        </div>

        <div class="card">
            <h2>Laravel Version</h2>
            <div class="value" style="font-size:18px;font-weight:500;">
                {{ app()->version() }}
            </div>
        </div>
    </div>
</div>

@endsection