<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\AcreditarPagoRequest;

class AcreditarPagoController extends Controller
{

    public function __invoke(Request $request)
    {

        Log::info('Request received', [
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'ip_f' => $request->header('X-Forwarded-For'),
            'ipAddresses' => $request->ips(),
            'user_agent' => $request->header('User-Agent'),
            'parameters' =>  $request->all()
        ]);

        $validated = $request->validated();

        info(($validated));

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

                    Log::warning("Error al acreditar pago, línea de captura: " . $validated['referencia']);

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
