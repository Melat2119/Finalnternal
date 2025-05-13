<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales_documents', function (Blueprint $table) {
            if (!Schema::hasColumn('sales_documents', 'file_url')) {
                $table->string('file_url')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('sales_documents', function (Blueprint $table) {
            if (Schema::hasColumn('sales_documents', 'file_url')) {
                $table->dropColumn('file_url');
            }
        });
    }
};
