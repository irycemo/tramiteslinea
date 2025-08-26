<?php

namespace App\Livewire\Catastro\Avisos\AvisoAclaratorio;

use App\Models\Actor;
use App\Models\Aviso;
use App\Models\Persona;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\SGCService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;

class Transmitentes extends Component
{

    public Aviso $aviso;
    public $avisoId;

    #[On('cargarAviso')]
    public function cargarAviso($id = null){

        if(isset($this->avisoId)){

            $this->aviso = Aviso::find($this->avisoId);

        }else{

            $this->aviso = Aviso::find($id);

        }

    }

    public function cargarPropietarios(){

        try {

            $data = (new SGCService())->consultarPropietariosPredioId($this->aviso->predio_sgc);

            DB::transaction(function () use ($data){

                $this->procesarTransmitentes($data);

            });

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al consultar propietarios por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);


        }

    }

    public function procesarTransmitentes($data){

        $this->aviso->predio->transmitentes()->each->delete();

        foreach($data as $propietario){

            $persona = Persona::where('nombre', $propietario['persona']['nombre'])
                                ->where('ap_paterno', $propietario['persona']['ap_paterno'])
                                ->where('ap_materno', $propietario['persona']['ap_materno'])
                                ->where('razon_social', $propietario['persona']['razon_social'])
                                ->first();

            if(!$persona){

                $persona = Persona::create([
                    'tipo' => isset($propietario['persona']['nombre']) ? 'FÍSICA' : 'MORAL',
                    'nombre' => $propietario['persona']['nombre'],
                    'ap_paterno' => $propietario['persona']['ap_paterno'],
                    'ap_materno' => $propietario['persona']['ap_materno'],
                    'razon_social' => $propietario['persona']['razon_social'],
                ]);

            }

            $this->aviso->predio->actores()->create([
                'tipo' => 'transmitente',
                'persona_id' => $persona->id,
                'porcentaje_propiedad' => $propietario['porcentaje_propiedad'],
                'porcentaje_nuda' => $propietario['porcentaje_nuda'],
                'porcentaje_usufructo' => $propietario['porcentaje_usufructo'],
            ]);

        }

    }

    public function borrarTransmitente($id){

        try {

            Actor::find($id)->delete();

            $this->dispatch('mostrarMensaje', ['success', "La información se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar transmitente por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
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
        return view('livewire.catastro.avisos.aviso-aclaratorio.transmitentes');
    }

}
