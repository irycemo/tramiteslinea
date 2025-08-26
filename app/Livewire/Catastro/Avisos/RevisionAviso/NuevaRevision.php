<?php

namespace App\Livewire\Catastro\Avisos\RevisionAviso;

use App\Models\Aviso;
use Livewire\Component;

class NuevaRevision extends Component
{

    public Aviso $aviso;

    public function render()
    {
        return view('livewire.catastro.avisos.revision-aviso.nueva-revision')->extends('layouts.admin');
    }

}
