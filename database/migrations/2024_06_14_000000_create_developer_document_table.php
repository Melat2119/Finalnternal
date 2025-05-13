<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('developer_document', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('developer_id');
            $table->unsignedBigInteger('document_id');
            $table->timestamps();

            $table->foreign('developer_id')->references('id')->on('developers')->onDelete('cascade');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->unique(['developer_id', 'document_id']);
        });

        // Ensure storage link exists for file downloads
        // You must run this command in your terminal:
        // php artisan storage:link
    }

    public function down()
    {
        Schema::dropIfExists('developer_document');
    }
};
