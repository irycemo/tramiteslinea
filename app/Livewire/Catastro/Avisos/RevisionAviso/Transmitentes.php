<?php

namespace App\Livewire\Catastro\Avisos\RevisionAviso;

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

    public $flag_encadenamiento = false;
    public $fuera_del_primer_mes;
    public $avisos_misma_escritura;
    public $actores;
    public $actor;

    public $fecha_nacimiento;
    public $nacionalidad;
    public $estado_civil;
    public $calle;
    public $numero_exterior;
    public $numero_interior;
    public $colonia;
    public $cp;
    public $entidad;
    public $ciudad;
    public $municipio;

    public $modal = false;

    public function updatedActor(){

        $actor = Actor::find($this->actor);

        if(! $actor) return;

       /*  if($this->aviso->predio->transmitentes()->where('persona_id', $actor->persona_id)->first()){

            $this->dispatch('mostrarMensaje', ['success', "La persona ya es transmitente."]);

            return;

        } */

        $transmitente = $actor->replicate();

        $transmitente->tipo = 'transmitente';
        $transmitente->predio_id = $this->aviso->predio_id;
        $transmitente->save();

    }

    #[On('cargarAviso')]
    public function cargarAviso($id = null){

        if(isset($this->avisoId)){

            $this->aviso = Aviso::find($this->avisoId);

        }else{

            $this->aviso = Aviso::find($id);

        }

        if(auth()->user()->entidad->dependencia === 'Secretaría de gobernación'){

            return;

        }

    }

    public function abrirModalEditar(Actor $actor){

        $this->actor = $actor;

        $this->fecha_nacimiento = $this->actor->persona->fecha_nacimiento;
        $this->nacionalidad = $this->actor->persona->nacionalidad;
        $this->estado_civil = $this->actor->persona->estado_civil;
        $this->calle = $this->actor->persona->calle;
        $this->numero_exterior = $this->actor->persona->numero_exterior;
        $this->numero_interior = $this->actor->persona->numero_interior;
        $this->colonia = $this->actor->persona->colonia;
        $this->cp = $this->actor->persona->cp;
        $this->entidad = $this->actor->persona->entidad;
        $this->ciudad = $this->actor->persona->ciudad;
        $this->municipio = $this->actor->persona->municipio;

        $this->modal = true;

    }

    public function actualizarTransmitente(){

        try {

            $this->actor->persona->update([
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'nacionalidad' => $this->nacionalidad,
                'estado_civil' => $this->estado_civil,
                'calle' => $this->calle,
                'numero_exterior' => $this->numero_exterior,
                'numero_interior' => $this->numero_interior,
                'colonia' => $this->colonia,
                'cp' => $this->cp,
                'entidad' => $this->entidad,
                'ciudad' => $this->ciudad,
                'municipio' => $this->municipio,
            ]);

            $this->modal = false;

            $this->dispatch('mostrarMensaje', ['success', "La información se actualizó con éxito."]);

        } catch (\Throwable $th) {
            Log::error("Error al actualizar generales de trasnmitente en revision de aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

    public function cargarTransmitentesConMismoPredio($dentro_del_mes){

        $this->avisos_misma_escritura = Aviso::with('predio')
                                        ->where('avaluo_spe', $this->aviso->avaluo_spe)
                                        ->where('predio_sgc', $this->aviso->predio_sgc)
                                        ->where('entidad_id', auth()->user()->entidad_id)
                                        ->where('id', '!=', $this->aviso->id)
                                        ->get();

        if($this->avisos_misma_escritura->count() === 0) return;

        if(! $dentro_del_mes){

            $this->fuera_del_primer_mes = true;

            $this->flag_encadenamiento = false;

            return;

        }

        $this->flag_encadenamiento = true;

        $predios_ids = $this->avisos_misma_escritura->pluck('predio_id');

        $this->actores = Actor::with('persona')
                                ->whereIn('predio_id', $predios_ids)
                                ->whereIn('tipo', ['transmitente', 'adquiriente'])
                                ->get();

    }

    public function buscarCertificado(){

        $this->validate([
            'año' => 'required',
            'folio' => 'required',
            'usuario' => 'required',
        ]);

        try {

            $data = (new SGCService())->consultarPropietarios($this->año, $this->folio, $this->usuario, $this->aviso->predio_sgc);

            DB::transaction(function () use ($data){

                $this->procesarTransmitentes($data['propietarios']);

            });

            $this->cargarTransmitentesConMismoPredio($data['dentro_del_primer_mes']);

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
                    'tipo' => strlen($propietario['razon_social']) > 0 ? 'MORAL' : 'FÍSICA',
                    'nombre' => $propietario['nombre'],
                    'ap_paterno' => $propietario['ap_paterno'],
                    'ap_materno' => $propietario['ap_materno'],
                    'razon_social' => $propietario['razon_social'],
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
        return view('livewire.catastro.avisos.revision-aviso.transmitentes');
    }

}
