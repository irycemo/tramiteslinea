<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FideicomisarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'tipo_persona' => $this->persona->tipo,
            'nombre' => $this->persona->nombre,
            'ap_paterno' => $this->persona->ap_paterno,
            'ap_materno' => $this->persona->ap_materno,
            'curp' => $this->persona->curp,
            'rfc' => $this->persona->rfc,
            'razon_social' => $this->persona->razon_social,
        ];
    }
}
