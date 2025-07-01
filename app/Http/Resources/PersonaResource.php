<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'tipo' => $this->tipo,
            'nombre' => $this->nombre,
            'multiple_nombre' => $this->multiple_nombre,
            'ap_paterno' => $this->ap_paterno,
            'ap_materno' => $this->ap_materno,
            'curp' => $this->curp,
            'rfc' => $this->rfc,
            'razon_social' => $this->razon_social,
            'nacionalidad' => $this->nacionalidad,
            'estado_civil' => $this->estado_civil,
            'calle' => $this->calle,
            'numero_exterior' => $this->numero_exterior,
            'numero_interior' => $this->numero_interior,
            'colonia' => $this->colonia,
            'entidad' => $this->entidad,
            'municipio' => $this->municipio,
            'ciudad' => $this->ciudad,
            'cp' => $this->cp
        ];

    }
}
