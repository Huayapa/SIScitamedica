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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('license_number', 50);
            $table->foreignId('specialty_id')->constrained()->onDelete('cascade');
            $table->string('email', 150)->unique();
            $table->string('phone', 20);
            $table->string('office', 50)->nullable();
            $table->string('schedule', 100)->nullable();
            $table->integer('experience_years')->default(0);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
