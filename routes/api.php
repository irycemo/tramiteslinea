<?php

use App\Http\Controllers\Api\V1\AvisoApiController;
use App\Http\Controllers\Api\V1\ObservacionApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('consultar_aviso', [AvisoApiController::class, 'consultarAviso']);

    Route::get('rechazar_aviso', [AvisoApiController::class, 'rechazarAviso']);

    Route::get('autorizar_aviso', [AvisoApiController::class, 'autorizarAviso']);

    Route::get('operar_aviso', [AvisoApiController::class, 'operarAviso']);

    Route::post('crear_observacion', [ObservacionApiController::class, 'crearObservacion']);

});
