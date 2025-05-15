<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Uidesigner;
use App\Models\Document;

class UidesignerSeeder extends Seeder
{
    public function run()
    {
        // Avoid duplicate email error by using firstOrCreate
        $designer = \App\Models\Uidesigner::firstOrCreate(
            ['email' => 'designer@example.com'],
            ['name' => 'Test Designer']
        );

        \App\Models\Document::create([
            'title' => 'UIUX Spec',
            'department' => 'Design',
            'type' => 'Spec',
            'file_path' => '/storage/documents/test.pdf',
            'status' => 'pending',
            'approved_by' => 'Manager',
            'approval_comment' => 'Looks good',
            'uidesigner_id' => $designer->id,
        ]);
    }
}
