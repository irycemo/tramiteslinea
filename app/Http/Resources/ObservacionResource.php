<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ObservacionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'estado' => $this->esatdo,
            'observacion' => $this->observacion,
            'tipo_tramite' => $this->tipo_tramite,
            'tramite_id' => $this->tramite_sgc,
            'oficina_id' => $this->oficina_sgc,
            'aviso_id' => $this->aviso_id,
            'entidad_id' => $this->entidad_id,
        ];

    }
}
