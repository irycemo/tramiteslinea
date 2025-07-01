<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\OperarAvisoController;
use App\Http\Controllers\Api\V1\AcreditarPagoController;
use App\Http\Controllers\Api\V1\RechazarAvisoController;
use App\Http\Controllers\Api\V1\AutorizarAvisoController;
use App\Http\Controllers\Api\V1\ConsultarAvisoController;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('consultar_aviso', [ConsultarAvisoController::class, 'consultarAviso']);

    Route::post('autorizar_aviso', [AutorizarAvisoController::class, 'autorizarAviso']);

    Route::post('operar_aviso', [OperarAvisoController::class, 'operarAviso']);

    Route::post('rechazar_aviso', [RechazarAvisoController::class, 'rechazarAviso']);

});

Route::post('acreditar_pago', AcreditarPagoController::class);