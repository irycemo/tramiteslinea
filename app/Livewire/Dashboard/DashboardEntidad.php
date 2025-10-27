<?php

namespace App\Livewire\Dashboard;

use App\Models\Aviso;
use Livewire\Component;
use App\Services\SGCService;
use App\Services\SrppService;
use Illuminate\Support\Facades\Cache;

class DashboardEntidad extends Component
{

    public $acalaratorios_nuevos;
    public $acalaratorios_cerrados;
    public $acalaratorios_operados;
    public $acalaratorios_autorizados;
    public $acalaratorios_rechazados;

    public $revisiones_nuevas;
    public $revisiones_cerradas;
    public $revisiones_operadas;
    public $revisiones_autorizadas;
    public $revisiones_rechazadas;

    public $certificados_catastrales;
    public $certificados_gravamen;

    public function mount(){

        $this->acalaratorios_nuevos = Aviso::select('id', 'tipo', 'esatado', 'entidad_id', 'created_at')->where('tipo', 'aclaratorio')->where('entidad_id', auth()->user()->entidad_id)->where('estado', 'nuevo')->where('created_at', '>', now()->startOfMonth())->count();
        $this->acalaratorios_cerrados = Aviso::select('id', 'tipo', 'esatado', 'entidad_id', 'created_at')->where('tipo', 'aclaratorio')->where('entidad_id', auth()->user()->entidad_id)->where('estado', 'cerrado')->where('created_at', '>', now()->startOfMonth())->count();
        $this->acalaratorios_operados = Aviso::select('id', 'tipo', 'esatado', 'entidad_id', 'created_at')->where('tipo', 'aclaratorio')->where('entidad_id', auth()->user()->entidad_id)->where('estado', 'operado')->where('created_at', '>', now()->startOfMonth())->count();
        $this->acalaratorios_autorizados = Aviso::select('id', 'tipo', 'esatado', 'entidad_id', 'created_at')->where('tipo', 'aclaratorio')->where('entidad_id', auth()->user()->entidad_id)->where('estado', 'autorizado')->where('created_at', '>', now()->startOfMonth())->count();
        $this->acalaratorios_rechazados = Aviso::select('id', 'tipo', 'esatado', 'entidad_id', 'created_at')->where('tipo', 'aclaratorio')->where('entidad_id', auth()->user()->entidad_id)->where('estado', 'rechazado')->where('created_at', '>', now()->startOfMonth())->count();

        $this->revisiones_nuevas = Aviso::select('id', 'tipo', 'esatado', 'entidad_id', 'created_at')->where('tipo', 'revision')->where('entidad_id', auth()->user()->entidad_id)->where('estado', 'nuevo')->where('created_at', '>', now()->startOfMonth())->count();
        $this->revisiones_cerradas = Aviso::select('id', 'tipo', 'esatado', 'entidad_id', 'created_at')->where('tipo', 'revision')->where('entidad_id', auth()->user()->entidad_id)->where('estado', 'cerrado')->where('created_at', '>', now()->startOfMonth())->count();
        $this->revisiones_operadas = Aviso::select('id', 'tipo', 'esatado', 'entidad_id', 'created_at')->where('tipo', 'revision')->where('entidad_id', auth()->user()->entidad_id)->where('estado', 'operado')->where('created_at', '>', now()->startOfMonth())->count();
        $this->revisiones_autorizadas = Aviso::select('id', 'tipo', 'esatado', 'entidad_id', 'created_at')->where('tipo', 'revision')->where('entidad_id', auth()->user()->entidad_id)->where('estado', 'autorizado')->where('created_at', '>', now()->startOfMonth())->count();
        $this->revisiones_rechazadas = Aviso::select('id', 'tipo', 'esatado', 'entidad_id', 'created_at')->where('tipo', 'revision')->where('entidad_id', auth()->user()->entidad_id)->where('estado', 'rechazado')->where('created_at', '>', now()->startOfMonth())->count();

        $this->certificados_catastrales = (new SGCService())->consultarEstadisticas(auth()->user()->entidad_id);

        $this->certificados_gravamen = (new SrppService())->consultarEstadisticas(auth()->user()->entidad_id);

    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-entidad');
    }
}
