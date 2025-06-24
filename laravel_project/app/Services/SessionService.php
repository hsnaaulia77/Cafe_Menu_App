<?php

namespace App\Services;

use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class SessionService
{
    private $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }

    /**
     * Create new user session
     */
    public function createSession(string $sessionId): UserSession
    {
        $user = Auth::user();
        
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        // Terminate old sessions if max sessions exceeded
        $this->enforceMaxSessions($user);

        return UserSession::create([
            'user_id' => $user->id,
            'session_id' => $sessionId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'device_type' => $this->getDeviceType(),
            'browser' => $this->agent->browser(),
            'platform' => $this->agent->platform(),
            'location' => $this->getLocation(),
            'last_activity' => now(),
            'expires_at' => now()->addMinutes(config('session.lifetime', 120)),
            'is_active' => true,
        ]);
    }

    /**
     * Update session activity
     */
    public function updateActivity(string $sessionId): bool
    {
        $session = UserSession::where('session_id', $sessionId)
            ->where('is_active', true)
            ->first();

        if (!$session) {
            return false;
        }

        // Check if session is expired
        if ($session->isExpired()) {
            $session->terminate('timeout');
            return false;
        }

        $session->updateActivity();
        return true;
    }

    /**
     * Terminate session
     */
    public function terminateSession(string $sessionId, string $reason = 'manual'): bool
    {
        $session = UserSession::where('session_id', $sessionId)->first();
        
        if (!$session) {
            return false;
        }

        $session->terminate($reason);
        return true;
    }

    /**
     * Terminate all user sessions except current
     */
    public function terminateOtherSessions(string $currentSessionId, string $reason = 'security'): int
    {
        $user = Auth::user();
        
        if (!$user) {
            return 0;
        }

        return $user->sessions()
            ->where('session_id', '!=', $currentSessionId)
            ->where('is_active', true)
            ->update([
                'is_active' => false,
                'logout_reason' => $reason
            ]);
    }

    /**
     * Clean expired sessions
     */
    public function cleanExpiredSessions(): int
    {
        return UserSession::where('expires_at', '<', now())
            ->where('is_active', true)
            ->update([
                'is_active' => false,
                'logout_reason' => 'timeout'
            ]);
    }

    /**
     * Get user active sessions
     */
    public function getUserActiveSessions(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return UserSession::where('user_id', $userId)
            ->where('is_active', true)
            ->orderBy('last_activity', 'desc')
            ->get();
    }

    /**
     * Check if user has too many active sessions
     */
    public function hasTooManySessions(int $userId): bool
    {
        $maxSessions = config('session.max_sessions', 5);
        $activeSessions = UserSession::where('user_id', $userId)
            ->where('is_active', true)
            ->count();

        return $activeSessions >= $maxSessions;
    }

    /**
     * Enforce maximum sessions per user
     */
    private function enforceMaxSessions($user): void
    {
        if ($this->hasTooManySessions($user->id)) {
            // Terminate oldest sessions
            $oldestSessions = UserSession::where('user_id', $user->id)
                ->where('is_active', true)
                ->orderBy('last_activity', 'asc')
                ->limit(1)
                ->get();

            foreach ($oldestSessions as $session) {
                $session->terminate('max_sessions_exceeded');
            }
        }
    }

    /**
     * Get device type
     */
    private function getDeviceType(): string
    {
        if ($this->agent->isTablet()) {
            return 'tablet';
        }
        
        if ($this->agent->isMobile()) {
            return 'mobile';
        }
        
        return 'desktop';
    }

    /**
     * Get location (simplified - in production use IP geolocation service)
     */
    private function getLocation(): ?string
    {
        // In production, you would use a service like MaxMind or IP2Location
        // For now, return null
        return null;
    }

    /**
     * Get session statistics
     */
    public function getSessionStats(): array
    {
        $totalSessions = UserSession::count();
        $activeSessions = UserSession::where('is_active', true)->count();
        $expiredSessions = UserSession::where('expires_at', '<', now())->count();

        return [
            'total' => $totalSessions,
            'active' => $activeSessions,
            'expired' => $expiredSessions,
            'expired_percentage' => $totalSessions > 0 ? round(($expiredSessions / $totalSessions) * 100, 2) : 0,
        ];
    }
} 