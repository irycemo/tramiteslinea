<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\PersonaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ActorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'persona' => new PersonaResource($this->persona),
            'porcentaje_propiedad' => $this->porcentaje_propiedad,
            'porcentaje_nuda' => $this->porcentaje_nuda,
            'porcentaje_usufructo' => $this->porcentaje_usufructo,
        ];

    }
}
