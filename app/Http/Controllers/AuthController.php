<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // =====================
    // REGISTER
    // =====================
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            // 'role' dan 'is_active' otomatis dari $attributes di model
        ]);

        // ❌ JANGAN buat token untuk user inactive
        // Hapus token lama (jaga-jaga)
        // $user->tokens()->delete();
        // $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil! Tunggu aktivasi dari admin.',
            'data' => [
                'user'  => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'is_active' => $user->is_active, // ✅ Tambahkan ini
                ],
                // ❌ JANGAN kirim token, karena user belum aktif
                // 'token' => $token,
            ]
        ], 201);
    }

    // =====================
    // LOGIN
    // =====================
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // ✅ Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // ❌ User tidak ditemukan
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak terdaftar.'
            ], 401);
        }

        // ❌ User sudah dihapus (soft delete)
        if ($user->trashed()) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda telah dihapus. Silakan hubungi administrator.'
            ], 403);
        }

        // ❌ User di-disable oleh admin
        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda sedang dalam proses peninjauan oleh administrator. Setelah disetujui, pemberitahuan akan dikirimkan melalui email yang terdaftar.'
            ], 403);
        }

        // ❌ Password salah
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.'
            ], 401);
        }

        // ✅ Hapus token lama (1 device aktif)
        $user->tokens()->delete();

        // ✅ Generate token baru
        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                'token' => $token,
            ]
        ], 200);
    }

    // =====================
    // LOGOUT
    // =====================
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    // =====================
    // 🔑 FORGOT PASSWORD
    // =====================
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        Password::sendResetLink($request->only('email'));

        // Jangan bocorin email valid / tidak
        return response()->json([
            'success' => true,
            'message' => 'Jika email terdaftar, link reset akan dikirim.',
        ]);
    }

    // =====================
    // 🔁 RESET PASSWORD
    // =====================
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email',
            'token'                 => 'required|string',
            'password'              => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            [
                'email' => $request->email,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
                'token' => $request->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                // Optional: revoke semua token login
                $user->tokens()->delete();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid atau sudah kadaluarsa'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil direset'
        ]);
    }


    // =====================
    // 🔒 CHANGE PASSWORD (LOGIN REQUIRED)
    // =====================
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password'     => 'required|min:6|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama salah',
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Optional: logout semua device
        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah',
        ]);
    }
}
