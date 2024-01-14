<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('csv_lists', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->nullable();
            $table->string('list_name');
            $table->text('list_description')->nullable();
            $table->enum('status',['pending','processing','completed','error'])->default('pending');
            $table->string('error_message')->nullable();
            $table->string('list_location')->nullable();
            $table->string('token')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->string('processing_started_at')->nullable();
            $table->string('processing_completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('csv_lists');
    }
};
