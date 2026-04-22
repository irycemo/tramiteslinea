<?php

namespace App\Livewire\Admin\Personas;

use App\Models\Actor;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ConciliarPersonas extends Component
{

    public $nombre;
    public $ap_paterno;
    public $ap_materno;
    public $razon_social;
    public $curp;
    public $rfc;
    public $multiple_nombre;
    public $fecha_nacimiento;
    public $nacionalidad;
    public $estado_civil;
    public $calle;
    public $numero_exterior;
    public $numero_interior;
    public $colonia;
    public $cp;
    public $ciudad;
    public $entidad;
    public $municipio;
    public $tipo;

    public $personas = [];
    public $persona;

    public $modal = false;

    protected function rules(){
        return [
            'multiple_nombre' => 'nullable',
            'nombre' => [
                Rule::requiredIf($this->tipo === 'FÍSICA')
            ],
            'ap_paterno' => 'nullable',
            'ap_materno' => 'nullable',
            'razon_social' => [Rule::requiredIf($this->tipo === 'MORAL')],
            'fecha_nacimiento' => 'nullable',
            'nacionalidad' => 'nullable',
            'estado_civil' => 'nullable',
            'calle' => 'nullable',
            'numero_exterior' => 'nullable',
            'numero_interior' => 'nullable',
            'colonia' => 'nullable',
            'cp' => 'nullable|numeric',
            'ciudad' => 'nullable',
            'entidad' => 'nullable',
            'municipio' => 'nullable',
            'tipo' => 'nullable',
         ];
    }

    public function buscarPersona(){

        if($this->rfc && $this->rfc != ''){

            $this->persona = Persona::where('rfc', $this->rfc)->first();

        }elseif($this->curp && $this->curp != ''){

            $this->persona = Persona::where('curp', $this->curp)->first();

        }

    }

    public function conciliar(){

        $this->buscarPersona();

        if($this->persona){

            $this->validate($this->rules() + [
                    'curp' => [
                    'nullable',
                    'unique:personas,curp,' . $this->persona->id,
                    'regex:/^[A-Z]{1}[AEIOUX]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/i'
                ],
                'rfc' => [
                    'nullable',
                    'unique:personas,rfc,' . $this->persona->id,
                    'regex:/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/'
                ],
            ]);

        }else{

            $this->validate($this->rules() + [
                    'curp' => [
                    'nullable',
                    'unique:personas,curp',
                    'regex:/^[A-Z]{1}[AEIOUX]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/i'
                ],
                'rfc' => [
                    'nullable',
                    'unique:personas,rfc',
                    'regex:/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/'
                ],
            ]);

        }

        try {

            $personas_ids = $this->personas->pluck('id');

            $propietarios = Actor::whereIn('persona_id', $personas_ids)->get();

            DB::transaction(function () use ($personas_ids, $propietarios){

                if($this->persona){

                    $this->persona->update([
                        'nombre' => $this->nombre,
                        'ap_paterno' => $this->ap_paterno,
                        'ap_materno' => $this->ap_materno,
                        'razon_social' => $this->razon_social,
                        'curp' => $this->curp,
                        'rfc' => $this->rfc,
                        'multiple_nombre' => $this->multiple_nombre,
                        'fecha_nacimiento' => $this->fecha_nacimiento,
                        'nacionalidad' => $this->nacionalidad,
                        'estado_civil' => $this->estado_civil,
                        'calle' => $this->calle,
                        'numero_exterior' => $this->numero_exterior,
                        'numero_interior' => $this->numero_interior,
                        'colonia' => $this->colonia,
                        'cp' => $this->cp,
                        'ciudad' => $this->ciudad,
                        'entidad' => $this->entidad,
                        'municipio' => $this->municipio,
                        'tipo' => $this->tipo,
                    ]);

                    foreach ($propietarios as $propietario) {

                        $propietario->update([
                            'persona_id' => $this->persona->id
                        ]);

                    }

                }else{

                    $nueva_persona = Persona::create([
                        'nombre' => $this->nombre,
                        'ap_paterno' => $this->ap_paterno,
                        'ap_materno' => $this->ap_materno,
                        'razon_social' => $this->razon_social,
                        'curp' => $this->curp,
                        'rfc' => $this->rfc,
                        'multiple_nombre' => $this->multiple_nombre,
                        'fecha_nacimiento' => $this->fecha_nacimiento,
                        'nacionalidad' => $this->nacionalidad,
                        'estado_civil' => $this->estado_civil,
                        'calle' => $this->calle,
                        'numero_exterior' => $this->numero_exterior,
                        'numero_interior' => $this->numero_interior,
                        'colonia' => $this->colonia,
                        'cp' => $this->cp,
                        'ciudad' => $this->ciudad,
                        'entidad' => $this->entidad,
                        'municipio' => $this->municipio,
                        'tipo' => $this->tipo,
                    ]);

                    foreach ($propietarios as $propietario) {

                        $propietario->update([
                            'persona_id' => $nueva_persona->id
                        ]);

                    }

                }

                Persona::destroy($personas_ids);

            });

            $this->dispatch('mostrarMensaje', ['success', "La concliación se realizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al conciliar persona usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function quitarPersona($key){

        $this->personas->forget($key);

    }

    public function buscar(){

        $this->personas = Persona::with('creadoPor:id,name', 'actualizadoPor:id,name')
                                    ->when($this->nombre && $this->nombre != '', function($q){
                                        $q->where('nombre', 'like', '%' .$this->nombre . '%');
                                    })
                                    ->when($this->ap_materno && $this->ap_materno != '', function($q){
                                        $q->where('ap_materno', 'like', '%' .$this->ap_materno . '%');
                                    })
                                    ->when($this->ap_paterno && $this->ap_paterno != '', function($q){
                                        $q->where('ap_paterno', 'like', '%' .$this->ap_paterno . '%');
                                    })
                                    ->when($this->razon_social && $this->razon_social != '', function($q){
                                        $q->where('razon_social', 'like', '%' .$this->razon_social . '%');
                                    })
                                    ->get();

    }

    public function render()
    {
        return view('livewire.admin.personas.conciliar-personas')->extends('layouts.admin');
    }

}
