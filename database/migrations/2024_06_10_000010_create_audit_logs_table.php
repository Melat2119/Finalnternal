<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user')->nullable();
            $table->string('action');
            $table->text('description')->nullable();
            $table->timestamp('timestamp')->useCurrent();
            $table->string('ip_address')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_logs');
    }
};
