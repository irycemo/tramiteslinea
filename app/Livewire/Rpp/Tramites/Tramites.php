<?php

namespace App\Livewire\Rpp\Tramites;

use Livewire\Component;
use Illuminate\Support\Arr;
use App\Constantes\Constantes;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Http\Client\ConnectionException;

class Tramites extends Component
{

    public $estados;
    public $estado;
    public $años;
    public $folio;
    public $tipo_servicio;
    public $servicio;
    public $año;
    public $paginaActual = 1;
    public $paginaAnterior;
    public $paginaSiguiente;
    public $pagination = 10;
    public $servicios;

    public $modal = false;

    public $tramiteSeleccionado;

    public $token;

    public function nextPage(){ (int)$this->paginaActual++; $this->dispatch('gotoTop'); }

    public function previousPage(){ (int)$this->paginaActual--; $this->dispatch('gotoTop'); }

    public function abrirModalVer($tramite){

        $this->modal = true;

        $this->tramiteSeleccionado =  $tramite;

    }

    public function getToken($tramite){

        $output = false;

        $string = $tramite['linea_de_captura'] . $tramite['monto'] . "IRYCEM" . $tramite['fecha_vencimiento'];

        $encrypt_method = "AES-256-CBC";

        $secret_key = 'regcatastral.2023@gob';

        $secret_iv = 'regcatastral.2023@gob';

        $key = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);

        $output = base64_encode($output);

        $this->token =  $output;

    }

    public function genererOrdenPago($tramite){

        $generatorPNG = new BarcodeGeneratorPNG();

        $pdf = Pdf::loadView('tramites.orden', ['tramite' => $tramite, 'generatorPNG' => $generatorPNG])->output();

        return response()->streamDownload(
            fn () => print($pdf),
            'orden_de_pago.pdf'
        );

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        try {

            $response = Http::withToken(env('SISTEMA_TRAMITES_TOKEN'))->accept('application/json')->get(env('SISTEMA_TRAMITES_CONSULTA_SERVICIOS'), [
                                                                                                                                    'claves' =>['DL17', 'DL16', 'DL27', 'DL25', 'DL24', 'DL23', 'DL22', 'DL21']
                                                                                                                                ]);
            if($response->status() === 200)
                $this->servicios = collect(json_decode($response, true)['data']);
            else
                $this->servicios = [];

        } catch (ConnectionException $th) {

            Log::error("Error al cargar servicios en trámties: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            abort(500, message:"Ha ocurrido un error en el sistema comuniquese con el departamento de operaciones y desarrollo de sistemas.");

        }

    }

    public function render()
    {

        $response = Http::acceptJson()
                            ->withToken(env('SISTEMA_TRAMITES_TOKEN'))
                            ->withQueryParameters([
                                'entidad' => auth()->user()->entidad_id,
                                'estado' => $this->estado,
                                'año' => $this->año,
                                'numero_control' => $this->folio,
                                'tipo_servicio' => $this->tipo_servicio,
                                'servicio' => $this->servicio,
                                'pagina' => $this->paginaActual,
                                'pagination' => $this->pagination
                            ])
                            ->get(env('SISTEMA_TRAMITES_CONSULTA_TRAMITES'));


        $data = json_decode($response, true);

        if($response->status() === 200){

            $this->paginaActual = Arr::get($data, 'meta.current_page');
            $this->paginaAnterior = Arr::get($data, 'links.prev');
            $this->paginaSiguiente = Arr::get($data, 'links.next');

            $tramites =  collect($data['data']);

        }else{

            $tramites = [];

        }

        return view('livewire.rpp.tramites.tramites', compact('tramites'))->extends('layouts.admin');
    }
}
