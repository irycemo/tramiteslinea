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
        Schema::create('observacions', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->text('observacion');
            $table->string('tipo_tramite')->nullable();
            $table->unsignedInteger('tramite_sgc')->nullable();
            $table->unsignedInteger('oficina_sgc')->nullable();
            $table->foreignId('aviso_id')->nullable()->constrained();
            $table->foreignId('entidad_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observacions');
    }
};
