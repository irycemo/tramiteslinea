<?php

namespace App\Livewire\Catastro\Tramites;

use Livewire\Component;
use Illuminate\Support\Arr;
use App\Services\SGCService;
use Livewire\WithFileUploads;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Storage;

class Certificados extends Component
{

    use WithFileUploads;

    public $estados;
    public $estado;
    public $años;
    public $folio;
    public $localidad;
    public $oficina;
    public $tipo_predio;
    public $numero_registro;
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

    public function nextPage(){ (int)$this->paginaActual++; $this->dispatch('gotoTop'); }

    public function previousPage(){ (int)$this->paginaActual--; $this->dispatch('gotoTop'); }

    public function abrirModalVerCertificado($certificado){

        $this->modal = true;

        $this->certificadoSeleccionado =  $certificado;

    }

    public function abrirModalRequerimiento($certificado){

        $this->modalRequerimiento = true;

        $this->certificadoSeleccionado =  $certificado;

    }

    public function abrirModalVerRequerimientos($certificado){

        $this->modalVerRequerimiento = true;

        $this->certificadoSeleccionado =  $certificado;

    }

    public function hacerRequerimiento(){

        $this->validate();

        try {

            $url = null;

            if($this->documento){

                $name = $this->documento->store('/', 'requerimientos');

                $url = Storage::disk('requerimientos')->url($name);

            }

            (new SGCService())->crearRequerimiento($this->observacion, $url, $this->certificadoSeleccionado['id'], auth()->user()->name);

            $this->dispatch('mostrarMensaje', ['success', 'El requerimiento de ingresó con éxito']);

            $this->reset('observacion', 'documento');

            $this->modalRequerimiento = false;

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al crear requerimiento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function reimprimirCertificado($certificado){

        try {

            $data = (new SGCService())->generarCertificadoPdf($certificado['id']);

            $pdf = base64_decode($data['data']['pdf']);

            return response()->streamDownload(
                fn () => print($pdf),
                $certificado['localidad'] . '-' . $certificado['oficina'] . '-' . $certificado['tipo_predio'] . '-' . $certificado['numero_registro'] . '-' . 'certificado_de_registro.pdf'
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

            abort(403, 'Esta área no esta disponible para usuarios con rol Administrador para ver los certificados dirigase al Sistema de Gestión Catastral.');

        }

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

        $this->estado = request()->query('estado');

    }

    public function render()
    {

        $certificados = [];

        try {

            $data = (new SGCService())->consultarCertificados(
                                                                 auth()->user()->entidad_id,
                                                                 $this->año,
                                                                 $this->folio,
                                                                 $this->estado,
                                                                 $this->localidad,
                                                                 $this->oficina,
                                                                 $this->tipo_predio,
                                                                 $this->numero_registro,
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

        return view('livewire.catastro.tramites.certificados', compact('certificados'))->extends('layouts.admin');
    }
}
