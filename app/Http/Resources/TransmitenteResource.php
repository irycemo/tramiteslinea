<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransmitenteResource extends JsonResource
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
            'tipo_persona' => $this->persona->tipo,
            'nombre' => $this->persona->nombre,
            'ap_paterno' => $this->persona->ap_paterno,
            'ap_materno' => $this->persona->ap_materno,
            'curp' => $this->persona->curp,
            'rfc' => $this->persona->rfc,
            'razon_social' => $this->persona->razon_social,
            'porcentaje' => $this->porcentaje,
            'porcentaje_nuda' => $this->porcentaje_nuda,
            'porcentaje_usufructo' => $this->porcentaje_usufructo,
        ];
    }
}
