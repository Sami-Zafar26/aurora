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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('campaign_name', 255);
            $table->boolean('is_active')->default(0);
            $table->enum('status', ['pending', 'sending', 'sent', 'error'])->default('pending');
            $table->string('token')->nullable();
            $table->dateTime('utc_time');
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->foreignId('timezone_id')->nullable()->constrained('timezones');
            $table->foreignId('csv_list_id')->constrained('csv_lists');
            $table->foreignId('integration_credential_id')->constrained('integration_credentials');
            $table->foreignId('campaign_template_id')->constrained('campaign_templates');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps(); // This will create the default created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
