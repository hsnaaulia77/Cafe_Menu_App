<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission, string $action = 'read'): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        // Admin bypass all permissions
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Check if user has permission
        if (!$user->hasPermission($permission, $action)) {
            abort(403, 'Insufficient permissions.');
        }

        return $next($request);
    }
}
