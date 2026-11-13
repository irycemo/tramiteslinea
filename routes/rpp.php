<?php

use App\Livewire\Rpp\AvisosPreventivos\AvisosPreventivos;
use Illuminate\Support\Facades\Route;
use App\Livewire\Rpp\Tramites\Ventanilla\NuevoTramite;
use App\Livewire\Rpp\Tramites\MisTramites;
use App\Livewire\Rpp\Certificados\Certificados;

Route::group([], function(){

    Route::get('tramites_rpp', MisTramites::class)->middleware('permission:Trámites rpp')->name('tramites_rpp');

    Route::get('tramite_nuevo_rpp', NuevoTramite::class)->middleware('permission:Trámite nuevo rpp')->name('tramite_nuevo_rpp');

    Route::get('certificados_rpp', Certificados::class)->middleware('permission:Certificados rpp')->name('certificados_rpp');

    Route::get('avisos_preventivos', AvisosPreventivos::class)->middleware('permission:Avisos preventivos')->name('avisos_preventivos');

});
