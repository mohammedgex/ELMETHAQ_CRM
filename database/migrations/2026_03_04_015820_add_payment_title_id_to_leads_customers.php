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
        Schema::table('leads_customers', function (Blueprint $table) {
            //
            $table->foreignId('payment_title_id')
                ->nullable()
                ->after('governorate') // سيظهر بعد عمود المحافظة
                ->constrained('payment_titles') // اسم الجدول المراد الربط معه
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads_customers', function (Blueprint $table) {
            //
        });
    }
};
