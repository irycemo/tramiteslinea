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
        Schema::create('aviso_preventivos', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->unsignedInteger('tramite_id');
            $table->unsignedInteger('tramite_año');
            $table->unsignedInteger('tramite_folio');
            $table->unsignedInteger('tramite_usuario');
            $table->unsignedInteger('folio_real');
            $table->unsignedInteger('movimiento_registral_id')->nullable();
            $table->mediumText('descripcion_acto');
            $table->foreignId('entidad_id')->constrained();
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
        Schema::dropIfExists('aviso_preventivos');
    }
};
