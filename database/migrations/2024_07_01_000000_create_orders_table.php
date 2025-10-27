<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->string('type'); // نوع الطلب: طيران، فنادق، ...
      $table->string('name'); // اسم العميل
      $table->string('phone')->nullable();
      $table->string('email')->nullable();
      $table->json('details')->nullable(); // تفاصيل الطلب كاملة
      $table->string('status')->default('جديد'); // حالة الطلب
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('orders');
  }
};
