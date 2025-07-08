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
        Schema::create('leads_customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('image');
            $table->string('governorate')->nullable();
            $table->string('phone')->unique();
            $table->string('phone_two')->unique()->nullable();
            $table->foreignId('job_title_id')->constrained('job_titles')->onDelete('cascade');
            $table->string('have_you_ever_traveled_before?')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('passport_photo')->nullable();
            $table->string('passport_numder')->nullable();
            $table->string('img_national_id_card')->nullable();
            $table->string('img_national_id_card_back')->nullable();
            $table->string('license_photo')->nullable();
            $table->string('age')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('card_id')->nullable();
            $table->string('evaluation')->nullable();
            $table->string('licence_type')->nullable();
            $table->string('status')->nullable();
            $table->string('test_type')->nullable();
            $table->string('fcm_token')->nullable();
            $table->date('registration_date')->nullable();
            $table->foreignId('delegate_id')->nullable()->constrained('delegates')->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads_customers');
    }
};
