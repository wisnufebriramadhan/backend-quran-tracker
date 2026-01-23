<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\QuranLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Data yang ditampilkan sesuai role
        if (Auth::user()->isAdmin()) {
            // Admin melihat semua data
            $totalUsers = User::count();
            $totalLogs = QuranLog::count();
            $activeUsers = User::where('is_active', true)
                ->whereHas('quranLogs', function ($query) {
                    $query->where('date', '>=', now()->subDays(7));
                })
                ->count();
        } else {
            // User biasa hanya melihat data mereka sendiri
            $totalUsers = null; // Tidak perlu ditampilkan
            $totalLogs = QuranLog::where('user_id', Auth::id())->count();
            $activeUsers = null; // Tidak perlu ditampilkan
        }

        return view('admin.dashboard', compact('totalUsers', 'totalLogs', 'activeUsers'));
    }
}
