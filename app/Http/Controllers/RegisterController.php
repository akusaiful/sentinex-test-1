<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create(): View
    {
        return view('register');
    }

    /**
     * Show the registration success page.
     */
    public function success(): View
    {
        return view('register-success');
    }

    /**
     * Show the registration status check form.
     */
    public function status(): View
    {
        return view('register-status');
    }

    /**
     * Look up a registration by email and report its status.
     */
    public function checkStatus(Request $request): View
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        return view('register-status', [
            'email' => $validated['email'],
            'user' => $user,
            'checked' => true,
        ]);
    }

    /**
     * Store a newly registered user pending admin approval.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('register.success')
            ->with('status', 'Your account has been created and is awaiting admin approval.');
    }
}
