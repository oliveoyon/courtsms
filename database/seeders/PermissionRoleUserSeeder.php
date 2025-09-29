<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\PermissionGroup;

class PermissionRoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // === Step 0: Fresh migrate to clean DB ===
        Artisan::call('migrate:fresh');

        // === Step 1: Clean all related tables ===
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        Role::truncate();
        User::truncate();
        PermissionGroup::truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // === 2. Permission Groups ===
        $groups = [
            1 => 'Permission Management',
            2 => 'Role Managements',
            3 => 'Permission Group Management',
            4 => 'User Management',
            5 => 'Division Management',
            6 => 'District Management',
            7 => 'Court Management',
        ];

        foreach ($groups as $id => $name) {
            PermissionGroup::create([
                'id' => $id,
                'name' => $name,
            ]);
        }

        // === 3. Permissions ===
        $permissions = [
            [1, 1, 'View Permission'],
            [2, 1, 'Create Permission'],
            [3, 1, 'Edit Permission'],
            [4, 1, 'Delete Permission'],
            [5, 2, 'View Roles'],
            [6, 2, 'Create Role'],
            [7, 2, 'Edit Role'],
            [8, 2, 'Delete Role'],
            [9, 2, 'Assign Permissions'],
            [10, 3, 'View Permission Group'],
            [11, 3, 'Create Permission Group'],
            [12, 3, 'Edit Permission Group'],
            [13, 3, 'Delete Permission Group'],
            [14, 4, 'View Users'],
            [15, 4, 'Create Users'],
            [16, 4, 'Edit Users'],
            [17, 4, 'Delete Users'],
            [18, 4, 'View User Permissions'],
            [19, 5, 'View Division'],
            [20, 5, 'Create Division'],
            [21, 5, 'Edit Division'],
            [22, 5, 'Delete Divisioners'],
            [23, 6, 'View District'],
            [24, 6, 'Create District'],
            [25, 6, 'Edit District'],
            [26, 6, 'Delete District'],
            [27, 7, 'View Court'],
            [28, 7, 'Create Court'],
            [29, 7, 'Edit Court'],
            [30, 7, 'Delete Court'],
            
        ];

        foreach ($permissions as [$id, $groupId, $name]) {
            Permission::create([
                'id' => $id,
                'name' => $name,
                'group_id' => $groupId,
                'guard_name' => 'web',
            ]);
        }

        // === 4. Roles ===
        $superAdminRole = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        $adminRole = Role::create([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        // Assign all permissions to Admin role
        $adminRole->syncPermissions(Permission::all());

        // === 5. Super Admin User ===
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'division_id' => null,
            'district_id' => null,
            'court_id' => null,
            'is_active' => true,
        ]);

        $superAdmin->assignRole($superAdminRole);
    }
}
