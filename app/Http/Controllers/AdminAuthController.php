<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function create(): View
    {
        return view('admin.login');
    }

    /**
     * Attempt to authenticate an administrator.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => __('These credentials do not match our records.'),
            ]);
        }

        if (! Auth::user()->is_admin || Auth::user()->status !== 'approved') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => __('You do not have access to the admin area.'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('admin.approvals');
    }

    /**
     * Show the admin approval page listing users awaiting review.
     */
    public function approvals(): View
    {
        return view('admin.approvals', [
            'pending' => User::where('status', 'pending')->latest()->get(),
        ]);
    }

    /**
     * Log the administrator out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
