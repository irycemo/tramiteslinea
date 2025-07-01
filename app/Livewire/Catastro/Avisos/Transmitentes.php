<?php

namespace App\Livewire\Catastro\Avisos;

use App\Models\Actor;
use App\Models\Aviso;
use App\Models\Persona;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\SGCService;
use App\Constantes\Constantes;
use App\Traits\BuscarPersonaTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;

class Transmitentes extends Component
{

    use BuscarPersonaTrait;

    public Aviso $aviso;
    public $avisoId;

    public $años;
    public $año;
    public $folio;
    public $usuario;

    #[On('cargarAviso')]
    public function cargarAviso($id = null){

        if(isset($this->avisoId)){

            $this->aviso = Aviso::find($this->avisoId);

        }else{

            $this->aviso = Aviso::find($id);

        }

    }

    public function buscarCertificado(){

        try {

            $data = (new SGCService())->consultarPropietarios($this->año, $this->folio, $this->usuario, $this->aviso->predio_sgc);

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

            $persona = Persona::where('nombre', $propietario['nombre'])
                                ->where('ap_paterno', $propietario['ap_paterno'])
                                ->where('ap_materno', $propietario['ap_materno'])
                                ->where('razon_social', $propietario['razon_social'])
                                ->first();

            if(!$persona){

                $persona = Persona::create([
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

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.catastro.avisos.transmitentes');
    }
}
