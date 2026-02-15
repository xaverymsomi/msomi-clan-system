<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $elder = Role::firstOrCreate(['name' => 'Clan Elder']);
        $member = Role::firstOrCreate(['name' => 'Member']);
        $guest = Role::firstOrCreate(['name' => 'Guest']);

        // Create permissions
        $permissions = [
            // Member permissions
            'view members',
            'create members',
            'edit members',
            'delete members',

            // Tradition permissions
            'view traditions',
            'create traditions',
            'edit traditions',
            'delete traditions',
            'publish traditions',

            // Event permissions
            'view events',
            'create events',
            'edit events',
            'delete events',
            'manage attendees',

            // Announcement permissions
            'view announcements',
            'create announcements',
            'edit announcements',
            'delete announcements',

            // Contribution permissions
            'view contributions',
            'create contributions',
            'edit contributions',
            'delete contributions',
            'view financial reports',

            // Document permissions
            'view documents',
            'upload documents',
            'edit documents',
            'edit documents',
            'delete documents',

            // Role Management
            'manage roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $superAdmin->givePermissionTo(Permission::all());

        $elder->givePermissionTo([
            'view members', 'create members', 'edit members',
            'view traditions', 'create traditions', 'edit traditions', 'publish traditions',
            'view events', 'create events', 'edit events', 'manage attendees',
            'view announcements', 'create announcements', 'edit announcements',
            'view contributions', 'create contributions', 'view financial reports',
            'view documents', 'upload documents', 'edit documents',
        ]);

        $member->givePermissionTo([
            'view members',
            'view traditions',
            'view events',
            'view announcements',
            'view contributions',
            'view documents',
        ]);

        $guest->givePermissionTo([
            'view traditions',
            'view events',
            'view announcements',
        ]);
    }
}
