<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuranLog;
use Illuminate\Http\Request;

class QuranLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = QuranLog::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.quran_logs.index', compact('logs'));
    }

    public function show(QuranLog $log)
    {
        return view('admin.quran_logs.show', compact('log'));
    }
}
