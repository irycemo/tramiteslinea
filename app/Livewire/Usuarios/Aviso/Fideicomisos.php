<?php

namespace App\Livewire\Usuarios\Aviso;

use App\Models\Actor;
use App\Models\Aviso;
use App\Models\Persona;
use Livewire\Component;
use App\Constantes\Constantes;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Fideicomisos extends Component
{

    public Aviso $aviso;
    public $avisoId;

    public $tipo;
    public $pp_transmitentes;
    public $pn_transmitentes;
    public $pu_transmitentes;
    public $porcentaje;
    public $porcentaje_nuda;
    public $porcentaje_usufructo;
    public $tipo_persona;
    public $nombre;
    public $ap_paterno;
    public $ap_materno;
    public $curp;
    public $rfc;
    public $razon_social;
    public $fecha_nacimiento;
    public $nacionalidad;
    public $estado_civil;
    public $calle;
    public $numero_exterior;
    public $numero_interior;
    public $colonia;
    public $ciudad;
    public $cp;
    public $entidad;
    public $municipio;

    public $actor;

    public $estados;
    public $estados_civiles;
    public $editar = false;
    public $crear = false;
    public $modal;
    public $modalBorrar;
    public $fideicomitente = false;
    public $fideicomisario = false;
    public $fiduciaria = false;

    protected function rules(){
        return [
            'tipo_persona' => 'required',
            'nombre' => [Rule::requiredIf($this->tipo_persona === 'FISICA')],
            'ap_paterno' => [Rule::requiredIf($this->tipo_persona === 'FISICA')],
            'ap_materno' => [Rule::requiredIf($this->tipo_persona === 'FISICA')],
            'curp' => [
                'nullable',
                Rule::requiredIf($this->tipo_persona === 'FISICA'),
                'regex:/^[A-Z]{1}[AEIOUX]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/i'
            ],
            'rfc' => [
                'required',
                'regex:/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/'
            ],
            'razon_social' => [Rule::requiredIf($this->tipo_persona === 'MORAL'), utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.()\/\-," ]*$/'),],
            'fecha_nacimiento' => 'nullable',
            'nacionalidad' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'estado_civil' => 'nullable',
            'calle' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'numero_exterior' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'numero_interior' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'colonia' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'cp' => 'nullable|numeric',
            'ciudad' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'entidad' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'municipio' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.descripcion_fideicomiso' => 'nullable'
        ];
    }

    protected $listeners = ['cargarAviso'];

    public function crearModeloVacio(){
        $this->aviso = Aviso::make(['estado' => 'nuevo']);
    }

    public function cargarAviso($id){

        $this->aviso = Aviso::find($id);

    }

    public function resetear(){

        $this->reset([
            'tipo_persona',
            'nombre',
            'ap_paterno',
            'ap_materno',
            'curp',
            'rfc',
            'razon_social',
            'fecha_nacimiento',
            'nacionalidad',
            'estado_civil',
            'calle',
            'numero_exterior',
            'numero_interior',
            'colonia',
            'cp',
            'entidad',
            'municipio',
            'modal',
            'fideicomitente',
            'fideicomisario',
            'fiduciaria',
        ]);
    }

    public function agregarFideicomitente(){

        if(!$this->aviso->getKey()){

            $this->dispatch('mostrarMensaje', ['error', "Primero debe cargar el aviso."]);

            return;

        }

        $this->resetear();

        $this->modal = true;
        $this->crear = true;
        $this->fideicomitente = true;

    }

    public function agregarFideicomisario(){

        if(!$this->aviso->getKey()){

            $this->dispatch('mostrarMensaje', ['error', "Primero debe cargar el aviso."]);

            return;

        }

        $this->resetear();

        $this->modal = true;
        $this->crear = true;
        $this->fideicomisario = true;

    }

    public function agregarFiduciaria(){

        if(!$this->aviso->getKey()){

            $this->dispatch('mostrarMensaje', ['error', "Primero debe cargar el aviso."]);

            return;

        }

        if($this->aviso->actores()->where('tipo', 'fiduciaria')->count()){

            $this->dispatch('mostrarMensaje', ['error', "Solo puede ingresar una fiduciaria."]);

            return;

        }

        $this->resetear();

        $this->modal = true;
        $this->crear = true;
        $this->fiduciaria = true;

    }

    public function guardarActor($tipo){

        $this->validate();

        try {

            DB::transaction(function () use($tipo){

                $persona = Persona::where('rfc', $this->rfc)->first();

                if($persona != null){

                    $actor = $this->aviso->actores()->where('persona_id', $persona->id)->first();

                    if($actor){

                        $this->dispatch('mostrarMensaje', ['error', "La persona ya es un " . $actor->tipo . '.']);

                        return;

                    }

                }else{

                    $persona = Persona::create([
                        'tipo' => $this->tipo_persona,
                        'nombre' => $this->nombre,
                        'ap_paterno' => $this->ap_paterno,
                        'ap_materno' => $this->ap_materno,
                        'curp' => $this->curp,
                        'rfc' => $this->rfc,
                        'razon_social' => $this->razon_social,
                        'fecha_nacimiento' => $this->fecha_nacimiento,
                        'nacionalidad' => $this->nacionalidad,
                        'estado_civil' => $this->estado_civil,
                        'calle' => $this->calle,
                        'numero_exterior' => $this->numero_exterior,
                        'numero_interior' => $this->numero_interior,
                        'colonia' => $this->colonia,
                        'ciudad' => $this->ciudad,
                        'cp' => $this->cp,
                        'entidad' => $this->entidad,
                        'municipio' => $this->municipio,
                        'creado_por' => auth()->id()
                    ]);

                }

                $this->aviso->actores()->create([
                    'persona_id' => $persona->id,
                    'tipo' => $tipo,
                    'creado_por' => auth()->id()
                ]);

                $this->dispatch('mostrarMensaje', ['success', "El " . $tipo . " se guardó con éxito."]);

                $this->resetear();

            });

        } catch (\Throwable $th) {

            Log::error("Error al guardar " . $tipo . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function editarActor(Actor $actor){

        $this->resetear();

        $this->actor = $actor;

        $this->tipo = $this->actor->tipo;
        $this->porcentaje = $this->actor->porcentaje;
        $this->porcentaje_nuda = $this->actor->porcentaje_nuda;
        $this->porcentaje_usufructo = $this->actor->porcentaje_usufructo;
        $this->tipo_persona = $this->actor->persona->tipo;
        $this->nombre = $this->actor->persona->nombre;
        $this->ap_paterno = $this->actor->persona->ap_paterno;
        $this->ap_materno = $this->actor->persona->ap_materno;
        $this->curp = $this->actor->persona->curp;
        $this->rfc = $this->actor->persona->rfc;
        $this->razon_social = $this->actor->persona->razon_social;
        $this->fecha_nacimiento = $this->actor->persona->fecha_nacimiento;
        $this->nacionalidad = $this->actor->persona->nacionalidad;
        $this->estado_civil = $this->actor->persona->estado_civil;
        $this->calle = $this->actor->persona->calle;
        $this->numero_exterior = $this->actor->persona->numero_exterior;
        $this->numero_interior = $this->actor->persona->numero_interior;
        $this->colonia = $this->actor->persona->colonia;
        $this->cp = $this->actor->persona->cp;
        $this->entidad = $this->actor->persona->entidad;
        $this->municipio = $this->actor->persona->municipio;

        if($this->actor->tipo === 'fideicomitente')
            $this->modal = true;

        $this->crear = false;

        $this->editar = true;

    }

    public function actualizarActor(){

        $this->validate();

        try {

            DB::transaction(function () {

                $this->actor->persona->update([
                    'fecha_nacimiento' => $this->fecha_nacimiento,
                    'nacionalidad' => $this->nacionalidad,
                    'estado_civil' => $this->estado_civil,
                    'calle' => $this->calle,
                    'numero_exterior' => $this->numero_exterior,
                    'numero_interior' => $this->numero_interior,
                    'colonia' => $this->colonia,
                    'ciudad' => $this->ciudad,
                    'cp' => $this->cp,
                    'entidad' => $this->entidad,
                    'municipio' => $this->municipio,
                    'actualizado_por' => auth()->id()
                ]);

                $this->actor->update([
                    'actualizado_por' => auth()->id()
                ]);

                $this->dispatch('mostrarMensaje', ['success', "La información se actualizó con éxito."]);

                $this->resetear();

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualizar actor por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function borrarActor($id){

        try {

            Actor::destroy($id);

            $this->dispatch('mostrarMensaje', ['success', "La información se eliminó con éxito."]);

            $this->resetear();

        } catch (\Throwable $th) {

            Log::error("Error al borrar en fideicomisos por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function agregarDescripcion(){

        $this->validate([
            'aviso.descripcion_fideicomiso' => 'required'
        ],
        [],
        ['aviso.descripcion_fideicomiso' => 'objeto principal del fideicomiso']);

        try {

            $this->aviso->actualizado_por = auth()->id();
            $this->aviso->save();

            $this->dispatch('mostrarMensaje', ['success', "La información se guardó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al guardar comentario en fideicomisos por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        if($this->avisoId){

            $this->cargarAviso($this->avisoId);

        }else{

            $this->crearModeloVacio();

        }

        $this->estados = Constantes::ESTADOS;

        $this->estados_civiles = Constantes::ESTADO_CIVIL;

    }

    public function render()
    {
        return view('livewire.usuarios.aviso.fideicomisos');
    }
}
