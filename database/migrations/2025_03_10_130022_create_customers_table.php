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
            $table->string('passport_id');
            $table->string(column: 'card_id');
            $table->string('name_ar');
            $table->string(column: 'phone');
            $table->text('mrz')->nullable();
            $table->text(column: 'phone_two')->nullable();
            $table->date('date_birth')->nullable();
            $table->enum('nationality', ['مصري'])->nullable();
            $table->string('name_en_mrz')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->enum('marital_status', ['اعزب', 'متزوج'])->nullable();
            $table->string(column: 'license_id')->nullable();
            $table->boolean('travel_before')->nullable();
            $table->enum('education', ['محو امية', 'مؤهل عالي', 'مؤهل متوسط', 'فوق متوسط', 'اعدادي', 'ثانوي'])->nullable();
            $table->string(column: 'visa_id')->nullable();
            $table->text('notes')->nullable();
            $table->string('visa_number')->nullable();
            $table->enum('governorate', ['القاهرة', 'الجيزة', 'الإسكندرية', 'الدقهلية', 'البحر الأحمر', 'البحيرة', 'الفيوم', 'الغربية', 'الإسماعيلية', 'المنوفية', 'المنيا', 'القليوبية', 'الوادي الجديد', 'السويس', 'أسوان', 'أسيوط', 'بني سويف', 'بورسعيد', 'دمياط', 'الشرقية', 'جنوب سيناء', 'كفر الشيخ', 'مطروح', 'الأقصر', 'قنا', 'شمال سيناء', 'سوهاج'])->nullable();
            $table->integer('age')->nullable();
            $table->foreignId('delegate_id')->constrained('delegates')->onDelete('cascade');
            $table->foreignId(column: 'visa_type_id')->constrained('visa_types')->onDelete('cascade');
            $table->foreignId('customer_group_id')->constrained('customer_groups')->onDelete('cascade');
            $table->foreignId(column: 'sponser_id')->constrained('sponsers')->onDelete('cascade');
            $table->foreignId('evalution_id')->constrained('evalutions')->onDelete('cascade');
            $table->foreignId('embassy_id')->constrained(table: 'embassies')->onDelete('cascade');
            $table->foreignId('job_title_id')->constrained(table: 'job_titles')->onDelete('cascade');
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
