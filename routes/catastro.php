<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Catastro\Tramites\MisTramites;
use App\Livewire\Catastro\Tramites\Certificados;
use App\Livewire\Catastro\Tramites\NuevoTramite;
use App\Livewire\Catastro\Avisos\AvisoAclaratorio\Avisos;
use App\Livewire\Catastro\Avisos\RevisionAviso\Revisiones;
use App\Livewire\Catastro\Avisos\AvisoAclaratorio\NuevoAviso;
use App\Livewire\Catastro\Avisos\RevisionAviso\NuevaRevision;
use App\Livewire\Comun\CalculadoraIsai;

Route::group([], function(){

    Route::get('aviso/{aviso?}', NuevoAviso::class)->middleware('permission:Nuevo aviso')->name('aviso');

    Route::get('revision/{aviso?}', NuevaRevision::class)->middleware('permission:Nueva revisión')->name('revision');

    Route::get('mis_avisos', Avisos::class)->middleware('permission:Mis avisos')->name('mis_avisos');

    Route::get('mis_revisiones', Revisiones::class)->middleware('permission:Mis revisiones')->name('mis_revisiones');

    Route::get('tramites_catastro', MisTramites::class)->middleware('permission:Trámites catastro')->name('tramites_catastro');

    Route::get('tramite_nuevo_catastro', NuevoTramite::class)->middleware('permission:Trámite nuevo catastro')->name('tramite_nuevo_catastro');

    Route::get('certificados_catastro', Certificados::class)->middleware('permission:Certificados catastro')->name('certificados_catastro');

    Route::get('calculadora_isai', CalculadoraIsai::class)->middleware('permission:Certificados')->name('calculadora_isai');

});