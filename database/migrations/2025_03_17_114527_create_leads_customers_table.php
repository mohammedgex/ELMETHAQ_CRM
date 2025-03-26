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
            $table->string('name');
            $table->string('image');
            $table->string('passport_photo');
            $table->string('img_national_id_card');
            $table->string('license_photo');
            $table->string('age');
            $table->string('card_id');
            $table->string('governorate');
            $table->string('evaluation');
            $table->string('phone');
            $table->string('licence_type');
            $table->string('status');
            $table->string('test_type');
            $table->date('registration_date');
            $table->foreignId('job_title_id')->constrained('job_titles')->onDelete('cascade');
            $table->foreignId('delegate_id')->constrained('delegates')->onDelete('cascade');
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
