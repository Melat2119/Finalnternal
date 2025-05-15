<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedBigInteger('socialmediamanager_id')->nullable()->after('uidesigner_id');
            $table->foreign('socialmediamanager_id')->references('id')->on('socialmediamanagers')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['socialmediamanager_id']);
            $table->dropColumn('socialmediamanager_id');
        });
    }
};
