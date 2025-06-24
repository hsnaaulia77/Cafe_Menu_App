<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'module',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }

    public function hasPermission($role, $action)
    {
        $rolePermission = $this->rolePermissions()
            ->where('role', $role)
            ->first();

        if (!$rolePermission) {
            return false;
        }

        return match($action) {
            'read' => $rolePermission->can_read,
            'create' => $rolePermission->can_create,
            'update' => $rolePermission->can_update,
            'delete' => $rolePermission->can_delete,
            default => false
        };
    }
}
