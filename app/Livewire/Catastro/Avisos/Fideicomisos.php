<?php

namespace App\Livewire\Catastro\Avisos;

use App\Constantes\Constantes;
use App\Models\Actor;
use App\Models\Aviso;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;

class Fideicomisos extends Component
{

    public Aviso $aviso;
    public $avisoId;

    public $actores;

    protected function rules(){
        return [
            'aviso.descripcion_fideicomiso' => 'required',
         ];
    }

    protected function validationAttributes()
    {

        return [
            'aviso.descripcion_fideicomiso' => 'objeto',
        ];

    }

    #[On('cargarAviso')]
    public function cargarAviso($id = null){

        if(isset($this->avisoId)){

            $this->aviso = Aviso::with('predio')->find($this->avisoId);

        }else{

            $this->aviso = Aviso::with('predio')->find($id);

        }

    }

    #[On('refresh')]
    public function refresh(){

        $this->aviso->predio->load('actores.persona');

    }

    public function eliminarActor(Actor $actor){

        try {

            $actor->delete();

            $this->dispatch('mostrarMensaje', ['success', "La información se eliminó con éxito."]);

            $this->aviso->predio->refresh();

            $this->aviso->predio->load('actores.persona');

        } catch (\Throwable $th) {

            Log::error("Error al borrar adquiriente por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function guardar(){

        $this->validate();

        try {

            $this->aviso->actualizado_por = auth()->id();
            $this->aviso->save();

            $this->aviso->audits()->latest()->first()->update(['tags' => 'Guardó fideicomiso']);

            $this->dispatch('mostrarMensaje', ['success', "La información se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar fideicomiso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }
    }

    public function mount(){

        if($this->avisoId){

            $this->cargarAviso();

        }

        $this->actores = Constantes::ACTORES_FIDEICOMISO;

    }

    public function render()
    {
        return view('livewire.catastro.avisos.fideicomisos');
    }
}
