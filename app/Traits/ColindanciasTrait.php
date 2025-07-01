<?php

namespace App\Traits;

use App\Models\Colindancia;
use App\Models\Colindancias;

trait ColindanciasTrait
{

    public $vientos;

    public $medidas = [];

    private $rulesColindancias = [
        'medidas.*' => 'required',
        'medidas.*.viento' => 'required|string',
        'medidas.*.longitud' => [
                                    'required',
                                    'numeric',
                                    'min:0',
                                ],
        'medidas.*.descripcion' => 'required',
    ];

    protected $validationAttributesColindancias  = [
        'medidas.*.viento' => 'viento',
        'medidas.*.longitud' => 'longitud',
        'medidas.*.descripcion' => 'descripción',
    ];

    public function agregarColindancia(){

        $this->medidas[] = ['viento' => null, 'longitud' => null, 'descripcion' => null, 'id' => null];

    }

    public function borrarColindancia($index){

        unset($this->medidas[$index]);

        $this->medidas = array_values($this->medidas);

    }

    public function cargarColindancias($predio){

        $this->reset('medidas');

        foreach ($predio->colindancias as $colindancia) {

            $this->medidas[] = [
                'id' => $colindancia->id,
                'viento' => $colindancia->viento,
                'longitud' => $colindancia->longitud,
                'descripcion' => $colindancia->descripcion,
            ];

        }

    }

    public function guardarColindancias($predio){

        $ids = collect($this->medidas)->whereNotNull('id')->pluck('id');

        if(count($ids) == 0){

            $colindanciasBorrar = $predio->colindancias()->delete();

        }else{

            $colindanciasBorrar = $predio->colindancias()->whereNotIn('id', $ids)->get();

            foreach ($colindanciasBorrar as $colindancia) {

                $colindancia->delete();

            }

        }

        foreach ($this->medidas as $key =>$medida) {

            if($medida['id'] == null){

                $aux = $predio->colindancias()->create([
                    'viento' => $medida['viento'],
                    'longitud' => $medida['longitud'],
                    'descripcion' => $medida['descripcion'],
                ]);

                $this->medidas[$key]['id'] = $aux->id;

            }else{

                Colindancias::find($medida['id'])->update([
                    'viento' => $medida['viento'],
                    'longitud' => $medida['longitud'],
                    'descripcion' => $medida['descripcion'],
                    'predio_id' => $predio->id
                ]);

            }

        }

    }

    public function copiarColindancias($predio, $id){

        foreach ($predio->colindancias as $colindancia) {

            $colindancia->update(['predio_id' => $id]);

        }

        $this->cargarColindancias($predio);

    }

}
