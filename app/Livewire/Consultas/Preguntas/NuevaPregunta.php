<?php

namespace App\Livewire\Consultas\Preguntas;

use Livewire\Component;
use App\Models\Pregunta;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class NuevaPregunta extends Component
{

    use WithFileUploads;

    public Pregunta $pregunta;

    public $titulo;
    public $contenido;
    public $images = [];

    protected function rules(){
        return [
            'titulo' => 'required',
            'contenido' => 'required',
         ];
    }

    public function completeUplad($uploadedUrl, $eventName){

            foreach($this->images as $image){

                if($image->getFileName() === $uploadedUrl){

                    $newFileName = $image->store('/', 'preguntas');

                    $url = Storage::disk('preguntas')->url($newFileName);

                    $this->dispatch($eventName, ['url' => $url, 'href' => $url]);

                    return;

                }

            }

    }

    public function deleteImage($url){

            $name = substr($url, strrpos($url, '/') + 1);

            Storage::disk('preguntas')->delete($name);

    }

    public function revisarContenido(){

        if(isset($this->pregunta)){

            $this->dispatch('loadInitial', $this->contenido);

        }

    }

    public function guardar(){

        $this->validate();

        try {

            Pregunta::create([
                'titulo' => $this->titulo,
                'contenido' => $this->contenido,
                'creado_por' => auth()->id()
            ]);

            return redirect()->route('preguntas_frecuentes');


        } catch (\Throwable $th) {

            Log::error("Error al crear pregunta por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function actualizar(){

        $this->validate();

        try {

            $this->pregunta->update(['titulo' => $this->titulo, 'contenido' => $this->contenido]);

            return redirect()->route('preguntas_frecuentes');


        } catch (\Throwable $th) {

            Log::error("Error al crear pregunta por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        if(isset($this->pregunta)){

            $this->titulo = $this->pregunta->titulo;
            $this->contenido = $this->pregunta->contenido;

            $this->dispatch('loadInitial', $this->contenido);

        }

    }

    public function render()
    {
        return view('livewire.consultas.preguntas.nueva-pregunta')->extends('layouts.admin');
    }
}
