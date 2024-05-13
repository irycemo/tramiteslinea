<?php

namespace App\Livewire\Usuarios\Tramites;

use Livewire\Component;
use Illuminate\Support\Arr;
use App\Constantes\Constantes;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class Certificados extends Component
{

    public $estados;
    public $estado;
    public $años;
    public $folio;
    public $tipo_servicio;
    public $año;
    public $paginaActual = 1;
    public $paginaAnterior;
    public $paginaSiguiente;
    public $pagination = 10;

    public $modal = false;

    public $tramiteSeleccionado;

    public $certificacion;

    public function nextPage(){ (int)$this->paginaActual++; $this->dispatch('gotoTop'); }

    public function previousPage(){ (int)$this->paginaActual--; $this->dispatch('gotoTop'); }

    public function abrirModalVer($tramite){

        $this->modal = true;

        $this->tramiteSeleccionado =  $tramite;

    }

    public function generarCertificado($id){


        if(auth()->user()->entidad->numero_notaria)
            $nombre_entidad = 'Notaria ' . auth()->user()->entidad->numero_notaria;
        else
            $nombre_entidad = auth()->user()->entidad->dependencia;

        try {

            $response = Http::acceptJson()
                            ->withToken(env('SGC_ACCESS_TOKEN'))
                            ->withQueryParameters([
                                'entidad' => auth()->user()->entidad_id,
                                'nombre_entidad' => $nombre_entidad,
                                'año' => $this->tramiteSeleccionado['año'],
                                'folio' => $this->tramiteSeleccionado['folio'],
                                'predio' => $id
                            ])
                            ->post(env('SGC_GENERAR_CERTIFICADO'));

        } catch (\Throwable $th) {
            abort(500, message:"Ha ocurrido un error en el sistema comuniquese con el departamento de operaciones y desarrollo de sistemas.");
        }

        $data = json_decode($response, true);

        if($response->status() === 200){

            $this->certificacion = $data['data'];

            $pdf = $this->generarPdf();

            $pdf->render();

            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->get_canvas();

            $canvas->page_text(480, 794, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

            $pdf = $dom_pdf->output();

            return response()->streamDownload(
                fn () => print($pdf),
                'certificacion.pdf'
            );

        }elseif($response->status() === 404){

            $this->dispatch('mostrarMensaje', ['warning', $data['error']]);

        }else{

            dd($data);

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

    public function generarPdf(){

        if($this->certificacion['documento'] == 'CERTIFICADO DE HISTORIA CATASTRAL'){

            return $pdf = $this->certificadoHistoria($this->certificadoHistoriaPartes($this->certificacion['cadena_original']));

        }elseif(in_array($this->certificacion['documento'], ['CERTIFICADO DE REGISTRO ELECTRÓNICO', 'CERTIFICADO DE REGISTRO CON COLINDANCIAS', 'CERTIFICADO DE REGISTRO'])){

            return $pdf = $this->certificadoRegistro($this->certificadoRegistroPartes($this->certificacion['cadena_original']));

        }elseif($this->certificacion['documento'] == 'CEDULA DE ACTUALIZACIÓN CATASTRAL'){

            return $pdf = $this->cedulaActualizacion($this->cedulaActualizacionPartes($this->certificacion['cadena_original']));

        }elseif($this->certificacion['documento'] == 'CERTIFICADO NEGATIVO DE REGISTRO'){

            return $pdf = $this->certificadoNegativo($this->certificadoNegativoPartes($this->certificacion['cadena_original']));

        }

    }

    public function certificadoHistoria($partes){

        return Pdf::loadview('certificados.historia-reimpresion', [
            'objeto' => $partes,
            'qr' => $this->generadorQr($this->certificacion['uuid']),
            'certificacion' => $this->certificacion
        ]);

    }

    public function notificacionValorCatastral($partes){

        return Pdf::loadview('avaluos.notificacion-reimpresion', [
            'objeto' => $partes,
            'qr' => $this->generadorQr($this->certificacion['uuid']),
            'certificacion' => $this->certificacion
        ]);

    }

    public function certificadoRegistro($partes){

        return Pdf::loadview('certificaciones.registro', [
            'objeto' => $partes,
            'qr' => $this->generadorQr($this->certificacion['uuid']),
            'certificacion' => $this->certificacion
        ]);

    }

    public function cedulaActualizacion($partes){

        return Pdf::loadview('certificados.cedula-reimpresion', [
            'objeto' => $partes,
            'qr' => $this->generadorQr($this->certificacion['uuid']),
            'certificacion' => $this->certificacion
        ]);

    }

    public function certificadoNegativo($partes){

        return Pdf::loadview('certificados.negativo-reimpresion', [
            'objeto' => $partes,
            'qr' => $this->generadorQr($this->certificacion['uuid']),
            'certificacion' => $this->certificacion
        ]);

    }

    public function generadorQr($uuid)
    {

        $ruta = 'http://127.0.0.1:8001/verificacion/' . $uuid;

        $result = Builder::create()
                            ->writer(new PngWriter())
                            ->writerOptions([])
                            ->data($ruta)
                            ->encoding(new Encoding('UTF-8'))
                            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
                            ->size(100)
                            ->margin(0)
                            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
                            ->labelText('Escanea para verificar')
                            ->labelFont(new NotoSans(7))
                            ->labelAlignment(LabelAlignment::Center)
                            ->validateResult(false)
                            ->build();

        return $result->getDataUri();
    }

    public function certificadoHistoriaPartes($cadena){

        $object = (object)[];

        $array = explode('|', $cadena);

        foreach ($array as $item) {

            $aux =  explode(': ', $item);

            $historia = null;

            if($aux[0] === 'historia'){

                foreach($aux as $item){

                    if($item === 'historia') continue;

                    $historia = $historia . ' ' . $item;

                }

                $object->{$aux[0]} = $historia;

                continue;

            }

            $object->{$aux[0]} = $aux[1];

        }

        return $object;

    }

    public function certificadoRegistroPartes($cadena){

        $object = (object)[
            'propietarios' => collect(),
            'colindancias' => collect(),
        ];

        $array = explode('|', $cadena);

        foreach ($array as $item) {

            $aux =  explode(': ', $item);

            $aux2 = explode('%', $item);

            if(count($aux2) === 5){

                $propietario = (object)[];

                $propietario->nombre = str_replace('Nombre=' , '', $aux2[0]);

                $propietario->tipo = str_replace('Tipo=' , '', $aux2[1]);

                $propietario->porcentaje = str_replace('Porcentaje propiedad=' , '', $aux2[2]);

                $propietario->porcentaje_nuda = str_replace('Porcentaje nuda=' , '', $aux2[3]);

                $propietario->porcentaje_usufructo = str_replace('Porcentaje usufructo=' , '', $aux2[4]);

                $object->propietarios->push($propietario);

                continue;

            }

            if(count($aux2) === 3){

                $colindancia = (object)[];

                $colindancia->viento = str_replace('Viento=' , '', $aux2[0]);

                $colindancia->longitud = str_replace('Longitud=' , '', $aux2[1]);

                $colindancia->descripcion = str_replace('Descripcion=' , '', $aux2[2]);

                $object->colindancias->push($colindancia);

                continue;

            }

            $object->{$aux[0]} = $aux[1];

        }

        return $object;

    }

    public function cedulaActualizacionPartes($cadena){

        $object = (object)[];

        $array = explode('|', $cadena);

        foreach ($array as $item) {

            $aux =  explode(': ', $item);

            $object->{$aux[0]} = $aux[1];

        }

        return $object;

    }

    public function certificadoNegativoPartes($cadena){

        $object = (object)[];

        $array = explode('|', $cadena);

        foreach ($array as $item) {

            $aux =  explode(': ', $item);

            $object->{$aux[0]} = $aux[1];

        }

        return $object;

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

    }

    public function render()
    {

        try {

            $response = Http::acceptJson()
                            ->withToken(env('SGC_ACCESS_TOKEN'))
                            ->withQueryParameters([
                                'entidad' => auth()->user()->entidad_id,
                                'estado' => $this->estado,
                                'año' => $this->año,
                                'folio' => $this->folio,
                                'tipo_servicio' => $this->tipo_servicio,
                                'pagina' => $this->paginaActual,
                                'pagination' => $this->pagination
                            ])
                            ->get(env('SGC_CONSULTA_CERTIFICADOS'));

        } catch (\Throwable $th) {

            abort(500, message:"Ha ocurrido un error en el sistema comuniquese con el departamento de operaciones y desarrollo de sistemas.");

        }

        $data = json_decode($response, true);

        if($response->status() === 200){

            $this->paginaActual = Arr::get($data, 'meta.current_page');
            $this->paginaAnterior = Arr::get($data, 'links.prev');
            $this->paginaSiguiente = Arr::get($data, 'links.next');

            $tramites =  collect($data['data']);

        }else{

            $tramites = [];

        }

        return view('livewire.usuarios.tramites.certificados', compact('tramites'))->extends('layouts.admin');
    }

}
