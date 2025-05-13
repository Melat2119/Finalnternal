<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('feedback')) {
            Schema::table('feedback', function (Blueprint $table) {
                if (!Schema::hasColumn('feedback', 'sale_id')) {
                    $table->unsignedBigInteger('sale_id')->nullable()->after('developer_id');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('feedback')) {
            Schema::table('feedback', function (Blueprint $table) {
                if (Schema::hasColumn('feedback', 'sale_id')) {
                    $table->dropColumn('sale_id');
                }
            });
        }
    }
};
