<?php

namespace App\Livewire\Rpp\AvisosPreventivos;

use App\Exceptions\GeneralException;
use App\Services\SrppService;
use App\Constantes\Constantes;
use App\Models\AvisoPreventivo;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Traits\ComponentesTrait;
use Livewire\WithPagination;

class AvisosPreventivos extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $filters = [
        'estado' => '',
        'tramite_año' => '',
        'tramite_folio' => '',
        'tramite_usuario' => '',
        'folio_real' => ''
    ];
    public $años;

    public AvisoPreventivo $modelo_editar;

    public function crearModeloVacio(){
        $this->modelo_editar = AvisoPreventivo::make();
    }

    public function abrirModalEditar(AvisoPreventivo $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function imprimirCaratula(){

        try {

            $data = (new SrppService())->generarAvisoPreventivoPdf($this->modelo_editar->movimiento_registral_id);

            $this->js('window.open(\' '. $data["data"]["pdf"] . '\', \'_blank\');');

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error(
                "Error al generar caratula de aviso preventivo",
                [
                    'message' => $th->getMessage(),
                    'usuario_id' => auth()->id(),
                    'usuario' => auth()->user()->name,
                    'entidad' => auth()->user()->entidad->nombre(),
                    'trace' => $th->getTraceAsString()
                ]
            );

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    #[Computed]
    public function avisos(){

        return AvisoPreventivo::select('id', 'estado', 'tramite_año', 'tramite_folio', 'tramite_usuario', 'folio_real', 'movimiento_registral_id', 'entidad_id',  'creado_por', 'actualizado_por', 'created_at', 'updated_at')
                        ->with('creadoPor:id,name')
                        ->when($this->filters['estado'], fn($q, $estado) => $q->where('estado', $estado))
                        ->when($this->filters['tramite_año'], fn($q, $tramite_año) => $q->where('tramite_año', $tramite_año))
                        ->when($this->filters['tramite_folio'], fn($q, $tramite_folio) => $q->where('tramite_folio', $tramite_folio))
                        ->when($this->filters['tramite_usuario'], fn($q, $tramite_usuario) => $q->where('tramite_usuario', $tramite_usuario))
                        ->when($this->filters['folio_real'], fn($q, $folio_real) => $q->where('folio_real', $folio_real))
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->pagination);

    }

    public function mount(){

        $this->crearModeloVacio();

        $this->años = Constantes::AÑOS;

        $this->filters['año'] = now()->format('Y');

    }


    public function render()
    {
        return view('livewire.rpp.avisos-preventivos.avisos-preventivos')->extends('layouts.admin');
    }

}
