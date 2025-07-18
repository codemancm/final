<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define permissions
        $permissions = [
            'view_admin_dashboard',
            'manage_users',
            'manage_products',
            'manage_services',
            'manage_categories',
            'manage_orders',
            'manage_disputes',
            'manage_support',
            'manage_vendors',
            'manage_settings',
            'manage_canary',
            'manage_logs',
            'manage_roles',
            'manage_permissions',
            'manage_admins',
            'view_services',
            'create_services',
            'edit_services',
            'delete_services',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign all permissions to the admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->sync(Permission::all());
        }

        // Create a super admin role and assign all permissions
        $superAdminRole = Role::create(['name' => 'super_admin']);
        $superAdminRole->permissions()->sync(Permission::all());
    }
}
