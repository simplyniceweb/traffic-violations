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
        Schema::create('cities_municipalities', function (Blueprint $table) {
            $table->id();
            $table->string('city_code', 10);
            $table->string('city_name');
            $table->string('psgc_code', 10);
            $table->foreignId('province_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities_municipalities');
    }
};
