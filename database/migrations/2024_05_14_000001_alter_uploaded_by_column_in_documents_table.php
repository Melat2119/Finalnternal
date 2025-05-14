<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('uploaded_by')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->integer('uploaded_by')->nullable()->change();
        });
    }
};
