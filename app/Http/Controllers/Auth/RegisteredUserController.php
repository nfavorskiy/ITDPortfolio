<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255', 
                'min:1',  // Allow single character names
                'unique:'.User::class
            ],
            'email' => [
                'required', 
                'string', 
                'lowercase', 
                'email', 
                'max:255', 
                'unique:'.User::class
            ],
            'password' => [
                'required', 
                'confirmed', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9\s]).{8,}$/'
            ],
        ], [
            // Custom error messages
            'name.unique' => 'This name is already taken. Please choose a different name.',
            'email.unique' => 'This email is already registered. Please use a different email address.',
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must contain at least 8 characters, one uppercase letter, one lowercase letter, one number, and one special character.',

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('verification.notice', absolute: false));
    }
}