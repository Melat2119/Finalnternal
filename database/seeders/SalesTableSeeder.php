<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sales_documents')->truncate();
        DB::table('sales_documents')->insert([
            [
                'title' => 'Proposal for Client X',
                'client_name' => 'Client X Organization', // Use client_name
                'salesperson' => 'Alice Sales',
                'type' => 'Proposal',
                'status' => 'Draft',
                'validity_period' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Invoice #2024-01',
                'client_name' => 'Acme Corp', // Use client_name
                'salesperson' => 'Bob Sales',
                'type' => 'Invoice',
                'status' => 'Sent',
                'validity_period' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Offer for Y Project',
                'client_name' => 'Y Company', // Use client_name
                'salesperson' => 'Alice Sales',
                'type' => 'Offer',
                'status' => 'Approved',
                'validity_period' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
