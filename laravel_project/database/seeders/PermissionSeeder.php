<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\RolePermission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // Menu permissions
            ['name' => 'menu.read', 'display_name' => 'Lihat Menu', 'module' => 'menu'],
            ['name' => 'menu.create', 'display_name' => 'Buat Menu', 'module' => 'menu'],
            ['name' => 'menu.update', 'display_name' => 'Update Menu', 'module' => 'menu'],
            ['name' => 'menu.delete', 'display_name' => 'Hapus Menu', 'module' => 'menu'],
            
            // Order permissions
            ['name' => 'order.read', 'display_name' => 'Lihat Pesanan', 'module' => 'order'],
            ['name' => 'order.create', 'display_name' => 'Buat Pesanan', 'module' => 'order'],
            ['name' => 'order.update', 'display_name' => 'Update Pesanan', 'module' => 'order'],
            ['name' => 'order.delete', 'display_name' => 'Hapus Pesanan', 'module' => 'order'],
            ['name' => 'order.process', 'display_name' => 'Proses Pesanan', 'module' => 'order'],
            
            // User permissions
            ['name' => 'user.read', 'display_name' => 'Lihat User', 'module' => 'user'],
            ['name' => 'user.create', 'display_name' => 'Buat User', 'module' => 'user'],
            ['name' => 'user.update', 'display_name' => 'Update User', 'module' => 'user'],
            ['name' => 'user.delete', 'display_name' => 'Hapus User', 'module' => 'user'],
            
            // Payment permissions
            ['name' => 'payment.read', 'display_name' => 'Lihat Pembayaran', 'module' => 'payment'],
            ['name' => 'payment.process', 'display_name' => 'Proses Pembayaran', 'module' => 'payment'],
            ['name' => 'payment.refund', 'display_name' => 'Refund Pembayaran', 'module' => 'payment'],
            
            // Report permissions
            ['name' => 'report.read', 'display_name' => 'Lihat Laporan', 'module' => 'report'],
            ['name' => 'report.export', 'display_name' => 'Export Laporan', 'module' => 'report'],
            
            // System permissions
            ['name' => 'system.settings', 'display_name' => 'Pengaturan Sistem', 'module' => 'system'],
            ['name' => 'system.audit', 'display_name' => 'Lihat Audit Log', 'module' => 'system'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Create role permissions
        $this->createRolePermissions();
    }

    private function createRolePermissions(): void
    {
        $rolePermissions = [
            // Admin permissions - full access
            'admin' => [
                'menu.read' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'menu.create' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'menu.update' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'menu.delete' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'order.read' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'order.create' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'order.update' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'order.delete' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'order.process' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'user.read' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'user.create' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'user.update' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'user.delete' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'payment.read' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'payment.process' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'payment.refund' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'report.read' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'report.export' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'system.settings' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
                'system.audit' => ['read' => true, 'create' => true, 'update' => true, 'delete' => true],
            ],
            
            // Cashier permissions
            'cashier' => [
                'menu.read' => ['read' => true, 'create' => false, 'update' => false, 'delete' => false],
                'order.read' => ['read' => true, 'create' => true, 'update' => true, 'delete' => false],
                'order.create' => ['read' => true, 'create' => true, 'update' => true, 'delete' => false],
                'order.update' => ['read' => true, 'create' => true, 'update' => true, 'delete' => false],
                'order.process' => ['read' => true, 'create' => true, 'update' => true, 'delete' => false],
                'payment.read' => ['read' => true, 'create' => true, 'update' => true, 'delete' => false],
                'payment.process' => ['read' => true, 'create' => true, 'update' => true, 'delete' => false],
                'payment.refund' => ['read' => true, 'create' => true, 'update' => true, 'delete' => false],
                'report.read' => ['read' => true, 'create' => false, 'update' => false, 'delete' => false],
            ],
            
            // Customer permissions
            'customer' => [
                'menu.read' => ['read' => true, 'create' => false, 'update' => false, 'delete' => false],
                'order.read' => ['read' => true, 'create' => true, 'update' => false, 'delete' => false],
                'order.create' => ['read' => true, 'create' => true, 'update' => false, 'delete' => false],
                'payment.read' => ['read' => true, 'create' => true, 'update' => false, 'delete' => false],
                'payment.process' => ['read' => true, 'create' => true, 'update' => false, 'delete' => false],
            ],
        ];

        foreach ($rolePermissions as $role => $permissions) {
            foreach ($permissions as $permissionName => $actions) {
                $permission = Permission::where('name', $permissionName)->first();
                
                if ($permission) {
                    RolePermission::create([
                        'role' => $role,
                        'permission_id' => $permission->id,
                        'can_read' => $actions['read'],
                        'can_create' => $actions['create'],
                        'can_update' => $actions['update'],
                        'can_delete' => $actions['delete'],
                    ]);
                }
            }
        }
    }
}
