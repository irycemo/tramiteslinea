<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Http;

class SGCService {

    public function consultarPredio(int $localidad, int $oficina, int $tipo_predio, int $numero_registro):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.consultar_predio'),
                                [
                                    'localidad' => $localidad,
                                    'oficina' => $oficina,
                                    'tipo_predio' => $tipo_predio,
                                    'numero_registro' => $numero_registro,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar predio. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar predio.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

    public function consultarCuentaPredial(int $localidad, int $oficina, int $tipo_predio, int $numero_registro):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.consultar_cuenta_predial'),
                                [
                                    'localidad' => $localidad,
                                    'oficina' => $oficina,
                                    'tipo_predio' => $tipo_predio,
                                    'numero_registro' => $numero_registro,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar cuenta predial. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar cuenta predial.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

    public function consultarPropietarios(int $año, int $folio, int $usuario, int $sgc_predio):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.consultar_propietarios'),
                                [
                                    'año' => $año,
                                    'folio' => $folio,
                                    'usuario' => $usuario,
                                    'predio' => $sgc_predio
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar propietarios. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar propietarios.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

    public function consultarTramieAviso(int $año, int $folio, int $usuario, int $sgc_predio):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.consultar_tramite_aviso'),
                                [
                                    'año' => $año,
                                    'folio' => $folio,
                                    'usuario' => $usuario,
                                    'predio' => $sgc_predio
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar trámite de aviso. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar trámite de aviso.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

    public function consultarCertificadoAviso(int $año, int $folio, int $usuario, int $sgc_predio):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.consultar_certificado_aviso'),
                                [
                                    'año' => $año,
                                    'folio' => $folio,
                                    'usuario' => $usuario,
                                    'predio' => $sgc_predio
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar certificado catastral. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar certificado catastral.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

    public function ingresarAvisoAclaratorio(int $predio_id, int $tramite_id, int $certificado_id, int $avaluo_id, int $aviso_id, int $entidad_id, string $entidad_nombre):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.ingresar_aviso_aclaratorio'),
                                [
                                    'predio_id' => $predio_id,
                                    'tramite_aviso' => $tramite_id,
                                    'certificacion_id' => $certificado_id,
                                    'avaluo_spe' => $avaluo_id,
                                    'aviso_stl' => $aviso_id,
                                    'entidad_stl' => $entidad_id,
                                    'entidad_nombre' => $entidad_nombre,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al ingresar aviso aclaratorio. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al ingresar aviso aclaratorio.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

    public function ingresarRevisionAviso(int $predio_id, int $tramite_id, int $aviso_id, int $entidad_id, string $entidad_nombre):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.ingresar_revision_aviso'),
                                [
                                    'predio_id' => $predio_id,
                                    'tramite_aviso' => $tramite_id,
                                    'aviso_stl' => $aviso_id,
                                    'entidad_stl' => $entidad_id,
                                    'entidad_nombre' => $entidad_nombre,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al ingresar revision de aviso. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al ingresar revision de aviso.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

    public function inactivarTraslado(int $traslado_sgc):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.inactivarTraslado'),
                                [
                                    'id' => $traslado_sgc,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al inactivar traslado. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al inactivar traslado.");

        }else{

            return json_decode($response, true)['data'];

        }

    }

    public function consultarRechazos(int $traslado_sgc):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.consultar_rechazos'),
                                [
                                    'id' => $traslado_sgc,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar rechazos. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar rechazos.");

        }else{

            return json_decode($response, true);

        }

    }

    public function consultarServicios(array $claves_ingreso):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.consultar_servicios'),
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

    public function crearTramite(string $tipo_servicio, int $servicio_id, string $solicitante, string $nombre_solicitante, int $monto, int $cantidad, int $usuario_tramites_linea_id, array $predios):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.crear_tramite'),
                                [
                                    'tipo_servicio' => $tipo_servicio,
                                    'servicio_id' => $servicio_id,
                                    'solicitante' => $solicitante,
                                    'nombre_solicitante' => $nombre_solicitante,
                                    'monto' => $monto,
                                    'cantidad' => $cantidad,
                                    'usuario_tramites_linea_id' => $usuario_tramites_linea_id,
                                    'predios' => $predios
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

    public function consultarTramites(int $entidad_id, string | null $estado, int | null $año, int |null $folio, string | null $tipo_servicio, string | null $servicio, int $pagina_actual, int $pagination):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.consultar_tramites'),
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

    public function consultarCertificados(int $entidad_id, int | null $año, int |null $folio, string | null $estado, string | null $localidad, string | null $oficina, string | null $tipo_predio, string | null $numero_registro, int $pagina_actual, int $pagination):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.consultar_certificados'),
                                [
                                    'entidad' => $entidad_id,
                                    'año' => $año,
                                    'folio' => $folio,
                                    'estado' => $estado,
                                    'localidad' => $localidad,
                                    'oficina' => $oficina,
                                    'tipo_predio' => $tipo_predio,
                                    'numero_registro' => $numero_registro,
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

    public function crearRequerimiento(string $observacion, string | null $file, int $certificacion_id, string $name):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.crear_requerimiento'),
                                [
                                    'observacion' => $observacion,
                                    'file' => $file,
                                    'certificacion_id' => $certificacion_id,
                                    'usuario' => $name,
                                    'archivo_url' => $file
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al crear requerimiento. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al crear requerimiento.");

        }else{

            return json_decode($response, true);

        }

    }

    public function generarCertificadoPdf(int $certificacion_id):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.generar_certificado_pdf'),
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

}