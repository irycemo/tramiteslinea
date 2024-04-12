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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 1000);
            $table->string("tipo");
            $table->string("estado")->default('activo');
            $table->decimal("umas", 18,2)->default(0)->nullable();
            $table->decimal("porcentaje", 18,2)->default(0)->nullable();
            $table->decimal("ordinario", 18,2)->nullable();
            $table->decimal("urgente", 18,2)->default(0)->nullable();
            $table->decimal("extra_urgente", 18,2)->default(0)->nullable();
            $table->string('material')->nullable();
            $table->string('clave_ingreso')->nullable();
            $table->string('operacion_principal')->nullable();
            $table->string('operacion_parcial')->nullable();
            $table->string('dependiencia');
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
        Schema::dropIfExists('servicios');
    }
};
