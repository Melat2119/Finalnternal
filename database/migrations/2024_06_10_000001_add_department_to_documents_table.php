<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Schema::table('documents', function (Blueprint $table) {
        //     $table->string('department')->nullable();
        // });
        // The department column already exists, so nothing to do here.
    }

    public function down()
    {
        // Schema::table('documents', function (Blueprint $table) {
        //     $table->dropColumn('department');
        // });
        // No need to drop the column since it was not added here.
    }
};
