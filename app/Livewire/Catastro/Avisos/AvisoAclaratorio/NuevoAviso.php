<?php

namespace App\Livewire\Catastro\Avisos\AvisoAclaratorio;

use App\Models\Aviso;
use Livewire\Component;

class NuevoAviso extends Component
{

    public Aviso $aviso;

    public function render()
    {

        if($this->aviso->entidad_id != auth()->user()->entidad_id){

            abort(403, 'El aviso pertenece a otra entidad.');

        }

        return view('livewire.catastro.avisos.aviso-aclaratorio.nuevo-aviso')->extends('layouts.admin');
    }

}
