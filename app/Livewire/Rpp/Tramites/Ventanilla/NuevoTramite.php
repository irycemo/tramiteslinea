<?php

namespace App\Livewire\Rpp\Tramites\Ventanilla;

use Livewire\Component;

class NuevoTramite extends Component
{

    public $categoria;

    public function render()
    {
        return view('livewire.rpp.tramites.ventanilla.nuevo-tramite')->extends('layouts.admin');
    }
}
