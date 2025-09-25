<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\OperarAvisoController;
use App\Http\Controllers\Api\V1\AcreditarPagoController;
use App\Http\Controllers\Api\V1\RechazarAvisoController;
use App\Http\Controllers\Api\V1\AutorizarAvisoController;
use App\Http\Controllers\Api\V1\ConsultarAvisoController;
use App\Http\Controllers\Api\V1\GenerarAvisoPdfController;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('consultar_aviso', [ConsultarAvisoController::class, 'consultarAviso']);

    Route::post('consultar_aviso_con_folio', [ConsultarAvisoController::class, 'consultarAvisoConFolio']);

    Route::post('autorizar_aviso', [AutorizarAvisoController::class, 'autorizarAviso']);

    Route::post('operar_aviso', [OperarAvisoController::class, 'operarAviso']);

    Route::post('rechazar_aviso', [RechazarAvisoController::class, 'rechazarAviso']);

    Route::post('generar_aviso_pdf', [GenerarAvisoPdfController::class, 'generarPdf']);

});


Route::post('acreditar_pago', AcreditarPagoController::class)->name('acredita_pago');