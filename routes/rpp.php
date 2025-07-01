<?php

use App\Livewire\Rpp\MisTramites;
use App\Livewire\Rpp\NuevoTramite;
use Illuminate\Support\Facades\Route;

Route::group([], function(){

    Route::get('tramites_rpp', MisTramites::class)->middleware('permission:Trámites rpp')->name('tramites_rpp');

    Route::get('tramite_nuevo_rpp', NuevoTramite::class)->middleware('permission:Trámite nuevo rpp')->name('tramite_nuevo_rpp');

});