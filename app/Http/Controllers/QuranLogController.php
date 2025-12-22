<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class QuranLogController extends Controller
{
    // GET /api/quran/logs
    public function index(Request $request)
    {
        return response()->json(
            $request->user()
                ->quranLogs()
                ->orderBy('date', 'desc')
                ->get()
        );
    }

    // POST /api/quran/logs
    public function store(Request $request)
    {
        $today = Carbon::today()->toDateString();

        // 🔒 VALIDASI: tanggal WAJIB hari ini
        if ($request->date !== $today) {
            return response()->json([
                'message' => 'You can only log Quran reading for today'
            ], 422);
        }

        // 🔒 VALIDASI: cegah double log hari yang sama
        $exists = $request->user()
            ->quranLogs()
            ->where('date', $today)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'You have already logged Quran reading today'
            ], 409);
        }

        // ✅ VALIDASI FIELD
        $data = $request->validate([
            'date' => 'required|date',
            'surah' => 'required|string',
            'ayat_from' => 'required|integer|min:1',
            'ayat_to' => 'required|integer|gte:ayat_from',
            'duration' => 'nullable|integer|min:1',
        ]);

        $log = $request->user()->quranLogs()->create($data);

        return response()->json([
            'message' => 'Quran log saved',
            'data' => $log
        ], 201);
    }


    public function byDate(Request $request)
    {
        $date = $request->query('date');

        $logs = $request->user()
            ->quranLogs()
            ->whereDate('date', $date)
            ->get(['surah', 'ayat_from', 'ayat_to']);

        return response()->json($logs);
    }


    public function streak(Request $request)
    {
        $dates = $request->user()
            ->quranLogs()
            ->select('date')
            ->distinct()
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->map(fn($date) => Carbon::parse($date)); // ⬅️ PENTING

        if ($dates->isEmpty()) {
            return response()->json([
                'streak' => 0,
                'last_read' => null,
            ]);
        }

        $streak = 0;
        $expectedDate = Carbon::today();

        foreach ($dates as $date) {
            if ($date->isSameDay($expectedDate)) {
                $streak++;
                $expectedDate = $expectedDate->subDay();
            } else {
                break;
            }
        }

        return response()->json([
            'streak' => $streak,
            'last_read' => $dates->first()->toDateString(),
        ]);
    }

    public function calendar(Request $request)
    {
        $month = $request->query('month', Carbon::now()->month);
        $year  = $request->query('year', Carbon::now()->year);

        $dates = $request->user()
            ->quranLogs()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->pluck('date')
            ->map(fn($d) => Carbon::parse($d)->toDateString());

        return response()->json([
            'dates' => $dates
        ]);
    }
}
