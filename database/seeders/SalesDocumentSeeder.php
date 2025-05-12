<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesDocument;
use Carbon\Carbon;

class SalesDocumentSeeder extends Seeder
{
    public function run()
    {
        $types = ['Offer', 'Invoice', 'Proposal'];
        $statuses = ['Draft', 'Sent', 'Approved'];
        $clients = ['Acme Corp', 'Globex Inc', 'Umbrella LLC', 'Wayne Enterprises'];
        $salespeople = ['Alice', 'Bob', 'Charlie', 'Diana'];

        for ($i = 1; $i <= 10; $i++) {
            SalesDocument::create([
                'title' => "Proposal for Client {$clients[array_rand($clients)]}",
                'client_name' => $clients[array_rand($clients)], // Use client_name only
                'salesperson' => $salespeople[array_rand($salespeople)],
                'type' => $types[array_rand($types)],
                'status' => $statuses[array_rand($statuses)],
                'validity_period' => rand(0, 1) ? Carbon::now()->addDays(rand(10, 60)) : null,
            ]);
        }
    }
}
