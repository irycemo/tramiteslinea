<?php

namespace App\Livewire\Usuarios\Tramites;

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

    public function nextPage(){ (int)$this->paginaActual++; $this->dispatch('gotoTop'); }

    public function previousPage(){ (int)$this->paginaActual--; $this->dispatch('gotoTop'); }

    public function abrirModalVer($tramite){

        $this->modal = true;

        $this->tramiteSeleccionado =  $tramite;

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

            $response = Http::withToken(env('SGC_ACCESS_TOKEN'))->accept('application/json')->get(env('SGC_CONSULTA_SERVICIOS'), [
                                                                                                                                    'ids' =>[3,4,5,6,7,8,9,10,11,66,67,68,64,65,57,55]
                                                                                                                                ]);

            $this->servicios = collect(json_decode($response, true)['data']);

        } catch (ConnectionException $th) {

            Log::error("Error al cargar servicios en trámties: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

            abort(500, message:"Ha ocurrido un error en el sistema comuniquese con el departamento de operaciones y desarrollo de sistemas.");

        }

    }

    public function render()
    {

        $response = Http::acceptJson()
                            ->withToken(env('SGC_ACCESS_TOKEN'))
                            ->withQueryParameters([
                                'entidad' => auth()->user()->entidad_id,
                                'estado' => $this->estado,
                                'año' => $this->año,
                                'folio' => $this->folio,
                                'tipo_servicio' => $this->tipo_servicio,
                                'servicio' => $this->servicio,
                                'pagina' => $this->paginaActual,
                                'pagination' => $this->pagination
                            ])
                            ->get(env('SGC_CONSULTA_TRAMITES'));


        $data = json_decode($response, true);

        if($response->status() === 200){

            $this->paginaActual = Arr::get($data, 'meta.current_page');
            $this->paginaAnterior = Arr::get($data, 'links.prev');
            $this->paginaSiguiente = Arr::get($data, 'links.next');

            $tramites =  collect($data['data']);

        }else{

            dd($data);

            $tramites = [];

        }

        return view('livewire.usuarios.tramites.tramites', compact('tramites'))->extends('layouts.admin');
    }
}
