<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('document_reception', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('reception_id');
            $table->timestamps();

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('reception_id')->references('id')->on('receptions')->onDelete('cascade');
            $table->unique(['document_id', 'reception_id'], 'doc_reception_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_reception');
    }
};
