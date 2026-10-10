<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function create(): View
    {
        return view('contact');
    }

    /**
     * Store a newly created contact.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'mobile' => ['required', 'string', 'max:255'],
        ]);

        Contact::create($validated);

        return redirect()
            ->route('contact.create')
            ->with('status', 'Thanks! Your details have been received.');
    }
}
