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
        Schema::create('predios', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('estado');
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
            $table->string('uso_1')->nullable();
            $table->string('uso_2')->nullable();
            $table->string('uso_3')->nullable();
            $table->string('ubicacion_en_manzana')->nullable();
            $table->decimal('superficie_terreno', 15,4 )->nullable();
            $table->decimal('superficie_construccion', 15,4 )->nullable();
            $table->decimal('superficie_judicial', 15,4 )->nullable();
            $table->decimal('superficie_notarial', 15,4 )->nullable();
            $table->decimal('area_comun_terreno', 15,4)->nullable();
            $table->decimal('area_comun_construccion', 15,4)->nullable();
            $table->decimal('valor_terreno_comun', 15,4)->nullable();
            $table->decimal('valor_construccion_comun', 15,4)->nullable();
            $table->decimal('valor_total_terreno', 15,4 )->nullable();
            $table->decimal('valor_total_construccion', 15,4 )->nullable();
            $table->decimal('valor_catastral', 15,4 )->nullable();
            $table->string('xutm')->nullable();
            $table->string('yutm')->nullable();
            $table->unsignedInteger('zutm')->nullable();
            $table->decimal('lon', 11, 8)->nullable();
            $table->decimal('lat', 11, 8)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predios');
    }
};
