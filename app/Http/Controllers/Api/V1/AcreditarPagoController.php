<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\GeneralException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AcreditarPagoController extends Controller
{

    public function __invoke(Request $request)
    {

        try {

            $validated = $request->validate(['c_referencia' => 'required']);

            $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.acreditar_pago'),
                                [
                                    'linea_captura' => $validated['c_referencia'],
                                ]
                            );

            if($response->status() !== 200){

                $response = Http::withToken(config('services.sistema_tramites.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_tramites.acreditar_pago'),
                                [
                                    'linea_captura' => $validated['c_referencia'],
                                ]
                            );

            }

            if($response->status() !== 200){

                throw new GeneralException('Error al validar pago en línea.');

            }

            return response()->json([
                'result' => 'success',
            ], 200);

        } catch (GeneralException $ex) {

            Log::error("Error al acreditar pago desde servicio de pago en línea.");

            return response()->json([
                'result' => 'error',
            ], 500);

        } catch (\Throwable $th) {

            Log::error("Error al acreditar pago desde servicio de pago en línea. " . $th);

            return response()->json([
                'result' => 'error',
            ], 500);

        }

    }

}
