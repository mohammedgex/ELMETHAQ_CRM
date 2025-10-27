<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::create('translation_requests', function (Blueprint $table) {
      $table->id();
      $table->string('fullname');
      $table->string('country_code1');
      $table->string('mobile');
      $table->string('whatsapp')->nullable();
      $table->string('email')->nullable();
      $table->string('address');
      $table->string('city');
      $table->string('call_time')->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('translation_requests');
  }
};
