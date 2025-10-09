<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login'); // not logged in
        }

        $user = Auth::user();

        if ($user->role !== $role) {
            abort(403, 'Unauthorized'); // role mismatch
        }

        return $next($request);
    }
}
