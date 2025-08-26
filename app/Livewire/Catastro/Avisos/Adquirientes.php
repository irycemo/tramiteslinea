<?php

namespace App\Livewire\Catastro\Avisos;

use App\Livewire\Comun\PropietarioCrear;
use App\Models\Actor;
use App\Models\Aviso;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;

class Adquirientes extends Component
{

    public Aviso $aviso;
    public $avisoId;

    #[On('refresh')]
    public function refresh(){

        $this->aviso->predio->load('actores.persona');

    }

    #[On('cargarAviso')]
    public function cargarAviso($id = null){

        if(isset($this->avisoId)){

            $this->aviso = Aviso::with('predio')->find($this->avisoId);

        }else{

            $this->aviso = Aviso::with('predio')->find($id);

        }

    }

    public function borrarActor(Actor $actor){

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

    public function mount(){

        if($this->avisoId){

            $this->cargarAviso();

        }

    }

    public function render()
    {
        return view('livewire.catastro.avisos.adquirientes');
    }
}
