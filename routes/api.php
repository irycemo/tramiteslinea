<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\OperarAvisoController;
use App\Http\Controllers\Api\V1\AcreditarPagoController;
use App\Http\Controllers\Api\V1\RechazarAvisoController;
use App\Http\Controllers\Api\V1\AutorizarAvisoController;
use App\Http\Controllers\Api\V1\ConsultarAvisoController;
use App\Http\Controllers\Api\V1\DesvincularAvaluoController;
use App\Http\Controllers\Api\V1\GenerarAvisoPdfController;
use App\Http\Controllers\Api\V1\RevertirAvisoController;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('consultar_avisos', [ConsultarAvisoController::class, 'consultarAvisos']);

    Route::get('consultar_aviso_folio', [ConsultarAvisoController::class, 'consultarAvisoFolio']);

    Route::post('consultar_aviso', [ConsultarAvisoController::class, 'consultarAviso']);

    Route::post('consultar_aviso_con_folio', [ConsultarAvisoController::class, 'consultarAvisoConFolio']);

    Route::post('autorizar_aviso', [AutorizarAvisoController::class, 'autorizarAviso']);

    Route::post('operar_aviso', [OperarAvisoController::class, 'operarAviso']);

    Route::post('rechazar_aviso', [RechazarAvisoController::class, 'rechazarAviso']);

    Route::post('revertir_aviso', [RevertirAvisoController::class, 'revertirAviso']);

    Route::post('revertir_rechazo', [RevertirAvisoController::class, 'revertirRechazo']);

    Route::post('generar_aviso_pdf', [GenerarAvisoPdfController::class, 'generarPdf']);

    Route::post('desvincular_avaluo', [DesvincularAvaluoController::class, 'desvincularAvaluo']);

});


Route::post('acreditar_pago', AcreditarPagoController::class)->name('acredita_pago');