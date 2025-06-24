<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'catatan',
        'profile_photo',
        'last_login_at',
        'last_login_ip',
        'login_attempts',
        'locked_until',
        'two_factor_enabled',
        'two_factor_secret',
        'password_changed_at',
        'force_password_change',
        'security_preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'locked_until' => 'datetime',
            'password_changed_at' => 'datetime',
            'two_factor_enabled' => 'boolean',
            'force_password_change' => 'boolean',
            'security_preferences' => 'array',
        ];
    }

    // Relationships
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function sessions()
    {
        return $this->hasMany(UserSession::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Security Methods
    public function isLocked()
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    public function incrementLoginAttempts()
    {
        $this->increment('login_attempts');
        
        // Lock account after 5 failed attempts for 30 minutes
        if ($this->login_attempts >= 5) {
            $this->update([
                'locked_until' => now()->addMinutes(30)
            ]);
        }
    }

    public function resetLoginAttempts()
    {
        $this->update([
            'login_attempts' => 0,
            'locked_until' => null
        ]);
    }

    public function recordLogin($ipAddress)
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ipAddress,
            'login_attempts' => 0,
            'locked_until' => null
        ]);
    }

    public function hasPermission($permission, $action = 'read')
    {
        $permissionModel = Permission::where('name', $permission)->first();
        
        if (!$permissionModel) {
            return false;
        }

        return $permissionModel->hasPermission($this->role, $action);
    }

    public function canRead($permission)
    {
        return $this->hasPermission($permission, 'read');
    }

    public function canCreate($permission)
    {
        return $this->hasPermission($permission, 'create');
    }

    public function canUpdate($permission)
    {
        return $this->hasPermission($permission, 'update');
    }

    public function canDelete($permission)
    {
        return $this->hasPermission($permission, 'delete');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCashier()
    {
        return $this->role === 'cashier';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function getActiveSessions()
    {
        return $this->sessions()->active()->get();
    }

    public function terminateAllSessions($reason = 'admin_action')
    {
        $this->sessions()->active()->update([
            'is_active' => false,
            'logout_reason' => $reason
        ]);
    }

    public function shouldChangePassword()
    {
        // Force password change if admin set it
        if ($this->force_password_change) {
            return true;
        }

        // Force password change if password is older than 90 days
        if ($this->password_changed_at && $this->password_changed_at->diffInDays(now()) > 90) {
            return true;
        }

        return false;
    }
}
