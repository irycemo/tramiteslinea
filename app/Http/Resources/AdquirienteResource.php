<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdquirienteResource extends JsonResource
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
            'fecha_nacimiento' => $this->persona->fecha_nacimiento,
            'nacionalidad' => $this->persona->nacionalidad,
            'estado_civil' => $this->persona->estado_civil,
            'calle' => $this->persona->calle,
            'numero_exterior' => $this->persona->numero_exterior,
            'numero_interior' => $this->persona->numero_interior,
            'colonia' => $this->persona->colonia,
            'cp' => $this->persona->cp,
            'entidad' => $this->persona->entidad,
            'municipio' => $this->persona->municipio,
            'ciudad' => $this->persona->ciudad,
        ];

    }
}
