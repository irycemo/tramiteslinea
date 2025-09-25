<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\AcreditarPagoRequest;
use Illuminate\Support\Facades\Http;

class AcreditarPagoController extends Controller
{

    public function __invoke(AcreditarPagoRequest $request)
    {

        $validated = $request->validated();

        try {

            $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.acreditar_pago'),
                                [
                                    'linea_captura' => $validated['referencia'],
                                ]
                            );

            if($response->status() !== 200){

                $response = Http::withToken(config('services.sistema_tramites.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_tramites.acreditar_pago'),
                                [
                                    'linea_captura' => $validated['referencia'],
                                ]
                            );


                if($response->status() !== 200){

                    Log::info("Error al acreditar pago línea de captura: " . $validated['referencia']);

                    info($response);

                }

            }

            return redirect('login');

        } catch (\Throwable $th) {

            Log::error("Error al acreditar pago desde servicio de pago en línea. " . $th);

            return response()->json([
                'result' => 'error',
            ], 500);

        }

    }

}
