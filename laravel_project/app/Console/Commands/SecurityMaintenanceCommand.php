<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SessionService;
use App\Services\AuditService;
use App\Models\UserSession;
use App\Models\AuditLog;
use Carbon\Carbon;

class SecurityMaintenanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'security:maintenance {--clean-sessions : Clean expired sessions} {--clean-audit-logs : Clean old audit logs} {--all : Run all maintenance tasks}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform security maintenance tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting security maintenance...');

        if ($this->option('all') || $this->option('clean-sessions')) {
            $this->cleanExpiredSessions();
        }

        if ($this->option('all') || $this->option('clean-audit-logs')) {
            $this->cleanOldAuditLogs();
        }

        if (!$this->option('all') && !$this->option('clean-sessions') && !$this->option('clean-audit-logs')) {
            $this->showSecurityStats();
        }

        $this->info('Security maintenance completed!');
    }

    private function cleanExpiredSessions(): void
    {
        $this->info('Cleaning expired sessions...');
        
        $expiredSessions = UserSession::where('expires_at', '<', now())
            ->where('is_active', true)
            ->count();

        if ($expiredSessions > 0) {
            $cleaned = UserSession::where('expires_at', '<', now())
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'logout_reason' => 'timeout'
                ]);

            $this->info("Cleaned {$cleaned} expired sessions.");
        } else {
            $this->info('No expired sessions found.');
        }
    }

    private function cleanOldAuditLogs(): void
    {
        $this->info('Cleaning old audit logs...');
        
        $retentionDays = config('security.audit.retention_days', 90);
        $cutoffDate = Carbon::now()->subDays($retentionDays);
        
        $oldLogs = AuditLog::where('created_at', '<', $cutoffDate)->count();
        
        if ($oldLogs > 0) {
            $deleted = AuditLog::where('created_at', '<', $cutoffDate)->delete();
            $this->info("Deleted {$deleted} old audit logs (older than {$retentionDays} days).");
        } else {
            $this->info('No old audit logs found.');
        }
    }

    private function showSecurityStats(): void
    {
        $this->info('Security Statistics:');
        $this->newLine();

        // Session stats
        $totalSessions = UserSession::count();
        $activeSessions = UserSession::where('is_active', true)->count();
        $expiredSessions = UserSession::where('expires_at', '<', now())->count();

        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Sessions', $totalSessions],
                ['Active Sessions', $activeSessions],
                ['Expired Sessions', $expiredSessions],
            ]
        );

        // Audit log stats
        $totalLogs = AuditLog::count();
        $todayLogs = AuditLog::whereDate('created_at', today())->count();
        $criticalLogs = AuditLog::where('severity', 'critical')->count();

        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Audit Logs', $totalLogs],
                ['Today\'s Logs', $todayLogs],
                ['Critical Logs', $criticalLogs],
            ]
        );

        // User security stats
        $lockedUsers = \App\Models\User::where('locked_until', '>', now())->count();
        $usersWith2FA = \App\Models\User::where('two_factor_enabled', true)->count();

        $this->table(
            ['Metric', 'Count'],
            [
                ['Locked Users', $lockedUsers],
                ['Users with 2FA', $usersWith2FA],
            ]
        );
    }
}
