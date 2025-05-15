<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedBigInteger('uidesigner_id')->nullable()->after('id');
            $table->foreign('uidesigner_id')->references('id')->on('uidesigners')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['uidesigner_id']);
            $table->dropColumn('uidesigner_id');
        });
    }
};
