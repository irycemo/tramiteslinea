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
        Schema::create('construccion_comuns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('predio_id')->constrained()->cascadeOnDelete();
            $table->decimal('area_comun_construccion', 15,4)->nullable();
            $table->decimal('superficie_proporcional', 15,4)->nullable();
            $table->decimal('indiviso_construccion', 15,4)->nullable();
            $table->decimal('valor_clasificacion_construccion', 15,4)->nullable();
            $table->decimal('valor_construccion_comun', 15,4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('construccion_comuns');
    }
};
