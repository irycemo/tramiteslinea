<?php

namespace App\Livewire\Catastro\Avisos;

use App\Models\Aviso;
use Livewire\Component;

class NuevaRevision extends Component
{

    public Aviso $aviso;

    public function render()
    {
        return view('livewire.catastro.avisos.nueva-revision')->extends('layouts.admin');
    }

}
