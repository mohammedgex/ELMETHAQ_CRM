<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // الاسم بالعربي
            $table->string('national_id', 14)->nullable()->unique(); // الرقم القومي
            $table->string('job_title')->nullable(); // الوظيفة
            $table->string('phone', 15); // رقم الهاتف
            $table->string('personal_photo')->nullable(); // الصورة الشخصية
            $table->string('id_card_photo')->nullable(); // صورة البطاقة
            $table->text('message')->nullable(); // ملاحظات
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
