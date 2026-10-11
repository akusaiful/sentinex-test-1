<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * List the users awaiting admin approval.
     */
    public function index(): View
    {
        $pendingUsers = User::where('status', 'pending')
            ->orderBy('created_at')
            ->get();

        return view('admin.users', [
            'pendingUsers' => $pendingUsers,
        ]);
    }

    /**
     * Approve a pending user.
     */
    public function approve(User $user): RedirectResponse
    {
        $user->update(['status' => 'approved']);

        return redirect()
            ->route('admin.users')
            ->with('status', $user->name.' has been approved.');
    }

    /**
     * Reject a pending user.
     */
    public function reject(User $user): RedirectResponse
    {
        $user->update(['status' => 'rejected']);

        return redirect()
            ->route('admin.users')
            ->with('status', $user->name.' has been rejected.');
    }
}
