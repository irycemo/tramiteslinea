<?php

namespace App\Livewire\Rpp\Certificados;

use Livewire\Component;
use Illuminate\Support\Arr;
use App\Services\SrppService;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;

class Certificados extends Component
{

    public $estados;
    public $estado;
    public $años;
    public $folio;
    public $folio_real;
    public $año;
    public $paginaActual = 1;
    public $paginaAnterior;
    public $paginaSiguiente;
    public $pagination = 10;

    public $modal = false;
    public $modalRequerimiento = false;
    public $modalVerRequerimiento = false;

    public $observacion;
    public $documento;

    public $certificadoSeleccionado;

    protected function rules(){
        return [
            'observacion' => 'required',
            'documento' => 'nullable'
         ];
    }

    public function updatedFolio(){

        if($this->folio == '') $this->folio = null;

    }

    public function updatedFolioReal(){

        if($this->folio_real == '') $this->folio_real = null;

    }

    public function nextPage(){ (int)$this->paginaActual++; $this->dispatch('gotoTop'); }

    public function previousPage(){ (int)$this->paginaActual--; $this->dispatch('gotoTop'); }

    public function abrirModalVerCertificado($certificado){

        $this->modal = true;

        $this->certificadoSeleccionado =  $certificado;

    }

    public function reimprimirCertificado($certificado){

        try {

            $data = (new SrppService())->generarCertificadoGravamenPdf($certificado['id']);

            $pdf = base64_decode($data['data']['pdf']);

            return response()->streamDownload(
                fn () => print($pdf),
                'certificado_gravamen_folio_real_' . $certificado['folio_real'] . '.pdf'
            );

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al generar pdf del certificado por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function mount(){

        if(auth()->user()->hasRole('Administrador')){

            abort(403, 'Esta área no esta disponible para usuarios con rol Administrador para ver los certificados dirigase al Sistema RPP.');

        }

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

    }

    public function render()
    {

        $certificados = [];

        try {

            $data = (new SrppService())->consultarCertificadosGravamen(
                                                                 auth()->user()->entidad_id,
                                                                 $this->año,
                                                                 $this->folio,
                                                                 $this->estado,
                                                                 $this->folio_real,
                                                                 $this->paginaActual,
                                                                 $this->pagination
                                                                );

            $this->paginaActual = Arr::get($data, 'meta.current_page');
            $this->paginaAnterior = Arr::get($data, 'links.prev');
            $this->paginaSiguiente = Arr::get($data, 'links.next');

            $certificados = collect($data['data']);

        } catch (GeneralException $ex) {

            abort(403, message:$ex->getMessage());

        } catch (\Throwable $th) {

            Log::error("Error al consultar consultar certificados es SGC. " . $th);

            abort(403, message:"Error al consultar certificados");

        }

        return view('livewire.rpp.certificados.certificados', compact('certificados'))->extends('layouts.admin');
    }
}
