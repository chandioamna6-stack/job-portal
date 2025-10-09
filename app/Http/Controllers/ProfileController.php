<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Fill basic fields from validated data
        $validated = $request->validated();
        if (!empty($validated)) {
            $user->fill($validated);
        }

        // Save optional fields individually
        foreach (['phone', 'address', 'country', 'bank_name', 'account_number'] as $field) {
            if ($request->has($field)) {
                $user->$field = $request->input($field);
            }
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // Reset email verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Redirect to dashboard based on role
        $role = $user->role; // assuming you have a 'role' field: admin, employer, jobseeker
       $dashboardRoute = match($role) {
    'admin' => 'admin.dashboard',
    'employer' => 'employer.dashboard',
    'job_seeker' => 'jobseeker.dashboard',
    default => 'home',
};
return Redirect::route($dashboardRoute)->with('status', 'profile-updated');

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
