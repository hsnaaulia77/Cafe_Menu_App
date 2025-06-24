<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    /**
     * Log user action
     */
    public function log(string $action, array $data = [], string $severity = 'info'): AuditLog
    {
        $user = Auth::user();
        
        return AuditLog::create([
            'user_id' => $user?->id,
            'action' => $action,
            'model_type' => $data['model_type'] ?? null,
            'model_id' => $data['model_id'] ?? null,
            'old_values' => $data['old_values'] ?? null,
            'new_values' => $data['new_values'] ?? null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'description' => $data['description'] ?? $this->generateDescription($action, $data),
            'severity' => $severity,
        ]);
    }

    /**
     * Log model changes
     */
    public function logModelChange(string $action, $model, array $oldValues = null, array $newValues = null): AuditLog
    {
        $data = [
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => $this->generateModelDescription($action, $model),
        ];

        return $this->log($action, $data);
    }

    /**
     * Log authentication events
     */
    public function logAuthEvent(string $event, array $data = []): AuditLog
    {
        $severity = match($event) {
            'login.success' => 'info',
            'login.failed' => 'warning',
            'logout' => 'info',
            'password.change' => 'info',
            'password.reset' => 'warning',
            'account.locked' => 'error',
            'account.unlocked' => 'info',
            default => 'info'
        };

        return $this->log($event, $data, $severity);
    }

    /**
     * Log security events
     */
    public function logSecurityEvent(string $event, array $data = []): AuditLog
    {
        $severity = match($event) {
            'suspicious.activity' => 'warning',
            'brute.force.attempt' => 'error',
            'unauthorized.access' => 'error',
            'data.breach' => 'critical',
            'session.hijack' => 'critical',
            default => 'warning'
        };

        return $this->log($event, $data, $severity);
    }

    /**
     * Log payment events
     */
    public function logPaymentEvent(string $event, array $data = []): AuditLog
    {
        $severity = match($event) {
            'payment.success' => 'info',
            'payment.failed' => 'warning',
            'payment.refund' => 'info',
            'payment.dispute' => 'error',
            'payment.fraud' => 'critical',
            default => 'info'
        };

        return $this->log($event, $data, $severity);
    }

    /**
     * Generate description for action
     */
    private function generateDescription(string $action, array $data): string
    {
        $user = Auth::user();
        $userName = $user ? $user->name : 'Guest';
        
        return match($action) {
            'user.login' => "User {$userName} logged in",
            'user.logout' => "User {$userName} logged out",
            'user.password_change' => "User {$userName} changed password",
            'user.account_locked' => "User account locked due to multiple failed attempts",
            'menu.create' => "User {$userName} created a new menu item",
            'menu.update' => "User {$userName} updated a menu item",
            'menu.delete' => "User {$userName} deleted a menu item",
            'order.create' => "User {$userName} created a new order",
            'order.update' => "User {$userName} updated an order",
            'order.delete' => "User {$userName} deleted an order",
            'payment.process' => "Payment processed by {$userName}",
            'payment.refund' => "Payment refunded by {$userName}",
            default => "User {$userName} performed action: {$action}"
        };
    }

    /**
     * Generate description for model changes
     */
    private function generateModelDescription(string $action, $model): string
    {
        $user = Auth::user();
        $userName = $user ? $user->name : 'Guest';
        $modelName = class_basename($model);
        
        return match($action) {
            'create' => "User {$userName} created new {$modelName} (ID: {$model->id})",
            'update' => "User {$userName} updated {$modelName} (ID: {$model->id})",
            'delete' => "User {$userName} deleted {$modelName} (ID: {$model->id})",
            default => "User {$userName} performed {$action} on {$modelName} (ID: {$model->id})"
        };
    }

    /**
     * Get audit logs with filters
     */
    public function getLogs(array $filters = []): \Illuminate\Database\Eloquent\Builder
    {
        $query = AuditLog::with('user');

        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (isset($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (isset($filters['severity'])) {
            $query->where('severity', $filters['severity']);
        }

        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        if (isset($filters['model_type'])) {
            $query->where('model_type', $filters['model_type']);
        }

        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Get audit statistics
     */
    public function getStats(array $filters = []): array
    {
        $query = AuditLog::query();

        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        $total = $query->count();
        
        $bySeverity = $query->clone()
            ->selectRaw('severity, COUNT(*) as count')
            ->groupBy('severity')
            ->pluck('count', 'severity')
            ->toArray();

        $byAction = $query->clone()
            ->selectRaw('action, COUNT(*) as count')
            ->groupBy('action')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->pluck('count', 'action')
            ->toArray();

        return [
            'total' => $total,
            'by_severity' => $bySeverity,
            'by_action' => $byAction,
        ];
    }

    /**
     * Clean old audit logs
     */
    public function cleanOldLogs(int $days = 90): int
    {
        return AuditLog::where('created_at', '<', now()->subDays($days))->delete();
    }
} 