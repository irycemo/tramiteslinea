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
        Schema::create('antecedentes', function (Blueprint $table) {
            $table->id();
            $table->string('folio_real')->nullable();
            $table->string('movimiento_registral')->nullable();
            $table->string('tomo')->nullable();
            $table->string('registro')->nullable();
            $table->string('seccion')->nullable();
            $table->string('distrito')->nullable();
            $table->text('acto');
            $table->foreignId('aviso_id')->constrained()->onDelete('cascade');
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antecedentes');
    }
};
