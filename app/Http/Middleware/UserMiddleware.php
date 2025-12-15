<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     * 
     * Ensures only users with 'user' role can access the route.
     * Admins are redirected to admin dashboard.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // If user is admin, redirect to admin dashboard
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('info', 'You are logged in as admin. Please use admin panel.');
        }

        // If user is not 'user' role (edge case)
        if (auth()->user()->role !== 'user') {
            abort(403, 'User access only.');
        }

        return $next($request);
    }
}
