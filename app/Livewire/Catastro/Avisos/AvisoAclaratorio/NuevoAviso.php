<?php

namespace App\Livewire\Catastro\Avisos\AvisoAclaratorio;

use App\Models\Aviso;
use Livewire\Component;

class NuevoAviso extends Component
{

    public Aviso $aviso;

    public function render()
    {

        if(isset($this->aviso) &&  $this->aviso->entidad_id != auth()->user()->entidad_id){

            abort(403, 'El aviso pertenece a otra entidad.');

        }

        if(isset($this->aviso) && in_array($this->aviso->estado, ['autorizado', 'operado'])){

            abort(403, 'El aviso no puede ser modificado estando autorizado o operado.');

        }

        if(isset($this->aviso) && $this->aviso->estado === 'rechazado'){

            abort(403, 'El aviso esta rechazado debe reactivarlo.');

        }

        return view('livewire.catastro.avisos.aviso-aclaratorio.nuevo-aviso')->extends('layouts.admin');
    }

}
