<?php

namespace App\Livewire\Catastro\Avisos;

use App\Models\Aviso;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Constantes\Constantes;
use App\Traits\ColindanciasTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IdentificacionInmueble extends Component
{

    use ColindanciasTrait;

    public Aviso $aviso;
    public $avisoId;

    protected function rules(){

        return [
            'aviso.cantidad_tramitada' => 'required'
         ] + $this->rulesColindancias;

    }

    protected function validationAttributes()
    {

        return [
            'aviso.cantidad_tramitada' => 'cantidad tramitada',
        ] + $this->validationAttributesColindancias;

    }

    #[On('cargarAviso')]
    public function cargarAviso($id = null){

        if(isset($this->avisoId)){

            $this->aviso = Aviso::find($this->avisoId);

        }else{

            $this->aviso = Aviso::find($id);

        }

        $this->cargarColindancias($this->aviso->predio);

    }

    public function guardar(){

        $this->validate();

        try {

            DB::transaction(function () {

                $this->guardarColindancias($this->aviso->predio);

                $this->aviso->actualizado_por = auth()->id();
                $this->aviso->save();

            });

            $this->dispatch('mostrarMensaje', ['success', "La información se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al guardar identificación del inmueble por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }


    }

    public function mount(){

        $this->vientos = Constantes::VIENTOS;

        if($this->avisoId){

            $this->cargarAviso();

        }

    }

    public function render()
    {
        return view('livewire.catastro.avisos.identificacion-inmueble');
    }
}
