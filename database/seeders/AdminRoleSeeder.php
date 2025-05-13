<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminRoleSeeder extends Seeder
{
    public function run()
    {
        $role = Role::firstOrCreate(['name' => 'admin']);
        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            $user->assignRole($role);
        }
    }
}
