<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('document_socialmediamanager', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('socialmediamanager_id');
            $table->timestamps();

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('socialmediamanager_id')->references('id')->on('socialmediamanagers')->onDelete('cascade');
            // Use a shorter index name to avoid MySQL identifier length error
            $table->unique(['document_id', 'socialmediamanager_id'], 'doc_smgr_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_socialmediamanager');
    }
};
