<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * List users (including soft deleted)
     */
    public function index()
    {
        $users = User::withTrashed()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Toggle active / inactive user
     */
    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri');
        }

        if ($user->trashed()) {
            return back()->with('error', 'User sudah dihapus');
        }

        $user->update([
            'is_active' => ! $user->is_active
        ]);

        return back()->with('success', 'Status user diperbarui');
    }

    /**
     * Toggle role admin / user
     */
    public function toggleRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa mengubah role sendiri');
        }

        if ($user->trashed()) {
            return back()->with('error', 'User sudah dihapus');
        }

        $user->update([
            'role' => $user->role === 'admin' ? 'user' : 'admin'
        ]);

        return back()->with('success', 'Role user diperbarui');
    }

    /**
     * Soft delete user
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        if ($user->trashed()) {
            return back()->with('error', 'User sudah dihapus');
        }

        $user->delete(); // soft delete

        return back()->with('success', 'User berhasil dihapus');
    }

    /**
     * Restore soft deleted user
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->restore();

        return back()->with('success', 'User berhasil dipulihkan');
    }
}
