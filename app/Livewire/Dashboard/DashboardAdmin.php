<?php

namespace App\Livewire\Dashboard;

use App\Models\Aviso;
use Livewire\Component;

class DashboardAdmin extends Component
{

    public $avisos_nuevos;
    public $avisos_cerrados;
    public $avisos_operados;
    public $avisos_autorizados;
    public $avisos_rechazados;

    public function mount(){

        $this->avisos_nuevos = Aviso::select('id','esatado', 'entidad_id', 'created_at')->where('estado', 'nuevo')->where('created_at', '>', now()->startOfMonth())->count();
        $this->avisos_cerrados = Aviso::select('id','esatado', 'entidad_id', 'created_at')->where('estado', 'cerrado')->where('created_at', '>', now()->startOfMonth())->count();
        $this->avisos_operados = Aviso::select('id','esatado', 'entidad_id', 'created_at')->where('estado', 'operado')->where('created_at', '>', now()->startOfMonth())->count();
        $this->avisos_autorizados = Aviso::select('id','esatado', 'entidad_id', 'created_at')->where('estado', 'autorizado')->where('created_at', '>', now()->startOfMonth())->count();
        $this->avisos_rechazados = Aviso::select('id','esatado', 'entidad_id', 'created_at')->where('estado', 'rechazado')->where('created_at', '>', now()->startOfMonth())->count();

    }

    public function placeholder()
    {
        return view('livewire.dashboard.dashboard-admin_placeholder');
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-admin');
    }
}
