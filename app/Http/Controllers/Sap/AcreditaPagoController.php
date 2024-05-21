<?php

namespace App\Http\Controllers\Sap;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class AcreditaPagoController extends Controller
{

    public function __invoke(Request $request)
    {

        /* info($request); */
        /* $validated = $request->validate([
            'linea_de_captura' => 'required',
        ]); */

        $validated['linea_de_captura'] = $request['c_referencia'];

        try {

            $response = Http::withToken(env('SISTEMA_TRAMITES_TOKEN'))
                                ->accept('application/json')
                                ->post(env('SISTEMA_TRAMITES_ACREDITAR_TRAMITE'), ['linea_de_captura' => $validated['linea_de_captura']]);

            $data_st = json_decode($response, true);

            info($response );

            info($data_st );

            if($response->status() === 200){

                return view('sap.acreditaPago')->with(['status' => 'success', 'data' => $data_st]);

            }elseif($response->status() === 404){

                $response = Http::withToken(env('SGC_ACCESS_TOKEN'))
                                ->accept('application/json')
                                ->post(env('SGC_ACREDITA_TRAMITE'), ['linea_de_captura' => $validated['linea_de_captura']]);

                $data_sgc = json_decode($response, true);

                info($response );

                info($data_sgc );

                if($response->status() === 200){

                    return view('sap.acreditaPago')->with(['status' => 'success', 'data' => $data_sgc]);

                }elseif($response->status() === 404){

                    return view('sap.acreditaPago')->with(['status' => 'error', 'mensaje' => $data_sgc['error']]);

                }else{

                    return view('sap.acreditaPago')->with(['status' => 'error', 'mensaje' => $data_sgc['error']]);

                }

            }else{

                info($response );

                info($data_st );

                return view('sap.acreditaPago')->with(['status' => 'error', 'mensaje' => $data_st['error']]);

            }

        } catch (ConnectionException $th) {

            Log::error("Error al acreditar pago en línea: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            abort(500, message:"Ha ocurrido un error en el sistema comuniquese con el departamento de operaciones y desarrollo de sistemas.");

        }

    }

}
