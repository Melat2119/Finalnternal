<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import DB facade
use Illuminate\Support\Facades\Schema;
use App\Models\Uidesigner;

class UidesignersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Replace truncate with delete for better compatibility with FK checks disabled
        DB::table('uidesigners')->delete(); 

        Schema::enableForeignKeyConstraints();

        Uidesigner::create([
            'name' => 'UI Designer One',
            'email' => 'uidesigner1@example.com',
        ]);

        Uidesigner::create([
            'name' => 'UI Designer Two',
            'email' => 'uidesigner2@example.com',
        ]);
    }
}
