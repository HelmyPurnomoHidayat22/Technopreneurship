<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access. Admin only.');
        }

        // IP Whitelist (optional, for production)
        if (config('app.admin_ip_whitelist_enabled', false)) {
            $allowedIps = explode(',', config('app.admin_allowed_ips', ''));
            $clientIp = $request->ip();

            if (!empty($allowedIps) && !in_array($clientIp, $allowedIps)) {
                \Log::warning('Admin access denied from IP: ' . $clientIp);
                abort(403, 'Access denied from your IP address.');
            }
        }

        return $next($request);
    }
}
