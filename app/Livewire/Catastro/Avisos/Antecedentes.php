<?php

namespace App\Livewire\Catastro\Avisos;

use App\Models\Aviso;
use Livewire\Component;
use App\Models\Antecedente;
use Livewire\Attributes\On;
use App\Constantes\Constantes;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class Antecedentes extends Component
{

    public Aviso $aviso;
    public $avisoId;

    public $folio_real;
    public $movimiento_registral;
    public $tomo;
    public $registro;
    public $acto;
    public $distritos;
    public $distrito;
    public $secciones;
    public $seccion;
    public $selected_id;

    public $editar = false;
    public $crear = false;
    public $modal;
    public $modalBorrar;

    protected function rules(){
        return [
            'folio_real' => Rule::requiredIf($this->movimiento_registral != null),
            'movimiento_registral' => Rule::requiredIf($this->folio_real != null),
            'tomo' => Rule::requiredIf($this->registro != null),
            'registro' => Rule::requiredIf($this->tomo != null),
            'seccion' => 'required',
            'distrito' => 'required',
            'acto' => 'required'
        ];
    }

    public function updated($property, $value){

        if(in_array($property, ['folio_real', 'movimiento_registral'])){

            $this->reset('tomo', 'registro');

        }

        if(in_array($property, ['tomo', 'registro'])){

            $this->reset('folio_real', 'movimiento_registral');

        }

    }

    #[On('cargarAviso')]
    public function cargarAviso($id = null){

        if(isset($this->avisoId)){

            $this->aviso = Aviso::with('predio')->find($this->avisoId);

        }else{

            $this->aviso = Aviso::with('predio')->find($id);

        }

    }

    public function resetear(){

        $this->reset([
            'folio_real',
            'movimiento_registral',
            'tomo',
            'registro',
            'acto',
            'distrito',
            'seccion',
            'modal',
            'modalBorrar',
            'selected_id'
        ]);

    }

    public function agregarAntecedente(){

        if(!$this->aviso->getKey()){

            $this->dispatch('mostrarMensaje', ['error', "Primero debe cargar el aviso."]);

            return;

        }

        $this->modal = true;
        $this->crear = true;

    }

    public function editarAntecedente(Antecedente $antecedente){

        $this->folio_real = $antecedente->folio_real;
        $this->movimiento_registral = $antecedente->movimiento_registral;
        $this->tomo = $antecedente->tomo;
        $this->registro = $antecedente->registro;
        $this->seccion = $antecedente->seccion;
        $this->distrito = $antecedente->distrito;
        $this->acto = $antecedente->acto;
        $this->selected_id = $antecedente->id;

        $this->crear = false;
        $this->editar = true;

        $this->modal = true;

    }

    public function actualizarAntecedente(){

        $this->validate();

        try {

            $this->aviso->antecedentes()->where('id', $this->selected_id)->first()->update([
                'folio_real' => $this->folio_real,
                'movimiento_registral' => $this->movimiento_registral,
                'tomo' => $this->tomo,
                'registro' => $this->registro,
                'seccion' => $this->seccion,
                'distrito' => $this->distrito,
                'acto' => $this->acto,
                'actualizado_por' => auth()->id()
            ]);

            $this->dispatch('mostrarMensaje', ['success', "El antecedente se actualizó con éxito."]);

            $this->aviso->load('antecedentes');

            $this->resetear();

        } catch (\Throwable $th) {

            Log::error("Error al actualizar antecedente por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function guardarAntecedente(){

        $this->validate();

        try {

            $this->aviso->antecedentes()->create([
                'folio_real' => $this->folio_real,
                'movimiento_registral' => $this->movimiento_registral,
                'tomo' => $this->tomo,
                'registro' => $this->registro,
                'seccion' => $this->seccion,
                'distrito' => $this->distrito,
                'acto' => $this->acto,
                'creado_por' => auth()->id(),
            ]);

            $this->dispatch('mostrarMensaje', ['success', "El antecedente se guardó con éxito."]);

            $this->aviso->load('antecedentes');

            $this->resetear();

        } catch (\Throwable $th) {

            Log::error("Error al guardar antecedente por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        if($this->avisoId){

            $this->cargarAviso();

        }

        $this->secciones = Constantes::SECCIONES;

        $this->distritos = Constantes::DISTRITOS;

    }

    public function render()
    {
        return view('livewire.catastro.avisos.antecedentes');
    }
}
