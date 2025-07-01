<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Catastro\Avisos\Avisos;
use App\Livewire\Catastro\Avisos\Revsiones;
use App\Livewire\Catastro\Avisos\NuevoAviso;
use App\Livewire\Catastro\Avisos\NuevaRevision;
use App\Livewire\Catastro\Tramites\MisTramites;
use App\Livewire\Catastro\Tramites\Certificados;
use App\Livewire\Catastro\Tramites\NuevoTramite;

Route::group([], function(){

    Route::get('aviso/{aviso?}', NuevoAviso::class)->middleware('permission:Nuevo aviso')->name('aviso');

    Route::get('revision/{aviso?}', NuevaRevision::class)->middleware('permission:Nueva revisión')->name('revision');

    Route::get('mis_avisos', Avisos::class)->middleware('permission:Mis avisos')->name('mis_avisos');

    Route::get('mis_revisiones', Revsiones::class)->middleware('permission:Mis revisiones')->name('mis_revisiones');

    Route::get('tramites_catastro', MisTramites::class)->middleware('permission:Trámites catastro')->name('tramites_catastro');

    Route::get('tramite_nuevo_catastro', NuevoTramite::class)->middleware('permission:Trámite nuevo catastro')->name('tramite_nuevo_catastro');

    Route::get('certificados', Certificados::class)->middleware('permission:Certificados')->name('certificados');

});