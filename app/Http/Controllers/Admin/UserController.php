<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();

        return view('admin.users.index', compact('users'));
    }

    public function toggleActive(User $user)
    {
        // Jangan nonaktifkan diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri');
        }

        $user->update([
            'is_active' => ! $user->is_active
        ]);

        return back()->with('success', 'Status user diperbarui');
    }

    public function toggleRole(User $user)
    {
        // Jangan turunkan diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa mengubah role sendiri');
        }

        $user->update([
            'role' => $user->role === 'admin' ? 'user' : 'admin'
        ]);

        return back()->with('success', 'Role user diperbarui');
    }
}
