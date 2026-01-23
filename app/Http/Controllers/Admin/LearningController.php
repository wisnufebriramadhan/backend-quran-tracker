<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;

class LearningController extends Controller
{
    // -6.295729, 106.887889
    // Lokasi kantor (FIX)
    private float $officeLat = -6.295729;
    private float $officeLng = 106.887889;
    private int $radius = 100; // meter

    public function index()
    {
        $attendance = Attendance::whereDate('created_at', today())
            ->where('user_id', auth()->id())
            ->first();

        return view('admin.learning.index', compact('attendance'));
    }

    public function attend(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $distance = $this->distance(
            $request->latitude,
            $request->longitude,
            $this->officeLat,
            $this->officeLng
        );

        if ($distance > $this->radius) {
            return back()->withErrors([
                'Lokasi di luar area absensi (jarak: ' . round($distance) . ' meter)'
            ]);
        }

        Attendance::create([
            'user_id' => auth()->id(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'time' => now()->format('H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil');
    }

    /**
     * Hitung jarak (meter) dengan Haversine Formula
     */
    private function distance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371000; // meter

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
