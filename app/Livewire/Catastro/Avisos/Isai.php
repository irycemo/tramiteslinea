<?php

namespace App\Livewire\Catastro\Avisos;

use Carbon\Carbon;
use App\Models\Aviso;
use Livewire\Component;
use App\Models\CuotaMinima;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class Isai extends Component
{

    public Aviso $aviso;
    public $avisoId;

    public $uma;
    public $cuota_minima;

    public $porcentaje_vivienda;
    public $porcentaje_otro_uso;
    public $valor_total_vivienda;
    public $valor_total_otro_uso;
    public $reduccion_vivienda;
    public $reduccion_otro_uso;
    public $fecha_reduccion;

    protected $listeners = ['cargarAviso'];

    protected function rules(){
        return [
            'aviso.valor_adquisicion' => [
                    Rule::requiredIf($this->aviso->no_genera_isai === 0),
                    'nullable',
                    'numeric',
                    'min:0'
            ],
            'aviso.uso_de_predio' => [
                Rule::requiredIf($this->aviso->no_genera_isai === 0),
                'nullable'
            ],
            'aviso.valor_construccion_vivienda' => [
                Rule::requiredIf($this->aviso->uso_de_predio === 'mixto'),
                'nullable',
                'numeric',
                'gt:0'
            ],
            'aviso.valor_construccion_otro' => [
                Rule::requiredIf($this->aviso->uso_de_predio === 'mixto'),
                'nullable',
                'numeric',
                'gt:0'
            ],
            'aviso.porcentaje_adquisicion' => 'nullable|numeric|max:100|gt:0',
            'aviso.sin_reduccion' => 'required',
            'aviso.valor_catastral' => 'required',
            'aviso.valor_base' => 'nullable',
            'aviso.fecha_reduccion' => [
                Rule::requiredIf($this->aviso->no_genera_isai === 0),
                'nullable',
                'date'
            ],
            'aviso.no_genera_isai' => 'required',
            'aviso.valor_isai' => 'nullable|numeric',
            'aviso.reduccion' => 'nullable|numeric',
            'aviso.base_gravable' => 'nullable|numeric',
        ];
    }

    public function crearModeloVacio(){
        $this->aviso = Aviso::make([
            'sin_reduccion' => false,
            'no_genera_isai' => false,
            'estado' => 'nuevo'
        ]);
    }

    #[On('cargarAviso')]
    public function cargarAviso($id){

        $this->aviso = Aviso::find($id);

    }

    public function calcularIsai(){

        $this->validate();

        $this->fecha_reduccion = Carbon::parse($this->aviso->fecha_reduccion);

        if($this->fecha_reduccion->format('Y') >= 2023){

            $this->aviso->base_gravable = max($this->aviso->valor_catastral, $this->aviso->valor_adquisicion);

        }

        $this->cuota_minima = CuotaMinima::where('municipio', 53)
                                            ->where('fecha_inicial', '<=', $this->aviso->fecha_reduccion)
                                            ->where('fecha_final', '>=', $this->aviso->fecha_reduccion)
                                            ->first();

        if($this->aviso->uso_de_predio === 'vivienda'){

            $this->aviso->reduccion = round($this->reduccionVivienda(), 2);

            if($this->aviso->sin_reduccion){

                $this->aviso->reduccion = 0;

            }

        }elseif($this->aviso->uso_de_predio === 'otro'){

            if($this->fecha_reduccion->format('Y') <= 2015){

                $this->aviso->reduccion = round($this->cuota_minima->diario * 365, 2);

            }else{

                $this->aviso->reduccion = round($this->cuota_minima->anual, 2);

            }

            if($this->aviso->sin_reduccion){

                $this->aviso->reduccion = 0;

            }

        }elseif($this->aviso->uso_de_predio === 'mixto'){

            $this->porcentaje_vivienda = ($this->aviso->valor_construccion_vivienda * 100) / ($this->aviso->valor_construccion_vivienda + $this->aviso->valor_construccion_otro);

            $this->porcentaje_otro_uso = 100 - $this->porcentaje_vivienda;

            $this->valor_total_vivienda = $this->aviso->base_gravable * ($this->porcentaje_vivienda / 100);

            $this->valor_total_otro_uso = $this->aviso->base_gravable * ($this->porcentaje_otro_uso / 100);

            $this->reduccion_vivienda = $this->reduccionVivienda() * ($this->porcentaje_vivienda / 100);

            if($this->fecha_reduccion->format('Y') <= 2015){

                $this->reduccion_otro_uso = ($this->cuota_minima->diario * 365) * ($this->porcentaje_otro_uso / 100);

            }else{

                $this->reduccion_otro_uso = $this->cuota_minima->anual * ($this->porcentaje_otro_uso / 100);

            }

            if($this->valor_total_vivienda < $this->reduccion_vivienda){

                $this->reduccion_vivienda = $this->valor_total_vivienda;

            }

            if($this->valor_total_otro_uso < $this->reduccion_otro_uso){

                $this->reduccion_otro_uso = $this->valor_total_otro_uso;

            }

            $this->aviso->reduccion = round($this->reduccion_vivienda + $this->reduccion_otro_uso, 2);

            if($this->aviso->sin_reduccion){

                $this->aviso->reduccion = 0;

            }

        }

        $this->aviso->valor_base = round($this->aviso->base_gravable - $this->aviso->reduccion, 2);

        if($this->aviso->valor_base < 0){

            $this->aviso->valor_isai = $this->cuota_minima->cuota_minima;

        }else{

            $this->aviso->valor_isai = ceil($this->aviso->valor_base * .02);

            if($this->aviso->valor_isai < $this->cuota_minima->cuota_minima)
                $this->aviso->valor_isai = $this->cuota_minima->cuota_minima;

        }

        if($this->aviso->porcentaje_adquisicion){

            $this->aviso->base_gravable = round(($this->aviso->base_gravable * $this->aviso->porcentaje_adquisicion) / 100, 2);

            $this->aviso->reduccion = round(($this->aviso->reduccion * $this->aviso->porcentaje_adquisicion) / 100, 2);

            $this->aviso->valor_base = round(($this->aviso->valor_base * $this->aviso->porcentaje_adquisicion) / 100, 2);

            $this->aviso->valor_isai = ceil(($this->aviso->valor_isai * $this->aviso->porcentaje_adquisicion) / 100);

            if($this->aviso->valor_isai < $this->cuota_minima->cuota_minima)
                $this->aviso->valor_isai = $this->cuota_minima->cuota_minima;

        }

    }

    public function reduccionVivienda(){

        if($this->fecha_reduccion->format('Y') <= 2015){

            $couta_minima_anual = $this->cuota_minima->diario * 365;

            if($this->aviso->base_gravable > 25 * $couta_minima_anual){

                return 3 * $couta_minima_anual;

            }elseif($this->aviso->base_gravable < 25 * $couta_minima_anual){

                return 15 * $couta_minima_anual;

            }

        }else{

            if($this->aviso->base_gravable > 25 * $this->cuota_minima->anual){

                return 3 * $this->cuota_minima->anual;

            }elseif($this->aviso->base_gravable < 25 * $this->cuota_minima->anual){

                return 15 * $this->cuota_minima->anual;

            }

        }

    }

    public function guardar(){

        try {

            $this->aviso->actualizado_por = auth()->id();
            $this->aviso->save();

            $this->dispatch('mostrarMensaje', ['success', "La información de guardó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al guardar isai por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

    public function mount(){

        if($this->avisoId){

            $this->cargarAviso($this->avisoId);

        }else{

            $this->crearModeloVacio();

        }

    }

    public function render()
    {
        return view('livewire.catastro.avisos.isai');
    }
}
