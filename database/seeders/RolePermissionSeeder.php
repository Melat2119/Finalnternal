<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'view dashboard',
            'manage users',
            'edit articles',
            'delete articles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Assign all permissions to admin
        $admin->syncPermissions(Permission::all());

        // Assign some permissions to manager
        $manager->syncPermissions(['view dashboard', 'edit articles']);

        // Assign basic permission to user
        $user->syncPermissions(['view dashboard']);

        // Assign roles to users by email
        $adminUser = User::where('email', 'admin@gmail.com')->first();
        if ($adminUser) {
            $adminUser->assignRole('admin');
            // Example: $adminUser->givePermissionTo('manage users');
            // Example: $adminUser->hasRole('admin'); // returns true
            // Example: $adminUser->can('edit articles'); // returns true
        }

        $managerUser = User::where('email', 'manager@gmail.com')->first();
        if ($managerUser) {
            $managerUser->assignRole('manager');
            // Example: $managerUser->hasRole('manager'); // returns true
            // Example: $managerUser->can('edit articles'); // returns true
        }
    }
}