<?php

namespace App\Traits;

use App\Models\Persona;

trait BuscarPersonaTrait
{

    public function buscarPersona($rfc, $curp, $tipo_persona, $nombre, $ap_materno, $ap_paterno, $razon_social):Persona|null
    {

        $persona = null;

        if(isset($rfc)){

            $persona = Persona::where('rfc', $rfc)->first();

        }elseif(isset($curp)){

            $persona = Persona::where('curp', $curp)->first();

        }else{

            $persona = Persona::query()
                            ->where('nombre', trim($nombre))
                            ->where('ap_paterno', trim($ap_paterno))
                            ->where('ap_materno', trim($ap_materno))
                            ->where('razon_social', trim($razon_social))
                            ->first();

        }

        return $persona;

    }

}
