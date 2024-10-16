<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class AvisoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'año' => $this->año,
            'folio' => $this->folio,
            'usuario' => $this->usuario,
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
            'estado' => $this->estado,
            'acto' => $this->acto,
            'fecha_ejecutoria' => $this->fecha_ejecutoria,
            'tipo_escritura' => $this->tipo_escritura,
            'numero_escritura' => $this->numero_escritura,
            'volumen_escritura' => $this->volumen_escritura,
            'lugar_otorgamiento' => $this->lugar_otorgamiento,
            'fecha_otorgamiento' => $this->fecha_otorgamiento,
            'lugar_firma' => $this->lugar_firma,
            'fecha_firma' => $this->fecha_firma,
            'tipo_vialidad' => $this->tipo_vialidad,
            'tipo_asentamiento' => $this->tipo_asentamiento,
            'nombre_vialidad' => $this->nombre_vialidad,
            'numero_exterior' => $this->numero_exterior,
            'numero_exterior_2' => $this->numero_exterior_2,
            'numero_adicional' => $this->numero_adicional,
            'numero_adicional_2' => $this->numero_adicional_2,
            'numero_interior' => $this->numero_interior,
            'nombre_asentamiento' => $this->nombre_asentamiento,
            'codigo_postal' => $this->codigo_postal,
            'lote_fraccionador' => $this->lote_fraccionador,
            'manzana_fraccionador' => $this->manzana_fraccionador,
            'etapa_fraccionador' => $this->etapa_fraccionador,
            'nombre_predio' => $this->nombre_predio,
            'nombre_edificio' => $this->nombre_edificio,
            'clave_edificio' => $this->clave_edificio,
            'departamento_edificio' => $this->departamento_edificio,
            'superficie_terreno' => $this->superficie_terreno,
            'superficie_construccion' => $this->superficie_construccion,
            'cantidad_tramitada' => $this->cantidad_tramitada,
            'descripcion_fideicomiso' => $this->descripcion_fideicomiso,
            'observaciones' => $this->observaciones,
            'valor_adquisicion' => $this->valor_adquisicion,
            'valor_catastral' => $this->valor_catastral,
            'uso_de_predio' => $this->uso_de_predio,
            'fecha_reduccion' => $this->fecha_reduccion,
            'valor_construccion_vivienda' => $this->valor_construccion_vivienda,
            'valor_construccion_otro' => $this->valor_construccion_otro,
            'porcentaje_adquisicion' => $this->porcentaje_adquisicion,
            'sin_reduccion' => $this->sin_reduccion,
            'no_genera_isai' => $this->no_genera_isai,
            'valor_base' => $this->valor_base,
            'valor_isai' => $this->valor_isai,
            'anexos' => $this->anexos,
            'xutm' => $this->xutm,
            'yutm' => $this->yutm,
            'zutm' => $this->zutm,
            'lon' => $this->lon,
            'lat' => $this->lat,
            'archivo' => Storage::disk('avisos')->url($this->archivo->url),
            'colindancias' => ColindanciaResource::collection($this->colindancias),
            'transmitentes' => TransmitenteResource::collection($this->transmitentes()),
            'adquirientes' => AdquirienteResource::collection($this->adquirientes()),
            'fiduciaria' => FiduciariaResource::collection($this->fiduciaria()),
            'fideicomitentes' => FideicomitenteResource::collection($this->fideicomitentes()),
            'fideicomisarios' => FideicomisarioResource::collection($this->fideicomisarios()),
            'entidad_id' => $this->entidad_id
        ];

    }
}
