<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuditLogMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log for authenticated admin users
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Only log state-changing requests (POST, PUT, PATCH, DELETE)
            if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                $this->logAction($request, $response);
            }
        }

        return $response;
    }

    /**
     * Log the action to audit_logs table
     */
    protected function logAction(Request $request, Response $response): void
    {
        try {
            $action = $this->getActionName($request);
            
            // Don't log certain sensitive routes
            if ($this->shouldSkipLogging($request)) {
                return;
            }

            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'payload' => json_encode([
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'route' => $request->route()?->getName(),
                    'status' => $response->getStatusCode(),
                    'input' => $this->sanitizeInput($request->except(['password', '_token', '_method'])),
                ]),
            ]);
        } catch (\Exception $e) {
            // Silently fail - don't break the request
            \Log::error('Audit log failed: ' . $e->getMessage());
        }
    }

    /**
     * Get human-readable action name
     */
    protected function getActionName(Request $request): string
    {
        $route = $request->route()?->getName();
        
        $actions = [
            'admin.orders.verify' => 'Verify Payment',
            'admin.orders.reject' => 'Reject Payment',
            'admin.orders.approve' => 'Approve Custom Design',
            'admin.orders.mark-completed' => 'Mark Order Completed',
            'admin.orders.upload-design' => 'Upload Design File',
            'admin.products.store' => 'Create Product',
            'admin.products.update' => 'Update Product',
            'admin.products.destroy' => 'Delete Product',
            'admin.categories.updateCustomization' => 'Update Category',
        ];

        return $actions[$route] ?? ($request->method() . ' ' . $request->path());
    }

    /**
     * Check if logging should be skipped
     */
    protected function shouldSkipLogging(Request $request): bool
    {
        $skipRoutes = [
            'logout',
            'login',
        ];

        $routeName = $request->route()?->getName();
        return in_array($routeName, $skipRoutes);
    }

    /**
     * Sanitize input data
     */
    protected function sanitizeInput(array $input): array
    {
        // Limit payload size
        $sanitized = [];
        foreach ($input as $key => $value) {
            if (is_string($value) && strlen($value) > 500) {
                $sanitized[$key] = substr($value, 0, 500) . '...';
            } else {
                $sanitized[$key] = $value;
            }
        }
        return $sanitized;
    }
}
