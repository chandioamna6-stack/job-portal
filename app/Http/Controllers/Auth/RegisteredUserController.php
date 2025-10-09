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
        // ✅ Validate the request including role
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:job_seeker,employer'], // Ensure role is valid
        ]);

        // ✅ Create the user and save role in DB
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Save role to users table
        ]);

        // (Optional) If Spatie roles are used, also assign role
        if (method_exists($user, 'assignRole')) {
            $user->assignRole($request->role);
        }

        // Fire Registered event
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        // ✅ Redirect based on role
        if ($user->role === 'employer') {
            return redirect()->route('employer.dashboard');
        } elseif ($user->role === 'job_seeker') {
            return redirect()->route('jobseeker.dashboard');
        }

        // Fallback (if no role matches)
        return redirect()->route('home');
    }
}
