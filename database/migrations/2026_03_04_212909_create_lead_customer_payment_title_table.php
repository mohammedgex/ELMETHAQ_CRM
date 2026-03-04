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
        Schema::create('lead_customer_payment_title', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lead_customer_id')->constrained('leads_customers')->cascadeOnDelete();
            $table->foreignId('payment_title_id')->constrained('payment_titles')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_customer_payment_title');
    }
};
