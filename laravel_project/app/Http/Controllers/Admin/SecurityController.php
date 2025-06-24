<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuditService;
use App\Services\SessionService;
use App\Models\AuditLog;
use App\Models\UserSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SecurityController extends Controller
{
    protected $auditService;
    protected $sessionService;

    public function __construct(AuditService $auditService, SessionService $sessionService)
    {
        $this->auditService = $auditService;
        $this->sessionService = $sessionService;
    }

    /**
     * Display security dashboard
     */
    public function dashboard()
    {
        // Security statistics
        $stats = [
            'total_users' => User::count(),
            'active_sessions' => UserSession::where('is_active', true)->count(),
            'locked_users' => User::where('locked_until', '>', now())->count(),
            'users_with_2fa' => User::where('two_factor_enabled', true)->count(),
            'total_audit_logs' => AuditLog::count(),
            'critical_logs' => AuditLog::where('severity', 'critical')->count(),
            'today_logs' => AuditLog::whereDate('created_at', today())->count(),
        ];

        // Recent security events
        $recentEvents = AuditLog::with('user')
            ->whereIn('severity', ['warning', 'error', 'critical'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Active sessions by user
        $activeSessions = UserSession::with('user')
            ->where('is_active', true)
            ->orderBy('last_activity', 'desc')
            ->limit(20)
            ->get();

        return view('admin.security.dashboard', compact('stats', 'recentEvents', 'activeSessions'));
    }

    /**
     * Display audit logs
     */
    public function auditLogs(Request $request)
    {
        $filters = $request->only(['user_id', 'action', 'severity', 'date_from', 'date_to', 'model_type']);
        
        $logs = $this->auditService->getLogs($filters)->paginate(50);
        
        $users = User::orderBy('name')->get();
        $actions = AuditLog::distinct()->pluck('action')->sort();
        $severities = ['info', 'warning', 'error', 'critical'];

        return view('admin.security.audit-logs', compact('logs', 'users', 'actions', 'severities', 'filters'));
    }

    /**
     * Display user sessions
     */
    public function userSessions(Request $request)
    {
        $sessions = UserSession::with('user')
            ->when($request->user_id, function($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->when($request->status, function($query, $status) {
                if ($status === 'active') {
                    return $query->where('is_active', true);
                }
                if ($status === 'expired') {
                    return $query->where('expires_at', '<', now());
                }
                return $query;
            })
            ->orderBy('last_activity', 'desc')
            ->paginate(50);

        $users = User::orderBy('name')->get();

        return view('admin.security.user-sessions', compact('sessions', 'users'));
    }

    /**
     * Terminate user session
     */
    public function terminateSession(Request $request, $sessionId)
    {
        $session = UserSession::findOrFail($sessionId);
        
        $this->sessionService->terminateSession($sessionId, 'admin_terminated');
        
        // Log the action
        $this->auditService->log('session.terminated', [
            'description' => 'Admin terminated session for user: ' . $session->user->name,
            'model_type' => 'App\Models\UserSession',
            'model_id' => $sessionId,
        ], 'warning');

        return redirect()->back()->with('success', 'Session terminated successfully.');
    }

    /**
     * Terminate all sessions for a user
     */
    public function terminateAllUserSessions(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $terminatedCount = $this->sessionService->terminateOtherSessions('', 'admin_terminated_all');
        
        // Log the action
        $this->auditService->log('sessions.terminated_all', [
            'description' => "Admin terminated all sessions for user: {$user->name}",
            'model_type' => 'App\Models\User',
            'model_id' => $userId,
        ], 'warning');

        return redirect()->back()->with('success', "Terminated {$terminatedCount} sessions for {$user->name}.");
    }

    /**
     * Unlock user account
     */
    public function unlockUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        $user->update([
            'locked_until' => null,
            'login_attempts' => 0,
        ]);

        // Log the action
        $this->auditService->log('user.unlocked', [
            'description' => "Admin unlocked account for user: {$user->name}",
            'model_type' => 'App\Models\User',
            'model_id' => $userId,
        ], 'info');

        return redirect()->back()->with('success', "Account unlocked for {$user->name}.");
    }

    /**
     * Force password change for user
     */
    public function forcePasswordChange(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        $user->update([
            'force_password_change' => true,
        ]);

        // Log the action
        $this->auditService->log('user.force_password_change', [
            'description' => "Admin forced password change for user: {$user->name}",
            'model_type' => 'App\Models\User',
            'model_id' => $userId,
        ], 'warning');

        return redirect()->back()->with('success', "Password change forced for {$user->name}.");
    }

    /**
     * Get security statistics
     */
    public function getStats()
    {
        $stats = [
            'sessions' => $this->sessionService->getSessionStats(),
            'audit' => $this->auditService->getStats(),
            'users' => [
                'total' => User::count(),
                'locked' => User::where('locked_until', '>', now())->count(),
                'with_2fa' => User::where('two_factor_enabled', true)->count(),
            ],
        ];

        return response()->json($stats);
    }

    /**
     * Export audit logs
     */
    public function exportAuditLogs(Request $request)
    {
        $filters = $request->only(['user_id', 'action', 'severity', 'date_from', 'date_to']);
        
        $logs = $this->auditService->getLogs($filters)->get();

        $filename = 'audit_logs_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'User', 'Action', 'Model Type', 'Model ID', 
                'IP Address', 'User Agent', 'URL', 'Method', 
                'Description', 'Severity', 'Created At'
            ]);

            // CSV data
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->user ? $log->user->name : 'Guest',
                    $log->action,
                    $log->model_type,
                    $log->model_id,
                    $log->ip_address,
                    $log->user_agent,
                    $log->url,
                    $log->method,
                    $log->description,
                    $log->severity,
                    $log->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
