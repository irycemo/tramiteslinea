<?php

namespace App\Livewire\Catastro\Avisos;

use App\Models\Aviso;
use Livewire\Component;

class NuevoAviso extends Component
{

    public Aviso $aviso;

    public function render()
    {
        return view('livewire.catastro.avisos.nuevo-aviso')->extends('layouts.admin');
    }

}
