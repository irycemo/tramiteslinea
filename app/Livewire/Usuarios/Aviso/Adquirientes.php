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
use Illuminate\Validation\ValidationException;

class Adquirientes extends Component
{

    public Aviso $aviso;
    public $avisoId;

    public $tipo_propietario;
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
    public $numero_exterior_propietario;
    public $numero_interior_propietario;
    public $colonia;
    public $ciudad;
    public $cp;
    public $entidad;
    public $municipio_propietario;
    public $correo;

    public $adquiriente;

    public $estados;
    public $estados_civiles;
    public $editar = false;
    public $crear = false;
    public $modal;
    public $modalBorrar;

    protected function rules(){
        return [
            'porcentaje' => ['numeric', 'max:100', 'nullable', Rule::requiredIf($this->porcentaje_nuda === null && $this->porcentaje_usufructo === null)],
            'porcentaje_nuda' => 'nullable|numeric|max:100',
            'porcentaje_usufructo' => 'nullable|numeric|max:100',
            'tipo_persona' => 'required',
            'correo' => 'nullable',
            'nombre' => [Rule::requiredIf($this->tipo_persona === 'FÍSICA')],
            'ap_paterno' => [Rule::requiredIf($this->tipo_persona === 'FÍSICA')],
            'ap_materno' => [Rule::requiredIf($this->tipo_persona === 'FÍSICA')],
            'curp' => [
                'nullable',
                Rule::requiredIf($this->tipo_persona === 'FÍSICA'),
                'regex:/^[A-Z]{1}[AEIOUX]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/i'
            ],
            'rfc' => [
                'nullable',
                'regex:/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/'
            ],
            'razon_social' => ['nullable', Rule::requiredIf($this->tipo_persona === 'MORAL'), utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.()\/\-," ]*$/')],
            'fecha_nacimiento' => 'nullable',
            'nacionalidad' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'estado_civil' => 'nullable',
            'calle' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'numero_exterior_propietario' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'numero_interior_propietario' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'colonia' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'cp' => 'nullable|numeric',
            'ciudad' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'entidad' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'municipio_propietario' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
        ];
    }

    protected $listeners = ['cargarAviso'];

    public function updated($property, $value){

        if(in_array($property, ['porcentaje_nuda', 'porcentaje_usufructo', 'porcentaje']) && $value == ''){

            $this->$property = null;

        }

        if(in_array($property, ['porcentaje_nuda', 'porcentaje_usufructo'])){

            $this->reset('porcentaje');

        }elseif($property == 'porcentaje'){

            $this->reset(['porcentaje_nuda', 'porcentaje_usufructo']);

        }

    }

    public function updatedTipoPersona(){

        if($this->tipo_persona == 'FÍSICA'){

            $this->reset('razon_social');

        }elseif($this->tipo_persona == 'MORAL'){

            $this->reset([
                'nombre',
                'ap_paterno',
                'ap_materno',
                'curp',
                'fecha_nacimiento',
                'estado_civil',
                'rfc'
            ]);

        }

    }

    public function crearModeloVacio(){
        $this->aviso = Aviso::make(['estado' => 'nuevo']);
    }

    public function cargarPorcentajes(){

        $this->pn_transmitentes = 0;

        $this->pu_transmitentes = 0;

        $this->pp_transmitentes = 0;

        foreach($this->aviso->transmitentes() as $transmitente){

            $this->pn_transmitentes = $this->pn_transmitentes + $transmitente->porcentaje_nuda;

            $this->pu_transmitentes = $this->pu_transmitentes + $transmitente->porcentaje_usufructo;

            $this->pp_transmitentes = $this->pp_transmitentes + $transmitente->porcentaje;

        }

        $this->pn_transmitentes = round($this->pn_transmitentes, 2);

        $this->pu_transmitentes = round($this->pu_transmitentes, 2);

        $this->pp_transmitentes = round($this->pp_transmitentes, 2);

    }

    public function cargarAviso($id){

        $this->aviso = Aviso::find($id);

        $this->cargarPorcentajes();

    }

    public function resetear(){

        $this->reset([
            'tipo_propietario',
            'porcentaje_nuda',
            'porcentaje_usufructo',
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
            'numero_exterior_propietario',
            'numero_interior_propietario',
            'colonia',
            'cp',
            'entidad',
            'municipio_propietario',
            'modal',
        ]);
    }

    public function agregarAdquiriente(){

        if(!$this->aviso->getKey()){

            $this->dispatch('mostrarMensaje', ['error', "Primero debe cargar el aviso."]);

            return;

        }

        if(!$this->aviso->transmitentes()->count()){

            $this->dispatch('mostrarMensaje', ['error', "Primero debe cargar los transmitentes."]);

            return;

        }

        $this->cargarPorcentajes();

        $this->modal = true;
        $this->crear = true;

    }

    public function editarAdquiriente(Actor $actor){

        $this->resetear();

        $this->adquiriente = $actor;

        $this->tipo_propietario = $this->adquiriente->tipo;
        $this->porcentaje = $this->adquiriente->porcentaje;
        $this->porcentaje_nuda = $this->adquiriente->porcentaje_nuda;
        $this->porcentaje_usufructo = $this->adquiriente->porcentaje_usufructo;
        $this->tipo_persona = $this->adquiriente->persona->tipo;
        $this->nombre = $this->adquiriente->persona->nombre;
        $this->ap_paterno = $this->adquiriente->persona->ap_paterno;
        $this->ap_materno = $this->adquiriente->persona->ap_materno;
        $this->curp = $this->adquiriente->persona->curp;
        $this->rfc = $this->adquiriente->persona->rfc;
        $this->razon_social = $this->adquiriente->persona->razon_social;
        $this->fecha_nacimiento = $this->adquiriente->persona->fecha_nacimiento;
        $this->nacionalidad = $this->adquiriente->persona->nacionalidad;
        $this->estado_civil = $this->adquiriente->persona->estado_civil;
        $this->calle = $this->adquiriente->persona->calle;
        $this->numero_exterior_propietario = $this->adquiriente->persona->numero_exterior;
        $this->numero_interior_propietario = $this->adquiriente->persona->numero_interior;
        $this->colonia = $this->adquiriente->persona->colonia;
        $this->cp = $this->adquiriente->persona->cp;
        $this->entidad = $this->adquiriente->persona->entidad;
        $this->municipio_propietario = $this->adquiriente->persona->municipio;
        $this->correo = $this->adquiriente->persona->correo;

        $this->modal = true;

        $this->crear = false;

        $this->editar = true;

    }

    public function actualizarActor(){

        $this->validate([
            'porcentaje' => ['numeric', 'max:100', 'nullable', Rule::requiredIf($this->porcentaje_nuda === null && $this->porcentaje_usufructo === null)],
            'porcentaje_nuda' => 'nullable|numeric|max:100',
            'porcentaje_usufructo' => 'nullable|numeric|max:100',
            'correo' => 'nullable|unique:personas,correo,' . $this->adquiriente->persona->id,
            'tipo_persona' => 'required',
            'nombre' => [Rule::requiredIf($this->tipo_persona === 'FÍSICA')],
            'ap_paterno' => [Rule::requiredIf($this->tipo_persona === 'FÍSICA')],
            'ap_materno' => [Rule::requiredIf($this->tipo_persona === 'FÍSICA')],
            'curp' => [
                'nullable',
                'regex:/^[A-Z]{1}[AEIOUX]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/i',
            ],
            'rfc' => [
                'nullable',
                'regex:/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/',
            ],
            'razon_social' => ['nullable', Rule::requiredIf($this->tipo_persona === 'MORAL')],
            'fecha_nacimiento' => 'nullable',
            'nacionalidad' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'estado_civil' => 'nullable',
            'calle' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'numero_exterior_propietario' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'numero_interior_propietario' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'colonia' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'cp' => 'nullable|numeric',
            'ciudad' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'entidad' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'municipio_propietario' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
        ]);

        if($this->revisarProcentajes($this->adquiriente->id)) return;

        $persona = Persona::query()
                        ->where(function($q){
                            $q->when($this->nombre, fn($q) => $q->where('nombre', $this->nombre))
                                ->when($this->ap_paterno, fn($q) => $q->where('ap_paterno', $this->ap_paterno))
                                ->when($this->ap_materno, fn($q) => $q->where('ap_materno', $this->ap_materno));
                        })
                        ->when($this->razon_social, fn($q) => $q->orWhere('razon_social', $this->razon_social))
                        ->when($this->rfc, fn($q) => $q->orWhere('rfc', $this->rfc))
                        ->when($this->curp, fn($q) => $q->orWhere('curp', $this->curp))
                        ->when($this->correo, fn($q) => $q->orWhere('correo', $this->correo))
                        ->first();

        try {

            DB::transaction(function () use($persona){

                if($persona){

                    $this->adquiriente->persona->update([
                        'tipo' => $this->tipo_persona,
                        'nombre' => $this->nombre,
                        'ap_paterno' => $this->ap_paterno,
                        'ap_materno' => $this->ap_materno,
                        'razon_social' => $this->razon_social,
                        'fecha_nacimiento' => $this->fecha_nacimiento,
                        'nacionalidad' => $this->nacionalidad,
                        'estado_civil' => $this->estado_civil,
                        'calle' => $this->calle,
                        'rfc' => $this->rfc,
                        'curp' => $this->curp,
                        'numero_exterior' => $this->numero_exterior_propietario,
                        'numero_interior' => $this->numero_interior_propietario,
                        'colonia' => $this->colonia,
                        'ciudad' => $this->ciudad,
                        'cp' => $this->cp,
                        'correo' => $this->correo,
                        'entidad' => $this->entidad,
                        'municipio' => $this->municipio_propietario,
                        'actualizado_por' => auth()->id()
                    ]);

                }else{

                    $this->validate([
                        'correo' => 'nullable|unique:personas,correo',
                        'curp' => 'nullable|unique:personas,curp',
                        'rfc' => 'nullable|unique:personas,rfc',
                    ]);

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
                        'numero_exterior' => $this->numero_exterior_propietario,
                        'numero_interior' => $this->numero_interior_propietario,
                        'colonia' => $this->colonia,
                        'ciudad' => $this->ciudad,
                        'correo' => $this->correo,
                        'cp' => $this->cp,
                        'entidad' => $this->entidad,
                        'municipio' => $this->municipio_propietario,
                        'creado_por' => auth()->id()
                    ]);

                }

                $this->adquiriente->update([
                    'persona_id' => $persona->id,
                    'porcentaje' => $this->porcentaje,
                    'porcentaje_nuda' => $this->porcentaje_nuda,
                    'porcentaje_usufructo' => $this->porcentaje_usufructo,
                    'actualizado_por' => auth()->id()
                ]);

                $this->dispatch('mostrarMensaje', ['success', "La información se actualizó con éxito."]);

                $this->resetear();

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualizar adquiriente por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function revisarProcentajes($id = null){

        $pn_adquirientes = 0;

        $pu_adquirientes = 0;

        $pp_adquirientes = 0;

        foreach($this->aviso->adquirientes() as $adquiriente){

            if($id == $adquiriente->id) continue;

            $pn_adquirientes = $pn_adquirientes + $adquiriente->porcentaje_nuda;

            $pu_adquirientes = $pu_adquirientes + $adquiriente->porcentaje_usufructo;

            $pp_adquirientes = $pp_adquirientes + $adquiriente->porcentaje;

        }

        if(((float)$this->porcentaje + $pp_adquirientes) > $this->pp_transmitentes){

            $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes de propiedad no puede exceder el " . $this->pp_transmitentes . '%.']);

            return true;

        }

        if(((float)$this->porcentaje_nuda + $pn_adquirientes) > $this->pn_transmitentes){

            $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes de nuda no puede exceder el " . $this->pn_transmitentes . '%.']);

            return true;

        }

        if(((float)$this->porcentaje_usufructo + $pu_adquirientes) > $this->pu_transmitentes){

            $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes de usufructo no puede exceder el " . $this->pu_transmitentes . '%.']);

            return true;

        }

    }

    public function guardarAdquiriente(){

        $this->validate();

        if($this->revisarProcentajes())  return;

        try {

            DB::transaction(function () {

                $persona = Persona::query()
                                    ->where(function($q){
                                        $q->when($this->nombre, fn($q) => $q->where('nombre', $this->nombre))
                                            ->when($this->ap_paterno, fn($q) => $q->where('ap_paterno', $this->ap_paterno))
                                            ->when($this->ap_materno, fn($q) => $q->where('ap_materno', $this->ap_materno));
                                    })
                                    ->when($this->razon_social, fn($q) => $q->orWhere('razon_social', $this->razon_social))
                                    ->when($this->rfc, fn($q) => $q->orWhere('rfc', $this->rfc))
                                    ->when($this->curp, fn($q) => $q->orWhere('curp', $this->curp))
                                    ->first();

                if(!$persona){

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
                        'numero_exterior' => $this->numero_exterior_propietario,
                        'numero_interior' => $this->numero_interior_propietario,
                        'colonia' => $this->colonia,
                        'ciudad' => $this->ciudad,
                        'correo' => $this->correo,
                        'cp' => $this->cp,
                        'entidad' => $this->entidad,
                        'municipio' => $this->municipio_propietario,
                        'creado_por' => auth()->id()
                    ]);

                }else{

                    $this->validate([
                        'correo' => 'nullable|unique:personas,correo,' . $persona->id,
                        'curp' => 'nullable|unique:personas,curp,' . $persona->id,
                        'rfc' => 'nullable|unique:personas,rfc,' . $persona->id,
                    ]);

                    $persona->update([
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
                        'numero_exterior' => $this->numero_exterior_propietario,
                        'numero_interior' => $this->numero_interior_propietario,
                        'colonia' => $this->colonia,
                        'ciudad' => $this->ciudad,
                        'correo' => $this->correo,
                        'cp' => $this->cp,
                        'entidad' => $this->entidad,
                        'municipio' => $this->municipio_propietario,
                        'actualizado_por' => auth()->id()
                    ]);

                }

                if($this->aviso->actores()->where('persona_id', $persona->id)->first()){

                    $this->dispatch('mostrarMensaje', ['error', "La persona ya esta relacionada a este aviso."]);

                    return;

                }

                $this->aviso->actores()->create([
                    'persona_id' => $persona->id,
                    'tipo' => 'adquiriente',
                    'porcentaje' => $this->porcentaje,
                    'porcentaje_nuda' => $this->porcentaje_nuda,
                    'porcentaje_usufructo' => $this->porcentaje_usufructo,
                    'creado_por' => auth()->id()
                ]);

                $this->dispatch('mostrarMensaje', ['success', "El adquiriente se guardó con éxito."]);

                $this->resetear();

            });

        } catch (ValidationException $th) {

            $this->dispatch('mostrarMensaje', ['error', $th->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al guardar adquiriente por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function borrarAdquiriente($id){

        try {

            $actor = Actor::destroy($id);

            $this->dispatch('mostrarMensaje', ['success', "La información se eliminó con éxito."]);

            $this->resetear();

        } catch (\Throwable $th) {

            Log::error("Error al borrar adquiriente por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
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
        return view('livewire.usuarios.aviso.adquirientes');
    }
}
