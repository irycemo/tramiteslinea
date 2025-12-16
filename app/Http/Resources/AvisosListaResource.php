<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvisosListaResource extends JsonResource
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
            'isai' => $this->valor_isai,
            'fecha_reduccion' => Carbon::parse($this->fecha_reduccion)->format('d/m/Y'),
            'localidad' => $this->predio->localidad,
            'oficina' => $this->predio->oficina,
            'tipo_predio' => $this->predio->tipo_predio,
            'numero_registro' => $this->predio->numero_registro,
            'notaria_numero' => $this->entidad->numero_notaria,
        ];
    }
}
