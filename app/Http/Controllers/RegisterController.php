<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
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
     *
     * Responds with JSON when called via AJAX (Accept: application/json) so the
     * form can update the page without a full reload, and falls back to the
     * server-rendered view for regular requests / no-JavaScript clients.
     */
    public function checkStatus(Request $request): View|JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if ($request->expectsJson()) {
            return response()->json($this->statusPayload($validated['email'], $user));
        }

        return view('register-status', [
            'email' => $validated['email'],
            'user' => $user,
            'checked' => true,
        ]);
    }

    /**
     * Build the JSON payload describing a registration lookup result.
     *
     * @return array<string, mixed>
     */
    private function statusPayload(string $email, ?User $user): array
    {
        if ($user === null) {
            return [
                'found' => false,
                'email' => $email,
            ];
        }

        $status = $user->status;
        $known = in_array($status, ['pending', 'approved', 'rejected'], true);
        $label = ucfirst($status);
        $messages = [
            'pending' => 'Your registration is awaiting review by an administrator.',
            'approved' => 'Your registration has been approved. You can log in now.',
            'rejected' => 'Your registration was reviewed and rejected. Please contact support if you think this is a mistake.',
        ];

        return [
            'found' => true,
            'email' => $email,
            'name' => $user->name,
            'status' => $status,
            'label' => $label,
            'modifier' => $known ? $status : 'pending',
            'message' => $messages[$status] ?? 'Your registration status is: '.$label.'.',
        ];
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
