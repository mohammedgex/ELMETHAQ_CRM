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
        Schema::create('visa_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('count');
            $table->string('outgoing_number');
            $table->string('registration_number');
            $table->text('porpose');
            $table->string('visa_peroid');
            $table->foreignId('sponser_id')->constrained('sponsers')->onDelete('cascade');
            $table->foreignId('embassy_id')->constrained('embassies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_types');
    }
};
