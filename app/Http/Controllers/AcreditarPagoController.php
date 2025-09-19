<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class AcreditarPagoController extends Controller
{

    public function __invoke(Request $request)
    {

        info($request);

        $validated['linea_de_captura'] = $request['c_referencia'];

        try {

            $response = Http::withToken(env('SISTEMA_TRAMITES_TOKEN'))
                                ->accept('application/json')
                                ->post(env('SISTEMA_TRAMITES_ACREDITAR_TRAMITE'), ['linea_de_captura' => $validated['linea_de_captura']]);

            $data_st = json_decode($response, true);

            if($response->status() === 200){

                return view('sap.acreditaPago')->with(['status' => 'success', 'data' => $data_st['data']]);

            }elseif($response->status() === 404){

                $response = Http::withToken(env('SGC_ACCESS_TOKEN'))
                                ->accept('application/json')
                                ->post(env('SGC_ACREDITA_TRAMITE'), ['linea_de_captura' => $validated['linea_de_captura']]);

                $data_sgc = json_decode($response, true);

                if($response->status() === 200){

                    return view('sap.acreditaPago')->with(['status' => 'success', 'data' => $data_sgc['data']]);

                }elseif($response->status() === 404){

                    return view('sap.acreditaPago')->with(['status' => 'error', 'data' => $data_sgc['error']]);

                }else{

                    return view('sap.acreditaPago')->with(['status' => 'error', 'data' => $data_sgc['error']]);

                }

            }else{

                return view('sap.acreditaPago')->with(['status' => 'error', 'data' => $data_st['error']]);

            }

        } catch (ConnectionException $th) {

            Log::error("Error al acreditar pago en línea: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            abort(500, message:"Ha ocurrido un error comuníquese con el departamento de operaciones y desarrollo de sistemas.");

        }

    }

}
