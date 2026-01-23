@extends('admin.layout')

@section('content')

<style>
    /* Modern Variables */
    :root {
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --bg-card: #ffffff;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --radius: 12px;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: var(--radius);
        padding: 24px;
        color: white;
        margin-bottom: 24px;
        box-shadow: var(--shadow-lg);
        animation: slideDown 0.5s ease;
    }

    .page-header h3 {
        margin: 0 0 8px 0;
        font-size: 28px;
        font-weight: 700;
    }

    .page-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 15px;
    }

    /* Enhanced Card */
    .enhanced-card {
        background: var(--bg-card);
        border-radius: var(--radius);
        padding: 20px;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        margin-bottom: 20px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .enhanced-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Info Cards Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .info-card {
        background: var(--bg-card);
        border-radius: var(--radius);
        padding: 20px;
        text-align: center;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }

    .info-card .icon {
        font-size: 36px;
        margin-bottom: 12px;
        animation: bounce 2s infinite;
    }

    .info-card h4 {
        margin: 0 0 8px 0;
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
    }

    .info-card p {
        margin: 0;
        font-size: 13px;
        color: #6b7280;
    }

    /* Attendance Card */
    .attendance-card {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow-lg);
        border: 2px solid #0ea5e9;
    }

    .attendance-success {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border-color: var(--success);
    }

    .attendance-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .attendance-icon {
        font-size: 48px;
        animation: pulse 2s infinite;
    }

    .attendance-title h3 {
        margin: 0 0 4px 0;
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
    }

    .attendance-title p {
        margin: 0;
        font-size: 14px;
        color: #6b7280;
    }

    /* Attendance Info */
    .attendance-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .info-item {
        background: white;
        padding: 12px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .info-item .label {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 4px;
        font-weight: 500;
    }

    .info-item .value {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }

    /* Attendance Button */
    .btn-attend {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        padding: 16px 24px;
        border-radius: var(--radius);
        font-size: 16px;
        font-weight: 600;
        width: 100%;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-attend:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-attend:active {
        transform: translateY(0);
    }

    .btn-attend.loading {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Map Preview */
    .map-preview {
        width: 100%;
        height: 200px;
        border-radius: 8px;
        background: #e5e7eb;
        margin-top: 16px;
        overflow: hidden;
        position: relative;
    }

    .map-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        background: linear-gradient(135deg, #e0e7ff 0%, #dbeafe 100%);
    }

    /* Stats Section */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 12px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border-radius: var(--radius);
        padding: 16px;
        text-align: center;
        box-shadow: var(--shadow);
        border-left: 4px solid var(--primary);
    }

    .stat-card .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 4px;
    }

    .stat-card .stat-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }

    /* GPS Hint */
    .gps-hint {
        background: #fef3c7;
        border-left: 4px solid var(--warning);
        padding: 12px 16px;
        border-radius: 8px;
        margin-top: 12px;
        font-size: 13px;
        color: #92400e;
        display: flex;
        align-items: center;
        gap: 8px;
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

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 20px;
        }

        .page-header h3 {
            font-size: 24px;
        }
    }
</style>

{{-- PAGE HEADER --}}
<div class="page-header">
    <h3>📚 Learning Center</h3>
    <p>Sistem pembelajaran & absensi berbasis lokasi real-time</p>
</div>

{{-- STATS SECTION --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ date('d') }}</div>
        <div class="stat-label">Hari Ini</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $attendance ? '✓' : '✗' }}</div>
        <div class="stat-label">Status</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">100%</div>
        <div class="stat-label">Akurasi GPS</div>
    </div>
</div>

{{-- INFO CARDS GRID --}}
<div class="info-grid">
    <div class="info-card" onclick="window.open('https://docs.example.com', '_blank')">
        <div class="icon">📘</div>
        <h4>API Documentation</h4>
        <p>Panduan lengkap API</p>
    </div>

    <div class="info-card" onclick="alert('Testing Guide - Coming Soon!')">
        <div class="icon">🧪</div>
        <h4>Testing Guide</h4>
        <p>Cara testing sistem</p>
    </div>

    <div class="info-card" onclick="alert('Best Practices - Coming Soon!')">
        <div class="icon">🧠</div>
        <h4>Best Practice</h4>
        <p>Tips & trik terbaik</p>
    </div>
