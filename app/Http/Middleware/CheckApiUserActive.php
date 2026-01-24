<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiUserActive
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user) {
            // ❌ User di-disable
            if (!$user->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda telah dinonaktifkan oleh administrator. Silakan hubungi admin.',
                ], 403);
            }

            // ❌ User di-soft delete
            if ($user->trashed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda telah dihapus.',
                ], 403);
            }
        }

        return $next($request);
    }
}