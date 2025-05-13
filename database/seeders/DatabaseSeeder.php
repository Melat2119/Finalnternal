<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        \App\Models\User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'), // Set a default password
            ]
        );

        $this->call([
            DevelopersTableSeeder::class,
            DocumentSeeder::class,
            SalesTableSeeder::class,
            UidesignersTableSeeder::class,
            ReceptionsTableSeeder::class,
            SocialmediamanagersTableSeeder::class,
            AuditLogSeeder::class,
            SalesDocumentSeeder::class,
        ]);
    }
}
