<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Socialmediamanager;
use App\Models\Document;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Import DB facade

class SocialmediamanagerDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Schema::disableForeignKeyConstraints(); // Already handled in SocialmediamanagersTableSeeder if run before
        // DB::table('document_socialmediamanager')->truncate(); // Clear pivot table
        // DB::table('socialmediamanagers')->delete(); // Clear managers if not done by another seeder
        // Consider if you want to clear specific documents here or rely on a general DocumentSeeder
        // Schema::enableForeignKeyConstraints();


        $manager1 = Socialmediamanager::firstOrCreate(
            ['email' => 'social.manager.jane@example.com'],
            ['name' => 'Jane Doe (Social)']
        );

        $manager2 = Socialmediamanager::firstOrCreate(
            ['email' => 'social.manager.john@example.com'],
            ['name' => 'John Smith (Social)']
        );

        $documentsData = [
            [
                'title' => 'Q3 Campaign Strategy',
                'type' => 'Strategy Document',
                'status' => 'approved',
                'uploaded_by' => 'Admin',
                'approved_by' => 'Marketing Head',
                'approval_comment' => 'Looks good, proceed.',
                'file_path' => '/storage/documents/sample_q3_strategy.pdf',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(5),
            ],
            [
                'title' => 'Influencer Outreach List',
                'type' => 'Contact List',
                'status' => 'pending',
                'uploaded_by' => $manager1->name,
                'approved_by' => null,
                'approval_comment' => null,
                'file_path' => '/storage/documents/sample_influencer_list.xlsx',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(1),
            ],
            [
                'title' => 'Monthly Performance Report - May',
                'type' => 'Report',
                'status' => 'approved',
                'uploaded_by' => $manager2->name,
                'approved_by' => 'Team Lead',
                'approval_comment' => 'Approved.',
                'file_path' => '/storage/documents/sample_may_report.pdf',
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(12),
            ],
            [
                'title' => 'Ad Creative Brief',
                'type' => 'Brief',
                'status' => 'rejected',
                'uploaded_by' => $manager1->name,
                'approved_by' => 'Creative Director',
                'approval_comment' => 'Needs more focus on target audience.',
                'file_path' => '/storage/documents/sample_ad_brief.docx',
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(6),
            ]
        ];

        foreach ($documentsData as $index => $docData) {
            $document = Document::create($docData);

            // Attach to managers, e.g., assign first two docs to manager1, next two to manager2
            if ($index < 2) {
                $manager1->documents()->attach($document->id);
            } else {
                $manager2->documents()->attach($document->id);
            }
        }
    }
}
