<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Http;

class STramtiesService {

    public function crearTramite(string $tipo_servicio, int $servicio_id, string $solicitante, string $nombre_solicitante, int $monto, int $usuario_tramites_linea_id, array $predio):array
    {

        $response = Http::withToken(config('services.sistema_tramites.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_tramites.crear_tramite'),
                                [
                                    'tipo_servicio' => $tipo_servicio,
                                    'servicio_id' => $servicio_id,
                                    'solicitante' => $solicitante,
                                    'nombre_solicitante' => $nombre_solicitante,
                                    'monto' => $monto,
                                    'usuario_tramites_linea_id' => $usuario_tramites_linea_id,
                                    'predio' => $predio
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al crear trámite. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al crear trámite.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

    public function consultarServicios(array $claves_ingreso):array
    {

        $response = Http::withToken(config('services.sistema_tramites.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_tramites.consultar_servicios'),
                                [
                                    'claves_ingreso' => $claves_ingreso,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar servicios. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar servicios.");

        }else{

            return json_decode($response, true);

        }

    }

    public function consultarTramites(int $entidad_id, string | null $estado, int | null $año, int |null $folio, string | null $tipo_servicio, string | null $servicio, int $pagina_actual, int $pagination):array
    {

        $response = Http::withToken(config('services.sistema_tramites.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_tramites.consultar_tramites'),
                                [
                                    'entidad' => $entidad_id,
                                    'estado' => $estado,
                                    'año' => $año,
                                    'folio' => $folio,
                                    'tipo_servicio' => $tipo_servicio,
                                    'servicio' => $servicio,
                                    'pagina' => $pagina_actual,
                                    'pagination' => $pagination,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar tramites. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar tramites.");

        }else{

            return json_decode($response, true);

        }

    }

}