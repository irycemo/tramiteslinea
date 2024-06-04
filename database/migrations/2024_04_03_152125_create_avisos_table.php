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
            $table->unsignedBigInteger('predio_sgc');
            $table->unsignedBigInteger('avaluo_spe')->nullable();
            $table->unsignedBigInteger('certificado_sgc')->nullable();
            $table->unsignedBigInteger('tramite_sgc')->nullable()->unique();
            $table->unsignedInteger('año');
            $table->unsignedInteger('folio');
            $table->unsignedInteger('usuario');
            $table->unsignedInteger('region_catastral');
            $table->unsignedInteger('municipio');
            $table->unsignedInteger('zona_catastral');
            $table->unsignedInteger('localidad');
            $table->unsignedInteger('sector');
            $table->unsignedInteger('manzana');
            $table->unsignedInteger('predio');
            $table->unsignedInteger('edificio');
            $table->unsignedInteger('departamento');
            $table->unsignedInteger('oficina');
            $table->unsignedInteger('tipo_predio');
            $table->unsignedInteger('numero_registro');
            $table->string('estado');
            $table->string('acto');
            $table->date('fecha_ejecutoria')->nullable();
            $table->string('tipo_escritura');
            $table->string('numero_escritura');
            $table->string('volumen_escritura');
            $table->string('lugar_otorgamiento');
            $table->date('fecha_otorgamiento');
            $table->string('lugar_firma');
            $table->date('fecha_firma');
            $table->string('tipo_vialidad')->nullable();
            $table->string('tipo_asentamiento')->nullable();
            $table->string('nombre_vialidad')->nullable();
            $table->string('numero_exterior')->nullable();
            $table->string('numero_exterior_2')->nullable();
            $table->string('numero_adicional')->nullable();
            $table->string('numero_adicional_2')->nullable();
            $table->string('numero_interior')->nullable();
            $table->string('nombre_asentamiento')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->string('lote_fraccionador')->nullable();
            $table->string('manzana_fraccionador')->nullable();
            $table->string('etapa_fraccionador')->nullable();
            $table->text('nombre_predio')->nullable();
            $table->string('nombre_edificio')->nullable();
            $table->string('clave_edificio')->nullable();
            $table->string('departamento_edificio')->nullable();
            $table->decimal('superficie_terreno', 15,4)->nullable();
            $table->decimal('superficie_construccion', 15,4)->nullable();
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
            $table->string('xutm')->nullable();
            $table->string('yutm')->nullable();
            $table->unsignedInteger('zutm')->nullable();
            $table->decimal('lon', 11, 8)->nullable();
            $table->decimal('lat', 11, 8)->nullable();
            $table->foreignId('aviso_original')->nullable()->references('id')->on('avisos');
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
