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
            'role'      => 'user',
            'is_active' => true,
        ]);

        // Hapus token lama (jaga-jaga)
        $user->tokens()->delete();

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'user'  => $user,
                'token' => $token,
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

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        if (! $user->is_active) {
            return response()->json([
                'message' => 'Account disabled'
            ], 403);
        }

        // Hapus token lama (1 device aktif)
        $user->tokens()->delete();

        return response()->json([
            'user'  => $user,
            'token' => $user->createToken('mobile')->plainTextToken
        ]);
    }

    // =====================
    // LOGOUT
    // =====================
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Logged out'
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
                'message' => 'Token tidak valid atau sudah kadaluarsa'
            ], 400);
        }

        return response()->json([
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

        if (! Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'message' => 'Password lama salah',
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Optional: logout semua device
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Password berhasil diubah',
        ]);
    }
}
