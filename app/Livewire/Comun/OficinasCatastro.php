<?php

namespace App\Livewire\Comun;

use Livewire\Component;
use Illuminate\Support\Arr;
use App\Services\SGCService;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class OficinasCatastro extends Component
{

    use WithFileUploads;

    public $search;
    public $paginaActual = 1;
    public $paginaAnterior;
    public $paginaSiguiente;
    public $pagination = 10;

    public $modal = false;
    public $modalRequerimiento = false;

    public $oficinaSeleccionada;

    public $documento;
    public $observacion;

    protected function rules(){
        return [
            'observacion' => 'required',
            'documento' => 'nullable'
         ];
    }

    public function nextPage(){ (int)$this->paginaActual++; $this->dispatch('gotoTop'); }

    public function previousPage(){ (int)$this->paginaActual--; $this->dispatch('gotoTop'); }

    public function abrirModalVerOficina($oficina){

        $this->modal = true;

        $this->oficinaSeleccionada =  $oficina;

    }

    public function abrirModalRequerimiento($oficina){

        $this->modalRequerimiento = true;

        $this->oficinaSeleccionada =  $oficina;

    }

    public function hacerRequerimiento(){

        $this->validate();

        try {

            $url = null;

            if($this->documento){

                $name = $this->documento->store('/', 'requerimientos');

                $url = Storage::disk('requerimientos')->url($name);

            }

            (new SGCService())->crearRequerimientoOficina($this->observacion, $url, $this->oficinaSeleccionada['id'], auth()->user()->name, auth()->user()->entidad_id);

            $this->dispatch('mostrarMensaje', ['success', 'El requerimiento de ingresó con éxito']);

            $this->reset('observacion', 'documento');

            $this->modalRequerimiento = false;

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al crear requerimiento a oficina por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function render()
    {

        $oficinas = [];

        try {

            $data = (new SGCService())->consultarOficinas(
                                                            $this->search,
                                                            $this->paginaActual,
                                                            $this->pagination
                                                        );

            $this->paginaActual = Arr::get($data, 'meta.current_page');
            $this->paginaAnterior = Arr::get($data, 'links.prev');
            $this->paginaSiguiente = Arr::get($data, 'links.next');

            $oficinas = collect($data['data']);

        } catch (GeneralException $ex) {

            abort(403, message:$ex->getMessage());

        } catch (\Throwable $th) {

            Log::error("Error al consultar consultar oficinas es SGC. " . $th);

            abort(403, message:"Error al consultar oficinas");

        }


        return view('livewire.comun.oficinas-catastro', compact('oficinas'))->extends('layouts.admin');
    }
}
