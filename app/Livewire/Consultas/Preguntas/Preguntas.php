<?php

namespace App\Livewire\Consultas\Preguntas;

use Livewire\Component;
use App\Models\Pregunta;
use Livewire\WithPagination;
use App\Models\PreguntaLeida;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Preguntas extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public Pregunta $modelo_editar;

    public $pregunta;

    public $modalUsuarios = false;

    public $usuarios = [];

    public function crearModeloVacio(){
        $this->modelo_editar =  Pregunta::make();
    }

    public function verPregunta(Pregunta $pregunta){

        $this->modal = true;

        $this->pregunta = $pregunta;

    }

    public function verUsuarios(Pregunta $pregunta){

        $this->modalUsuarios = true;

        $this->pregunta = $pregunta;

        $this->usuarios =  PreguntaLeida::with('usuario')
                                                ->where('pregunta_id', $pregunta->id)
                                                ->get();

    }

    public function marcarComoLeido(){

        $pregunta_leida = PreguntaLeida::where('user_id', auth()->id())->where('pregunta_id', $this->pregunta->id)->first();

        if($pregunta_leida){

            $this->dispatch('mostrarMensaje', ['success', "Ya ha sido marcada como leida."]);

            return;

        }

        PreguntaLeida::create(['user_id' => auth()->id(), 'pregunta_id' => $this->pregunta->id]);

        $this->dispatch('mostrarMensaje', ['success', "La información de guardó con éxito."]);

        $this->modal = false;

    }

    public function borrarPregunta(){

        try {

            DB::transaction(function () {

                PreguntaLeida::where('pregunta_id', $this->selected_id)->get()->each->delete();

                Pregunta::find($this->selected_id)->delete();

            });

            $this->modalBorrar = false;

            $this->dispatch('mostrarMensaje', ['success', "La información se eliminó con éxito."]);

        } catch (\Throwable $th) {
            Log::error("Error al borrar pregunta por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

    #[Computed]
    public function preguntas(){

        return Pregunta::where('titulo', 'LIKE',  '%' . $this->search . '%')
                        ->orWhere('contenido', 'LIKE',  '%' . $this->search . '%')
                        ->orderBy('id', 'desc')
                        ->simplePaginate(10);

    }

    public function mount(){

        $this->crearModeloVacio();

        $this->search = request()->query('search');

    }

    public function render()
    {
        return view('livewire.consultas.preguntas.preguntas')->extends('layouts.admin');
    }

}
