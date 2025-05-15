<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Reception;

class ReceptionsTableSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // Delete from pivot table first, then from receptions
        DB::table('document_reception')->delete();
        DB::table('receptions')->delete();

        Schema::enableForeignKeyConstraints();

        // Create receptions
        Reception::create([
            'name' => 'Reception Desk 1',
            'email' => 'reception1@example.com',
        ]);
        Reception::create([
            'name' => 'Reception Desk 2',
            'email' => 'reception2@example.com',
        ]);
    }
}
