<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AccountApprovedFirstTime;
use App\Notifications\AccountReactivated;

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
            return back()->with('error', 'Tidak bisa mengubah status akun sendiri');
        }

        if ($user->trashed()) {
            return back()->with('error', 'User sudah dihapus');
        }

        $wasInactive = ! $user->is_active;
        $firstApproval = is_null($user->approved_at);

        $user->is_active = ! $user->is_active;

        // Jika sedang diaktifkan
        if ($wasInactive && $user->is_active) {

            // APPROVE PERTAMA
            if ($firstApproval) {
                $user->approved_at = now();
                $user->approved_by = auth()->id();
                $user->notify(new AccountApprovedFirstTime());
            }
            // RE-ACTIVATE
            else {
                $user->notify(new AccountReactivated());
            }
        }

        $user->save();

        return back()->with('success', 'Status user berhasil diperbarui');
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
