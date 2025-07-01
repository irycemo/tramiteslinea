<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ActorResource;
use App\Http\Resources\ColindanciaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PredioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'estado' => $this->estado,
            'region_catastral' => $this->region_catastral,
            'municipio' => $this->municipio,
            'zona_catastral' => $this->zona_catastral,
            'localidad' => $this->localidad,
            'sector' => $this->sector,
            'manzana' => $this->manzana,
            'predio' => $this->predio,
            'edificio' => $this->edificio,
            'departamento' => $this->departamento,
            'oficina' => $this->oficina,
            'tipo_predio' => $this->tipo_predio,
            'numero_registro' => $this->numero_registro,
            'codigo_postal' => $this->codigo_postal,
            'nombre_asentamiento' => $this->nombre_asentamiento,
            'tipo_asentamiento' => $this->tipo_asentamiento,
            'tipo_vialidad' => $this->tipo_vialidad,
            'nombre_vialidad' => $this->nombre_vialidad,
            'numero_exterior' => $this->numero_exterior,
            'numero_exterior_2' => $this->numero_exterior_2,
            'numero_interior' => $this->numero_interior,
            'numero_adicional' => $this->numero_adicional,
            'numero_adicional_2' => $this->numero_adicional_2,
            'lote_fraccionador' => $this->lote_fraccionador,
            'manzana_fraccionador' => $this->manzana_fraccionador,
            'etapa_fraccionador' => $this->etapa_fraccionador,
            'nombre_edificio' => $this->nombre_edificio,
            'clave_edificio' => $this->clave_edificio,
            'departamento_edificio' => $this->departamento_edificio,
            'nombre_predio' => $this->nombre_predio,
            'xutm' => $this->xutm,
            'yutm' => $this->yutm,
            'zutm' => $this->zutm,
            'lon' => $this->lon,
            'lat' => $this->lat,
            'uso_1' => $this->uso_1,
            'uso_2' => $this->uso_2,
            'uso_3' => $this->uso_3,
            'superficie_terreno' => $this->superficie_terreno,
            'area_comun_terreno' => $this->area_comun_terreno,
            'superficie_construccion' => $this->superficie_construccion,
            'area_comun_construccion' => $this->area_comun_construccion,
            'valor_total_terreno' => $this->valor_total_terreno,
            'valor_total_construccion' => $this->valor_total_construccion,
            'valor_catastral' => $this->valor_catastral,
            'colindancias' => ColindanciaResource::collection($this->colindancias),
            'transmitentes' => ActorResource::collection($this->transmitentes()),
            'adquirientes' => ActorResource::collection($this->adquirientes()),
            'fiduciarias' => ActorResource::collection($this->fiduciarias()),
            'fideicomitentes' => ActorResource::collection($this->fideicomitentes()),
            'fideicomisarios' => ActorResource::collection($this->fideicomisarios()),
        ];

    }
}
