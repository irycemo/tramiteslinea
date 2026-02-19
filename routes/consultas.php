<?php

use App\Http\Controllers\Preguntas\PreguntasController;
use App\Livewire\Consultas\Gestores\Gestores;
use App\Livewire\Consultas\Preguntas\NuevaPregunta;
use App\Livewire\Consultas\Preguntas\Preguntas;
use Illuminate\Support\Facades\Route;

Route::group([], function(){

    Route::get('preguntas_frecuentes', Preguntas::class)->middleware('permission:Preguntas')->name('preguntas_frecuentes');

    Route::get('nueva_pregunta/{pregunta?}', NuevaPregunta::class)->middleware('permission:Preguntas')->name('nueva_pregunta');

    Route::post('image-upload', [PreguntasController::class, 'storeImage'])->name('ckImage');

    Route::get('gestores', Gestores::class)->middleware('permission:Preguntas')->name('gestores');

});
