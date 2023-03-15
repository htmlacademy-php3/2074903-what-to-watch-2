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
        Schema::create('film_genre', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignIdFor(\App\Models\Film::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Genre::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_genre');
    }
};