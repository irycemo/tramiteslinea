<?php

namespace App\Services;

use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PeritosExternosService{

    public function consultarAvaluo(int $año, int $folio, int $usuario):array
    {

        $response = Http::withToken(config('services.peritos_externos.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.peritos_externos.consultar_avaluo'),
                                [
                                    'año' => $año,
                                    'folio' => $folio,
                                    'usuario' => $usuario
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar avalúo. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar avalúo.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

    public function reactivarAvaluo(int $avaluo_id):string
    {

        $response = Http::withToken(config('services.peritos_externos.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.peritos_externos.reactivar_avaluo'),
                                [
                                    'id' => $avaluo_id,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al reactivar avalúo. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al reactivar avalúo.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

    public function generarAvaluoPdf(int $aviso_id):array
    {

        $response = Http::withToken(config('services.peritos_externos.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.peritos_externos.generar_avaluo_pdf'),
                                [
                                    'id' => $aviso_id,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al generar pdf del avalúo. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al generar pdf del avalúo.");

        }else{

            return json_decode($response, true);

        }

    }

}