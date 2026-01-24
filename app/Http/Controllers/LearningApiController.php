<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;

class LearningApiController extends Controller
{
    // Lokasi kantor (FIX)
    private float $officeLat = -6.295729;
    private float $officeLng = 106.887889;
    private int $radius = 100; // meter

    /**
     * Get today's attendance status
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $attendance = Attendance::whereDate('created_at', today())
            ->where('user_id', $user->id)
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'has_attended' => $attendance ? true : false,
                'attendance' => $attendance ? [
                    'id' => $attendance->id,
                    'time' => $attendance->time,
                    'latitude' => $attendance->latitude,
                    'longitude' => $attendance->longitude,
                    'created_at' => $attendance->created_at->format('Y-m-d H:i:s'),
                ] : null,
                'office_location' => [
                    'latitude' => $this->officeLat,
                    'longitude' => $this->officeLng,
                    'radius' => $this->radius,
                ],
                'date' => now()->format('Y-m-d'),
                'date_formatted' => now()->locale('id')->isoFormat('dddd, D MMMM YYYY'),
            ]
        ]);
    }

    /**
     * Submit attendance
     */
    public function attend(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = $request->user();

        // Check if already attended today
        $existingAttendance = Attendance::whereDate('created_at', today())
            ->where('user_id', $user->id)
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah absen hari ini',
                'data' => [
                    'attendance' => [
                        'id' => $existingAttendance->id,
                        'time' => $existingAttendance->time,
                        'latitude' => $existingAttendance->latitude,
                        'longitude' => $existingAttendance->longitude,
                    ]
                ]
            ], 422);
        }

        // Calculate distance
        $distance = $this->distance(
            $request->latitude,
            $request->longitude,
            $this->officeLat,
            $this->officeLng
        );

        if ($distance > $this->radius) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi Anda di luar area absensi',
                'data' => [
                    'distance' => round($distance, 2),
                    'max_distance' => $this->radius,
                    'your_location' => [
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                    ],
                    'office_location' => [
                        'latitude' => $this->officeLat,
                        'longitude' => $this->officeLng,
                    ]
                ]
            ], 422);
        }

        // Create attendance
        $attendance = Attendance::create([
            'user_id' => $user->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'time' => now()->format('H:i:s'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil!',
            'data' => [
                'attendance' => [
                    'id' => $attendance->id,
                    'time' => $attendance->time,
                    'latitude' => $attendance->latitude,
                    'longitude' => $attendance->longitude,
                    'distance' => round($distance, 2),
                    'created_at' => $attendance->created_at->format('Y-m-d H:i:s'),
                ]
            ]
        ], 201);
    }

    /**
     * Get attendance history
     */
    public function history(Request $request)
    {
        $user = $request->user();
        
        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(30)
            ->get()
            ->map(function ($attendance) {
                return [
                    'id' => $attendance->id,
                    'date' => $attendance->created_at->format('Y-m-d'),
                    'date_formatted' => $attendance->created_at->locale('id')->isoFormat('dddd, D MMMM YYYY'),
                    'time' => $attendance->time,
                    'latitude' => $attendance->latitude,
                    'longitude' => $attendance->longitude,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'attendances' => $attendances,
                'total' => $attendances->count(),
            ]
        ]);
    }

    /**
     * Check if user is in range
     */
    public function checkLocation(Request $request)
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

        $inRange = $distance <= $this->radius;

        return response()->json([
            'success' => true,
            'data' => [
                'in_range' => $inRange,
                'distance' => round($distance, 2),
                'max_distance' => $this->radius,
                'message' => $inRange 
                    ? 'Anda berada dalam area absensi' 
                    : 'Anda berada di luar area absensi',
            ]
        ]);
    }

    /**
     * Calculate distance using Haversine Formula
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