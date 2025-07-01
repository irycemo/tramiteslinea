<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Audit;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;

class Auditoria extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public $usuarios;

    public $pagination = 10;

    public $usuario;
    public $evento;
    public $modelo;
    public $modelo_id;
    public $selecetedAudit;
    public $oldValues;
    public $newValues;
    public $modelos = [
        'User' => 'App\Models\User',
    ];

    public function ver(Audit $audit){

        $this->selecetedAudit = $audit;

        if($this->selecetedAudit->event === 'attach' || $this->selecetedAudit->event === 'sync'){

            $this->oldValues = $this->selecetedAudit->old_values;

            $this->newValues = $this->selecetedAudit->new_values;

            /* dd($this->oldValues['roles'][0]); */

        }

        $this->modal = true;

    }

    public function mount(){

        $this->usuarios = User::orderBy('name')->get();

        if(request()->query('modelo')) $this->modelo = $this->modelos[request()->query('modelo')];

        $this->modelo_id = request()->query('modelo_id');

    }

    #[Computed]
    public function audits(){

        return Audit::with('user')
                        ->when(isset($this->usuario) && $this->usuario != "", function($q){
                            return $q->where('user_id', $this->usuario);

                        })
                        ->when(isset($this->evento) && $this->evento != "", function($q){
                            return $q->where('event', $this->evento);

                        })
                        ->when(isset($this->modelo) && $this->modelo != "", function($q){
                            return $q->where('auditable_type', $this->modelo);

                        })
                        ->when(isset($this->modelo_id) && $this->modelo_id != "", function($q){
                            return $q->where('auditable_id', $this->modelo_id);

                        })
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->pagination);

    }

    public function render()
    {
        return view('livewire.admin.auditoria')->extends('layouts.admin');
    }

}
