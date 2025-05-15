<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents', 'socialmediamanager_id')) {
                // Attempt to drop foreign key if it exists.
                // Laravel's default foreign key name convention is table_column_foreign.
                // Check your database if this name is different.
                try {
                    // Check if the foreign key exists before trying to drop it.
                    // This requires a bit more logic to inspect schema or catch exceptions,
                    // or ensure your DB user has rights to inspect schema.
                    // A common approach is to know the foreign key name.
                    // If the foreign key was named 'documents_socialmediamanager_id_foreign'
                    $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys('documents');
                    $foreignKeyExists = false;
                    foreach ($foreignKeys as $foreignKey) {
                        if ($foreignKey->getColumns() == ['socialmediamanager_id']) {
                            $table->dropForeign(['socialmediamanager_id']); // Can use array or specific name
                            $foreignKeyExists = true;
                            break;
                        }
                    }
                } catch (\Exception $e) {
                    // Log error or handle if necessary, e.g., foreign key didn't exist or different name
                }
                $table->dropColumn('socialmediamanager_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'socialmediamanager_id')) {
                $table->unsignedBigInteger('socialmediamanager_id')->nullable()->after('uidesigner_id'); // Adjust position as needed
                // Add foreign key back if it was intended to be there
                // Ensure the 'socialmediamanagers' table and 'id' column exist.
                $table->foreign('socialmediamanager_id')
                      ->references('id')
                      ->on('socialmediamanagers')
                      ->onDelete('set null');
            }
        });
    }
};
