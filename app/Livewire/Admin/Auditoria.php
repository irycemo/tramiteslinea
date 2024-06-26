<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Audit;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;

class Auditoria extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public $usuarios;

    public $usuario;
    public $evento;
    public $modelo;
    public $selecetedAudit;
    public $oldValues;
    public $newValues;
    public $modelos = [
        'App\Models\User',
    ];

    public function ver(Audit $audit){

        $this->selecetedAudit = $audit;

        if($this->selecetedAudit->event === 'attach' || $this->selecetedAudit->event === 'sync'){

            $this->oldValues = json_decode($this->selecetedAudit->old_values, true);

            $this->newValues = json_decode($this->selecetedAudit->new_values, true);

            /* dd($this->oldValues['roles'][0]); */

        }

        $this->modal = true;

    }

    public function mount(){

        $this->usuarios = User::orderBy('name')->get();

        $this->modelos = collect($this->modelos)->sort();

    }

    public function render()
    {

        $audits = Audit::select('id', 'user_id', 'event', 'auditable_type', 'auditable_id', 'ip_address', 'tags', 'created_at', 'updated_at')
                            ->with('user')
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


        return view('livewire.admin.auditoria', compact('audits'))->extends('layouts.admin');
    }

}
