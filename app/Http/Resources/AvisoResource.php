<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
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
            'acto' => $this->acto,
            'fecha_ejecutoria' => $this->fecha_ejecutoria,
            'tipo_escritura' => $this->tipo_escritura,
            'numero_escritura' => $this->numero_escritura,
            'volumen_escritura' => $this->volumen_escritura,
            'lugar_otorgamiento' => $this->lugar_otorgamiento,
            'fecha_otorgamiento' => $this->fecha_otorgamiento,
            'lugar_firma' => $this->lugar_firma,
            'fecha_firma' => $this->fecha_firma,
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
            'reduccion' => $this->reduccion,
            'base_gravable' => $this->base_gravable,
            'sin_reduccion' => $this->sin_reduccion,
            'no_genera_isai' => $this->no_genera_isai,
            'valor_base' => $this->valor_base,
            'valor_isai' => $this->valor_isai,
            'anexos' => $this->anexos,
            'predio'=> new PredioResource($this->predio),
            'archivo' => null
        ];

    }
}
