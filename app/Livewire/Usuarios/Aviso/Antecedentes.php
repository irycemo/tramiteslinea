<?php

namespace App\Livewire\Usuarios\Aviso;

use App\Models\Aviso;
use Livewire\Component;
use App\Models\Antecedente;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\Log;

class Antecedentes extends Component
{

    public Aviso $aviso;
    public $avisoId;

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

    protected $listeners = ['cargarAviso'];

    protected function rules(){
        return [
            'tomo' => 'required',
            'registro' => 'required',
            'seccion' => 'required',
            'distrito' => 'required',
            'acto' => 'required|'. utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.()\/\-," ]*$/'),
        ];
    }

    public function resetear(){

        $this->reset([
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

    public function crearModeloVacio(){
        $this->aviso = Aviso::make(['estado' => 'nuevo']);
    }

    public function cargarAviso($id){

        $this->aviso = Aviso::find($id);

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

            $this->cargarAviso($this->avisoId);

        }else{

            $this->crearModeloVacio();

        }

        $this->secciones = Constantes::SECCIONES;

        $this->distritos = Constantes::DISTRITOS;

    }


    public function render()
    {
        return view('livewire.usuarios.aviso.antecedentes');
    }
}
