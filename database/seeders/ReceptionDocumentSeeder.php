<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Reception;
use App\Models\Document;

class ReceptionDocumentSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Delete from pivot table first, then from documents, then from receptions
        DB::table('document_reception')->delete();
        DB::table('documents')->delete();
        DB::table('receptions')->delete();

        Schema::enableForeignKeyConstraints();

        // Create some receptions
        $reception1 = Reception::firstOrCreate(
            ['email' => 'reception1@example.com'],
            ['name' => 'Reception Desk 1']
        );
        $reception2 = Reception::firstOrCreate(
            ['email' => 'reception2@example.com'],
            ['name' => 'Reception Desk 2']
        );

        // Create documents and attach to receptions
        $documentsData = [
            [
                'title' => 'Visitor Log June',
                'type' => 'Log',
                'status' => 'approved',
                'uploaded_by' => $reception1->name,
                'approved_by' => 'Manager',
                'approval_comment' => 'Checked',
                'file_path' => '/storage/documents/visitor_log_june.pdf',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(5),
            ],
            [
                'title' => 'Package Receipt',
                'type' => 'Receipt',
                'status' => 'pending',
                'uploaded_by' => $reception1->name,
                'approved_by' => null,
                'approval_comment' => null,
                'file_path' => '/storage/documents/package_receipt.pdf',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(1),
            ],
            [
                'title' => 'Maintenance Request',
                'type' => 'Request',
                'status' => 'approved',
                'uploaded_by' => $reception2->name,
                'approved_by' => 'Facilities',
                'approval_comment' => 'Completed',
                'file_path' => '/storage/documents/maintenance_request.pdf',
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(12),
            ],
            [
                'title' => 'Lost and Found Report',
                'type' => 'Report',
                'status' => 'rejected',
                'uploaded_by' => $reception2->name,
                'approved_by' => 'Security',
                'approval_comment' => 'Incomplete details',
                'file_path' => '/storage/documents/lost_found_report.pdf',
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(6),
            ]
        ];

        foreach ($documentsData as $index => $docData) {
            $document = Document::create($docData);
            if ($index < 2) {
                $reception1->documents()->attach($document->id);
            } else {
                $reception2->documents()->attach($document->id);
            }
        }
    }
}
