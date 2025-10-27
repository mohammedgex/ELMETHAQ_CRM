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
            if (!Schema::hasColumn('orders', 'type')) {
                $table->string('type')->nullable();
            }
            if (!Schema::hasColumn('orders', 'name')) {
                $table->string('name')->nullable();
            }
            if (!Schema::hasColumn('orders', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('orders', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('orders', 'details')) {
                $table->json('details')->nullable();
            }
            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('جديد');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('orders', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('orders', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('orders', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('orders', 'details')) {
                $table->dropColumn('details');
            }
            if (Schema::hasColumn('orders', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
