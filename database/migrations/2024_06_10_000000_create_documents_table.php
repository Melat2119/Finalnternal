<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('department', 100)->nullable();
            $table->string('type', 100)->nullable();
            $table->string('file_path', 255)->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->text('approval_comment')->nullable();
            $table->timestamps();

            // Foreign keys (optional, remove if not needed)
            // $table->foreign('uploaded_by')->references('id')->on('users')->nullOnDelete();
            // $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
