<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // =====================
    // LOGIN
    // =====================
    public function showLogin()
    {
        session(['captcha_code' => strtoupper(Str::random(5))]);
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $key = 'admin-login:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan login'
            ]);
        }

        RateLimiter::hit($key, 60);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required',
        ]);

        if ($request->captcha !== session('captcha_code')) {
            session(['captcha_code' => strtoupper(Str::random(5))]);
            return back()->withErrors(['captcha' => 'Captcha salah']);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors(['email' => 'Email atau password salah']);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // 🔒 Pastikan admin
        // if (! $user || ! $user->isAdmin()) {
        //     Auth::logout();

        //     $request->session()->invalidate();
        //     $request->session()->regenerateToken();

        //     return back()->withErrors([
        //         'email' => 'Anda bukan admin'
        //     ]);
        // }

        RateLimiter::clear($key);
        session()->forget('captcha_code');

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // =====================
    // FORGOT PASSWORD
    // =====================

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Link reset password telah dikirim')
            : back()->withErrors(['email' => 'Email tidak ditemukan']);
    }

    // =====================
    // RESET PASSWORD
    // =====================
    public function showResetPasswordForm(Request $request)
    {
        return view('admin.auth.reset-password', [
            'token' => $request->query('token'),
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil direset')
            : back()->withErrors(['email' => 'Token tidak valid']);
    }
}
