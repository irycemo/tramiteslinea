<?php

namespace App\Livewire\Comun;

use Livewire\Component;
use App\Services\SGCService;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Requerimietos extends Component
{

    use WithFileUploads;

    public $requerimientos;
    public $requerimiento_seleccionado;
    public $oficina;
    public $respuestas = [];

    public $documento;
    public $observacion;

    protected function rules(){
        return [
            'observacion' => 'required',
            'documento' => 'nullable'
         ];
    }

    public function hacerRequerimiento(){

        $this->validate();

        try {

            $url = null;

            if($this->documento){

                $name = $this->documento->store('/', 'requerimientos');

                $url = Storage::disk('requerimientos')->url($name);

            }

            $nuevoRequerimiento = (new SGCService())->crearRequerimientoOficina($this->observacion, $url, $this->oficina, auth()->user()->name, auth()->user()->entidad_id);

            array_push($this->requerimientos, $nuevoRequerimiento);

            $this->dispatch('mostrarMensaje', ['success', 'El requerimiento se ingresó con éxito']);

            $this->resetRequerimientos();

            $this->requerimiento_seleccionado = $nuevoRequerimiento;

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al crear requerimiento a oficina por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function responderRequerimiento(){

        $this->validate();

        try {

            $url = null;

            if($this->documento){

                $name = $this->documento->store('/', 'requerimientos');

                $url = Storage::disk('requerimientos')->url($name);

            }

            $nuevoRequerimiento = (new SGCService())->responderRequerimiento($this->observacion, $url, $this->requerimiento_seleccionado['id'], $this->oficina, auth()->user()->name, auth()->user()->entidad_id);

            array_push($this->respuestas, $nuevoRequerimiento);

            $this->dispatch('mostrarMensaje', ['success', 'El requerimiento se ingresó con éxito']);

            $this->reset(['observacion', 'documento']);

            $this->dispatch('removeFiles');

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al responder requerimiento a oficina por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function verRequerimiento($requerimiento){

        $this->resetRequerimientos();

        $this->requerimiento_seleccionado = $requerimiento;

        $this->respuestas = (new SGCService())->consultarRequerimiento($this->requerimiento_seleccionado['id']);

    }

    public function resetRequerimientos(){

        $this->reset('respuestas', 'requerimiento_seleccionado', 'documento', 'observacion');

    }

    public function mount(){

        $this->oficina = request()->query('oficina');

        $this->requerimientos = (new SGCService())->consultarRequerimientosOficina($this->oficina, auth()->user()->entidad_id);

    }

    public function render()
    {
        return view('livewire.comun.requerimietos')->extends('layouts.admin');
    }
}
