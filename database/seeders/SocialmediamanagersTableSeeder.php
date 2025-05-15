<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Socialmediamanager; // Make sure to import your Socialmediamanager model

class SocialmediamanagersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Replace truncate with delete
        DB::table('socialmediamanagers')->delete(); 

        Schema::enableForeignKeyConstraints();

        // Add your seeding logic here, for example:
        Socialmediamanager::create([
            'name' => 'Social Manager Alpha',
            'email' => 'socialalpha@example.com',
        ]);

        Socialmediamanager::create([
            'name' => 'Social Manager Beta',
            'email' => 'socialbeta@example.com',
        ]);

        // Add more managers as needed
    }
}
