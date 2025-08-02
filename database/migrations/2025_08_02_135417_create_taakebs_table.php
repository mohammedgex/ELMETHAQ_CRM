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
        Schema::create('taakebs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained("companies")->onDelete('set null');
            $table->foreignId('lead_id')
                ->nullable()
                ->constrained('leads_customers')
                ->onDelete('set null');
            $table->string('visa_image')->nullable();       // صورة التأشيرة (path)
            $table->string('issued_number');                // الرقم الصادر
            $table->string('sponsor_id_number');            // رقم السجل
            $table->string('sponsor_name');                 // اسم الكفيل
            $table->string('sponsor_address');              // عنوان الكفيل
            $table->string('sponsor_phone');                // هاتف الكفيل
            $table->string('consulate');                    // القنصلية
            $table->string('purpose');                      // الغرض
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // حالة التعقيب
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taakebs');
    }
};
