<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuranLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuranLogController extends Controller
{
    public function index(Request $request)
    {
        $query = QuranLog::with('user')->latest();

        // Jika user bukan admin, hanya tampilkan log milik user tersebut
        if (!Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        $logs = $query->paginate(15);

        return view('admin.quran_logs.index', compact('logs'));
    }

    public function show(QuranLog $log)
    {
        // Pastikan user hanya bisa melihat detail log milik mereka sendiri
        // kecuali dia adalah admin
        if (!Auth::user()->isAdmin() && $log->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.quran_logs.show', compact('log'));
    }
}
