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
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('predio_sgc')->index();
            $table->unsignedBigInteger('avaluo_spe')->nullable()->index();
            $table->unsignedBigInteger('certificado_sgc')->nullable()->index();
            $table->unsignedBigInteger('tramite_sgc')->nullable()->index();
            $table->unsignedBigInteger('traslado_sgc')->nullable()->index();
            $table->string('estado')->index();
            $table->string('tipo')->nullable();
            $table->unsignedInteger('año');
            $table->unsignedInteger('folio');
            $table->unsignedInteger('usuario');
            $table->string('acto')->nullable();
            $table->date('fecha_ejecutoria')->nullable();
            $table->string('tipo_escritura')->nullable();
            $table->string('numero_escritura')->nullable();
            $table->string('volumen_escritura')->nullable();
            $table->string('lugar_otorgamiento')->nullable();
            $table->date('fecha_otorgamiento')->nullable();
            $table->string('lugar_firma')->nullable();
            $table->date('fecha_firma')->nullable();
            $table->string('cantidad_tramitada')->nullable();
            $table->text('descripcion_fideicomiso')->nullable();
            $table->text('observaciones')->nullable();
            $table->decimal('valor_adquisicion', 15,4)->nullable();
            $table->decimal('valor_catastral', 15,4)->nullable();
            $table->string('uso_de_predio')->nullable();
            $table->date('fecha_reduccion')->nullable();
            $table->decimal('valor_construccion_vivienda', 15,4)->nullable();
            $table->decimal('valor_construccion_otro', 15,4)->nullable();
            $table->decimal('porcentaje_adquisicion', 15,4)->nullable();
            $table->decimal('reduccion', 15,4)->nullable();
            $table->decimal('base_gravable', 15,4)->nullable();
            $table->boolean('sin_reduccion')->default(0);
            $table->boolean('no_genera_isai')->default(0);
            $table->decimal('valor_base', 15,4)->nullable();
            $table->decimal('valor_isai', 15,4)->nullable();
            $table->text('anexos')->nullable();
            $table->foreignId('predio_id')->nullOnDelete();
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->unique(['año', 'folio', 'usuario']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avisos');
    }
};
