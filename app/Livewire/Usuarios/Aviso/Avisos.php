<?php

namespace App\Livewire\Usuarios\Aviso;

use App\Models\Aviso;
use Livewire\Component;

class Avisos extends Component
{

    public Aviso $aviso;

    public function render()
    {
        return view('livewire.usuarios.aviso.avisos')->extends('layouts.admin');
    }

}
