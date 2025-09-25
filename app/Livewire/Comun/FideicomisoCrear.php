<?php

namespace App\Livewire\Comun;

use App\Models\Actor;
use App\Models\Persona;
use Livewire\Component;
use App\Traits\ActoresTrait;
use App\Traits\BuscarPersonaTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;

class FideicomisoCrear extends Component
{

    use ActoresTrait;
    use BuscarPersonaTrait;

    protected function rules(){

        return $this->traitRules() +[
            'curp' => [
                'nullable',
                'regex:/^[A-Z]{1}[AEIOUX]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/i'
            ],
            'rfc' => [
                'nullable',
                'regex:/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/'
            ],
            'sub_tipo' => 'required'
        ];

    }

    public function updated($property, $value){

        if(is_string($value)){

            if($value === ''){

                $this->{$property} = null;

            }else{

                $this->{$property} = trim($value);

            }

        }

    }

    public function guardar(){

        $this->validate();

        try {

            $persona = $this->buscarPersona($this->rfc, $this->curp, $this->tipo_persona, $this->nombre, $this->ap_materno, $this->ap_paterno, $this->razon_social);

            if($this->persona->getKey() && $persona){

                $this->revisarActorExistente($persona->id);

                $this->modelo->actores()->create([
                    'persona_id' => $persona->id,
                    'tipo' => $this->sub_tipo,
                    'creado_por' => auth()->id()
                ]);

            }elseif($persona){

                foreach($this->modelo->actores as $actor){

                    $this->revisarActorExistente($persona->id);

                }

                throw new GeneralException('Ya existe un persona registrada con la información ingresada.');

            }else{

                DB::transaction(function () {

                    $persona = Persona::create([
                        'tipo' => $this->tipo_persona,
                        'nombre' => $this->nombre,
                        'multiple_nombre' => $this->multiple_nombre,
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
                        'cp' => $this->cp,
                        'entidad' => $this->entidad,
                        'ciudad' => $this->ciudad,
                        'municipio' => $this->municipio,
                    ]);

                    $this->modelo->actores()->create([
                        'persona_id' => $persona->id,
                        'tipo' => $this->sub_tipo,
                        'creado_por' => auth()->id()
                    ]);

                });

            }

            $this->resetearTodo();

            $this->dispatch('mostrarMensaje', ['success', "El actor se creó con éxito."]);

            $this->dispatch('refresh');


        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['error', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al crear actor de fideicomiso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function actualizar(){

        $this->validate();

        try {

            $persona = $this->buscarPersona($this->rfc, $this->curp, $this->tipo_persona, $this->nombre, $this->ap_materno, $this->ap_paterno, $this->razon_social);

            if($persona && ($persona->id != $this->persona->id)){

                throw new GeneralException("Ya existe una persona con el RFC o CURP ingresada.");

            }else{

                $this->persona->update([
                    'curp' => $this->curp,
                    'rfc' => $this->rfc,
                    'estado_civil' => $this->estado_civil,
                    'calle' => $this->calle,
                    'numero_exterior' => $this->numero_exterior,
                    'numero_interior' => $this->numero_interior,
                    'colonia' => $this->colonia,
                    'cp' => $this->cp,
                    'ciudad' => $this->ciudad,
                    'entidad' => $this->entidad,
                    'nacionalidad' => $this->nacionalidad,
                    'municipio' => $this->municipio,
                    'actualizado_por' => auth()->id()
                ]);

            }

            $this->dispatch('mostrarMensaje', ['success', "La persona se actualizó con éxito."]);

            $this->dispatch('refresh');


        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['error', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar actor de fideicomiso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function revisarActorExistente($personaId){

        if($this->sub_tipo == 'FIDUCIARIA'){

            $actor = $this->modelo->actores()->where('persona_id', $personaId)->whereIn('tipo', ['FIDUCIARIA', 'FIDEICOMITENTE'])->first();

            if($actor) throw new GeneralException('La persona ya es un actor.');

        }elseif($this->sub_tipo == 'FIDEICOMITENTE'){

            $actor = $this->modelo->actores()->where('persona_id', $personaId)->where('tipo', 'FIDEICOMITENTE')->first();

            if($actor) throw new GeneralException('La persona ya es un fideicomitente.');

        }elseif($this->sub_tipo == 'FIDEICOMISARIO'){

            $actor = $this->modelo->actores()->where('persona_id', $personaId)->whereIn('tipo', ['FIDUCIARIA', 'FIDEICOMITENTE'])->first();

            if($actor) throw new GeneralException('La persona ya es un actor.');

        }

    }

    public function mount(){

        $this->actor = Actor::make();

        $this->persona = Persona::make();

    }
    public function render()
    {
        return view('livewire.comun.fideicomiso-crear');
    }
}
