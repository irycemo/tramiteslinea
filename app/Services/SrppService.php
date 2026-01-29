<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Http;

class SrppService {

    public function consultarFolioReal(int|null $folio_real):array
    {

        $response = Http::withToken(config('services.sistema_rpp.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_rpp.consultar_folio_real'),
                                [
                                    'folio_real' => $folio_real,
                                    'tomo' => null,
                                    'registro' => null,
                                    'numero_propiedad' => null,
                                    'distrito' => null,
                                    'seccion' => 'propiedad',
                                ]
                            );

        if($response->status() === 204){

            return [];

        }elseif($response->status() !== 200){

            Log::error("Error al consultar folio real. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar folio real.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

    public function consultarAntecedentes(int $tomo, int $registro, int $distrito):array
    {

        $response = Http::withToken(config('services.sistema_rpp.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_rpp.consultar_antecedentes'),
                                [
                                    'tomo' => $tomo,
                                    'registro' => $registro,
                                    'distrito' => $distrito,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar antecedentes. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar antecedentes.");

        }else{

            return json_decode($response, true)['antecedentes'];

        }

    }

    public function generarCertificadoGravamenPdf(int $certificacion_id):array
    {

        $response = Http::withToken(config('services.sistema_rpp.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_rpp.generar_certificado_gravamen_pdf'),
                                [
                                    'id' => $certificacion_id,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al generar pdf del certificado. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al generar pdf del certificado.");

        }else{

            return json_decode($response, true);

        }

    }

    public function consultarCertificadosGravamen(int $entidad_id, int | null $año, int |null $folio, string | null $estado, int|null $folio_real, int $pagina_actual, int $pagination):array
    {

        $response = Http::withToken(config('services.sistema_rpp.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_rpp.consultar_certificados'),
                                [
                                    'entidad' => $entidad_id,
                                    'año' => $año,
                                    'folio' => $folio,
                                    'estado' => $estado,
                                    'folio_real' => $folio_real,
                                    'pagina' => $pagina_actual,
                                    'pagination' => $pagination,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar certificados. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar certificados.");

        }else{

            return json_decode($response, true);

        }

    }

    public function consultarEstadisticas(int $entidad_id):array
    {

        $response = Http::withToken(config('services.sistema_rpp.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_rpp.consultar_estadisticas'),
                                [
                                    'entidad_id' => $entidad_id,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar estadisticas. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar estadisticas.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

}