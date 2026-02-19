<?php

namespace App\Livewire\Consultas\Gestores;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Gestores extends Component
{

    #[Computed]
    public function usuarios(){

        return User::select('id', 'name', 'email', 'estado', 'entidad_id', 'clave', 'created_at', 'updated_at')
                        ->with('entidad:id,dependencia,numero_notaria')
                        ->where('entidad_id', auth()->user()->entidad_id)
                        ->get();

    }

    public function render()
    {
        return view('livewire.consultas.gestores.gestores')->extends('layouts.admin');
    }
}