</div>

{{-- ATTENDANCE SECTION --}}
<div class="attendance-card {{ $attendance ? 'attendance-success' : '' }}">
    <div class="attendance-header">
        <div class="attendance-icon">
            {{ $attendance ? '✅' : '🕘' }}
        </div>
        <div class="attendance-title">
            <h3>{{ $attendance ? 'Absensi Berhasil!' : 'Absensi Hari Ini' }}</h3>
            <p>{{ date('l, d F Y') }}</p>
        </div>
    </div>

    @if ($attendance)
    <div class="attendance-info">
        <div class="info-item">
            <div class="label">⏰ Waktu Absen</div>
            <div class="value">{{ $attendance->time }}</div>
        </div>
        <div class="info-item">
            <div class="label">📍 Latitude</div>
            <div class="value">{{ number_format($attendance->latitude, 6) }}</div>
        </div>
        <div class="info-item">
            <div class="label">📍 Longitude</div>
            <div class="value">{{ number_format($attendance->longitude, 6) }}</div>
        </div>
        <div class="info-item">
            <div class="label">🎯 Status</div>
            <div class="value" style="color: var(--success);">Hadir</div>
        </div>
    </div>

    {{-- MAP PREVIEW --}}
    <div class="map-preview">
        <div class="map-placeholder">🗺️</div>
    </div>

    <div class="gps-hint">
        <span>💡</span>
        <span>Lokasi absensi telah tersimpan dengan aman</span>
    </div>
    @else
    <form id="attendanceForm" method="POST" action="{{ route('admin.learning.attend') }}">
        @csrf
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        <button
            type="submit"
            onclick="return getLocationEnhanced(event)"
            class="btn-attend"
            id="attendBtn">
            <span id="btnText">📍 Absen Sekarang</span>
            <span id="btnLoader" style="display:none;" class="loading-spinner"></span>
        </button>
    </form>

    <div class="gps-hint">
        <span>⚠️</span>
        <span>Pastikan GPS aktif dan izinkan akses lokasi pada browser</span>
    </div>
    @endif
</div>

{{-- ENHANCED GPS SCRIPT --}}
<script>
    function getLocationEnhanced(event) {
        // Prevent form submission
        event.preventDefault();

        const btn = document.getElementById('attendBtn');
        const btnText = document.getElementById('btnText');
        const btnLoader = document.getElementById('btnLoader');
        const form = document.getElementById('attendanceForm');

        if (!navigator.geolocation) {
            alert("Browser Anda tidak mendukung GPS");
            return false;
        }

        // Show loading state
        btn.classList.add('loading');
        btn.disabled = true;
        btnText.style.display = 'none';
        btnLoader.style.display = 'inline-block';

        const options = {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        };

        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const accuracy = position.coords.accuracy;

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                console.log('📍 Lokasi berhasil didapat:', {
                    lat,
                    lng,
                    accuracy
                });

                // Submit form
                form.submit();
            },
            function(error) {
                // Reset button
                btn.classList.remove('loading');
                btn.disabled = false;
                btnText.style.display = 'inline';
                btnLoader.style.display = 'none';

                let errorMsg = 'Gagal mengambil lokasi. ';

                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        errorMsg += 'Izin lokasi ditolak. Silakan izinkan akses lokasi.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMsg += 'Informasi lokasi tidak tersedia.';
                        break;
                    case error.TIMEOUT:
                        errorMsg += 'Waktu tunggu habis. Coba lagi.';
                        break;
                    default:
                        errorMsg += 'Terjadi kesalahan tidak dikenal.';
                }

                alert(errorMsg);
            },
            options
        );

        return false;
    }
</script>

@endsection