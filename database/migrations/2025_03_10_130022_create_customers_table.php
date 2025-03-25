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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('name_ar');
            $table->string('card_id');
            $table->string('phone');
            $table->string('governorate')->nullable();
            $table->string('governorate_live')->nullable();
            $table->integer('age')->nullable();
            $table->string('status')->nullable();
            $table->string('license_type')->nullable();
            $table->date('license_expire_date')->nullable();
            $table->string('license_status')->nullable();;
            $table->string('phone_two')->nullable();
            $table->string('e_visa_number')->nullable();
            $table->string('medical_examination')->nullable();
            $table->string('finger_print_examination')->nullable();
            $table->string('virus_examination')->nullable();
            $table->string('engaz_request')->nullable();
            $table->string('nationality')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('education')->nullable();
            $table->text('notes')->nullable();
            $table->text('mrz')->nullable();
            $table->string('name_en_mrz')->nullable();
            $table->string('passport_id')->nullable();
            $table->date('date_birth')->nullable();
            $table->date('passport_expire_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('issue_place')->nullable();
            $table->boolean('travel_before')->nullable();
            $table->foreignId('delegate_id')->nullable()->constrained('delegates')->onDelete('cascade');
            $table->foreignId('job_title_id')->nullable()->constrained('job_titles')->onDelete('cascade');
            $table->foreignId('customer_group_id')->nullable()->constrained('customer_groups')->onDelete('cascade');
            $table->foreignId('sponser_id')->nullable()->constrained('sponsers')->onDelete('cascade');
            $table->foreignId('visa_type_id')->nullable()->constrained('visa_types')->onDelete('cascade');
            $table->foreignId('evalution_id')->nullable()->constrained('evaluations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
