<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Symfony\Component\HttpFoundation\Response;

class AuditLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $action = null, string $severity = 'info'): Response
    {
        $response = $next($request);

        // Log sensitive operations
        if ($this->shouldLog($request, $action)) {
            $this->logAction($request, $action, $severity);
        }

        return $response;
    }

    private function shouldLog(Request $request, ?string $action): bool
    {
        // Log all POST, PUT, PATCH, DELETE requests
        $sensitiveMethods = ['POST', 'PUT', 'PATCH', 'DELETE'];
        
        if (in_array($request->method(), $sensitiveMethods)) {
            return true;
        }

        // Log specific actions
        if ($action) {
            return true;
        }

        // Log authentication attempts
        if ($request->is('login') || $request->is('logout')) {
            return true;
        }

        return false;
    }

    private function logAction(Request $request, ?string $action, string $severity): void
    {
        $user = auth()->user();
        
        // Determine action if not provided
        if (!$action) {
            $action = $this->determineAction($request);
        }

        // Get model information if available
        $modelInfo = $this->getModelInfo($request);

        AuditLog::create([
            'user_id' => $user?->id,
            'action' => $action,
            'model_type' => $modelInfo['type'] ?? null,
            'model_id' => $modelInfo['id'] ?? null,
            'old_values' => $this->getOldValues($request),
            'new_values' => $this->getNewValues($request),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'description' => $this->getDescription($request, $action),
            'severity' => $severity,
        ]);
    }

    private function determineAction(Request $request): string
    {
        $path = $request->path();
        $method = $request->method();

        // Authentication actions
        if ($path === 'login') {
            return 'user.login';
        }
        if ($path === 'logout') {
            return 'user.logout';
        }

        // CRUD actions based on route
        if (str_contains($path, 'menus')) {
            return $this->getCrudAction($method, 'menu');
        }
        if (str_contains($path, 'orders')) {
            return $this->getCrudAction($method, 'order');
        }
        if (str_contains($path, 'users')) {
            return $this->getCrudAction($method, 'user');
        }

        return 'unknown';
    }

    private function getCrudAction(string $method, string $resource): string
    {
        return match($method) {
            'GET' => $resource . '.read',
            'POST' => $resource . '.create',
            'PUT', 'PATCH' => $resource . '.update',
            'DELETE' => $resource . '.delete',
            default => $resource . '.unknown'
        };
    }

    private function getModelInfo(Request $request): array
    {
        $path = $request->path();
        
        if (preg_match('/menus\/(\d+)/', $path, $matches)) {
            return ['type' => 'App\Models\Menu', 'id' => $matches[1]];
        }
        if (preg_match('/orders\/(\d+)/', $path, $matches)) {
            return ['type' => 'App\Models\Order', 'id' => $matches[1]];
        }
        if (preg_match('/users\/(\d+)/', $path, $matches)) {
            return ['type' => 'App\Models\User', 'id' => $matches[1]];
        }

        return [];
    }

    private function getOldValues(Request $request): ?array
    {
        // For update operations, get old values from database
        if (in_array($request->method(), ['PUT', 'PATCH'])) {
            $modelInfo = $this->getModelInfo($request);
            if ($modelInfo['type'] && $modelInfo['id']) {
                $model = $modelInfo['type']::find($modelInfo['id']);
                return $model ? $model->toArray() : null;
            }
        }

        return null;
    }

    private function getNewValues(Request $request): ?array
    {
        // Get new values from request
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            return $request->except(['_token', '_method', 'password', 'password_confirmation']);
        }

        return null;
    }

    private function getDescription(Request $request, string $action): string
    {
        $user = auth()->user();
        $userName = $user ? $user->name : 'Guest';
        
        return match($action) {
            'user.login' => "User {$userName} logged in",
            'user.logout' => "User {$userName} logged out",
            'menu.create' => "User {$userName} created a new menu item",
            'menu.update' => "User {$userName} updated a menu item",
            'menu.delete' => "User {$userName} deleted a menu item",
            'order.create' => "User {$userName} created a new order",
            'order.update' => "User {$userName} updated an order",
            'order.delete' => "User {$userName} deleted an order",
            'user.create' => "User {$userName} created a new user account",
            'user.update' => "User {$userName} updated a user account",
            'user.delete' => "User {$userName} deleted a user account",
            default => "User {$userName} performed action: {$action}"
        };
    }
}
