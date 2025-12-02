<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Entidad;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;

class Entidades extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public Entidad $modelo_editar;

    public $notarios;
    public $notarios_adscritos;

    protected function rules(){
        return [
            'modelo_editar.dependencia' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'modelo_editar.numero_notaria' => 'nullable|numeric',
            'modelo_editar.email' => 'nullable',
            'modelo_editar.notario' => 'nullable',
            'modelo_editar.adscrito' => 'nullable|numeric',
            'modelo_editar.estado' => 'required',
         ];
    }

    public function updated($property, $value){

        if($value === ''){

           $property = null;

        }

    }

    protected $validationAttributes  = [
        'modelo_editar.numero_notaria' => 'número de notaria'
    ];

    public function crearModeloVacio(){
        $this->modelo_editar = Entidad::make();
    }

    public function abrirModalEditar(Entidad $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function guardar(){

        $this->validate();

        try {

            $this->modelo_editar->creado_por = auth()->user()->id;
            $this->modelo_editar->save();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "La entidad se creó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al crear entidad por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function actualizar(){

        $this->validate();

        try{

            $this->modelo_editar->actualizado_por = auth()->user()->id;
            $this->modelo_editar->save();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "La entidad se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar entidad por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            $entidad = Entidad::find($this->selected_id);

            $entidad->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "La entidad se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar entidad por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function mount(){

        $this->crearModeloVacio();

        $this->notarios = User::whereHas('roles', function($q){
                                        $q->where('name', 'Notario');
                                    })
                                    ->orderBy('name')
                                    ->get();

        $this->notarios_adscritos = User::whereHas('roles', function($q){
                                        $q->where('name', 'Notario adscrito');
                                    })
                                    ->orderBy('name')
                                    ->get();

    }

    #[Computed]
    public function entidades(){

        return Entidad::with('creadoPor', 'actualizadoPor')
                        ->where('dependencia', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('numero_notaria', 'LIKE', '%' . $this->search . '%')
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->pagination);

    }

    public function render()
    {
        return view('livewire.admin.entidades')->extends('layouts.admin');
    }
}
