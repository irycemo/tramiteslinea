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
        Schema::create('terreno_comuns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('predio_id')->constrained()->cascadeOnDelete();
            $table->decimal('area_terreno_comun', 15,4);
            $table->decimal('indiviso_terreno', 15,4);
            $table->decimal('valor_unitario', 15,4);
            $table->decimal('superficie_proporcional', 15,4);
            $table->decimal('valor_terreno_comun', 15,4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terreno_comuns');
    }
};
