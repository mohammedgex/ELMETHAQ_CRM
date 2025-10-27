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
        Schema::table('orders', function (Blueprint $table) {
            // تحديث حقل status ليكون enum
            $table->string('status')->default('pending')->change();

            // إضافة الحقول الجديدة
            $table->text('status_notes')->nullable()->after('status');
            $table->timestamp('status_updated_at')->nullable()->after('status_notes');
            $table->string('assigned_to')->nullable()->after('status_updated_at');
            $table->integer('priority')->default(1)->after('assigned_to'); // 1=عادي, 2=مهم, 3=عاجل
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['status_notes', 'status_updated_at', 'assigned_to', 'priority']);
        });
    }
};
