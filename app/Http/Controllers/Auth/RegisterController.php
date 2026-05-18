<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    /** Show registration form */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /** Handle registration form submission */
    public function register(Request $request)
    {
        // Validate input
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'    => ['required', 'string', 'max:15'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create user with customer role by default
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'customer', // default role
        ]);

        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        return redirect()->route('customer.dashboard')
                         ->with('success', 'Welcome to MedPlus! Your account has been created.');
    }
}