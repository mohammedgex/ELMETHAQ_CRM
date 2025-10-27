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
    Schema::create('visa_requests', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('phone');
      $table->string('email');
      $table->string('country');
      $table->string('visa_type');
      $table->date('travel_date');
      $table->string('passport_number');
      $table->date('passport_expiry');
      $table->string('nationality');
      $table->text('message')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('visa_requests');
  }
};
