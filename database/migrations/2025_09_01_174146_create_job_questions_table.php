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
        Schema::create('job_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_title_id')->constrained()->onDelete('cascade');
            $table->string('question');
            $table->string('show_in_report')->default('no'); // yes or no
            $table->enum('type', [
                'text',
                'textarea',
                'select',
                'radio',
                'checkbox',
                'date',
                'number'
            ])->default('text');
            $table->json('options')->nullable(); // لو نوع select نضيف الاختيارات هنا
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_questions');
    }
};
