<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Permissions ─────────────────────────────────────
        $permissionData = [
            // Users
            ['name' => 'users.view',   'label' => 'View Users',   'group' => 'Users'],
            ['name' => 'users.create', 'label' => 'Create Users', 'group' => 'Users'],
            ['name' => 'users.edit',   'label' => 'Edit Users',   'group' => 'Users'],
            ['name' => 'users.delete', 'label' => 'Delete Users', 'group' => 'Users'],
            // Roles
            ['name' => 'roles.view',   'label' => 'View Roles',   'group' => 'Roles'],
            ['name' => 'roles.create', 'label' => 'Create Roles', 'group' => 'Roles'],
            ['name' => 'roles.edit',   'label' => 'Edit Roles',   'group' => 'Roles'],
            ['name' => 'roles.delete', 'label' => 'Delete Roles', 'group' => 'Roles'],
            // Permissions
            ['name' => 'permissions.view',   'label' => 'View Permissions',   'group' => 'Permissions'],
            ['name' => 'permissions.create', 'label' => 'Create Permissions', 'group' => 'Permissions'],
            ['name' => 'permissions.edit',   'label' => 'Edit Permissions',   'group' => 'Permissions'],
            ['name' => 'permissions.delete', 'label' => 'Delete Permissions', 'group' => 'Permissions'],
        ];

        foreach ($permissionData as $p) {
            Permission::firstOrCreate(['name' => $p['name']], $p);
        }

        $allPermissions = Permission::pluck('id');

        // ── Roles ────────────────────────────────────────────
        $superAdmin = Role::firstOrCreate(
            ['name' => 'superadmin'],
            ['label' => 'Super Administrator', 'description' => 'Has all permissions']
        );
        $superAdmin->permissions()->sync($allPermissions);

        $admin = Role::firstOrCreate(
            ['name' => 'admin'],
            ['label' => 'Administrator', 'description' => 'Can manage users and roles']
        );
        $admin->permissions()->sync(
            Permission::whereIn('group', ['Users', 'Roles'])->pluck('id')
        );

        $editor = Role::firstOrCreate(
            ['name' => 'editor'],
            ['label' => 'Editor', 'description' => 'Can view users']
        );
        $editor->permissions()->sync(
            Permission::where('name', 'like', '%.view')->pluck('id')
        );

        // ── Users ────────────────────────────────────────────
        $superUser = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('password'),
                'status'   => 'active',
            ]
        );
        $superUser->roles()->sync([$superAdmin->id]);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password'),
                'status'   => 'active',
            ]
        );
        $adminUser->roles()->sync([$admin->id]);

        $editorUser = User::firstOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name'     => 'Editor User',
                'password' => Hash::make('password'),
                'status'   => 'active',
            ]
        );
        $editorUser->roles()->sync([$editor->id]);

        $this->command->info('✅  Seeded: 3 roles, 12 permissions, 3 users');
        $this->command->table(
            ['Email', 'Password', 'Role'],
            [
                ['superadmin@example.com', 'password', 'Super Admin'],
                ['admin@example.com',      'password', 'Admin'],
                ['editor@example.com',     'password', 'Editor'],
            ]
        );
    }
}
