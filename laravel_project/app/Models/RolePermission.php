<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
        'permission_id',
        'can_read',
        'can_create',
        'can_update',
        'can_delete'
    ];

    protected $casts = [
        'can_read' => 'boolean',
        'can_create' => 'boolean',
        'can_update' => 'boolean',
        'can_delete' => 'boolean',
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeByPermission($query, $permissionId)
    {
        return $query->where('permission_id', $permissionId);
    }

    public function hasAnyPermission()
    {
        return $this->can_read || $this->can_create || $this->can_update || $this->can_delete;
    }

    public function getPermissionsArray()
    {
        $permissions = [];
        
        if ($this->can_read) $permissions[] = 'read';
        if ($this->can_create) $permissions[] = 'create';
        if ($this->can_update) $permissions[] = 'update';
        if ($this->can_delete) $permissions[] = 'delete';
        
        return $permissions;
    }
}
