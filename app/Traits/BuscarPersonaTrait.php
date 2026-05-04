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
                            ->when($nombre, function($q)use ($nombre){
                                $q->where('nombre', trim($nombre));
                            })
                            ->when($ap_paterno, function($q) use ($ap_paterno){
                                $q->where('ap_paterno', trim($ap_paterno));
                            })
                            ->when($ap_materno, function($q) use ($ap_materno){
                                $q->where('ap_materno', trim($ap_materno));
                            })
                            ->when($razon_social, function($q) use ($razon_social){
                                $q->where('razon_social', trim($razon_social));
                            })
                            ->first();

        }

        return $persona;

    }

}
