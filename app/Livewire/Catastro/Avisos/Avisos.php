<?php

namespace App\Livewire\Catastro\Avisos;

use App\Models\Aviso;
use Livewire\Component;
use Livewire\WithPagination;
use App\Constantes\Constantes;
use App\Exceptions\GeneralException;
use App\Http\Controllers\ImprimirAvisosController;
use App\Services\PeritosExternosService;
use App\Services\SGCService;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;

class Avisos extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $años;
    public $año;
    public $rechazos = [];

    public $modalObservaciones = false;
    public $modalRechazos = false;

    public $filters = [
        'año' => '',
        'folio' => '',
        'usuario' => '',
    ];

    public Aviso $modelo_editar;

    public function updatedFilters() { $this->resetPage(); }

    public function crearModeloVacio(){
        $this->modelo_editar =  Aviso::make();
    }

    public function abrirModalRechazos(Aviso $aviso){

        $this->modelo_editar = $aviso;

        try {

            $this->rechazos = (new SGCService())->consultarRechazos($this->modelo_editar->traslado_sgc)['data'];

            $this->modalRechazos = true;

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error con']);

            Log::error("Error al reactivar aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

        }

    }

    public function reactivarAvaluo(Aviso $aviso){

        $this->modelo_editar = $aviso;

        try {

            (new PeritosExternosService())->reactivarAvaluo($this->modelo_editar->avaluo_spe);

            $this->modelo_editar->update([
                                            'avaluo_spe' => null,
                                            'actualizado_por' => auth()->id()
                                        ]);

            $this->dispatch('mostrarMensaje', ['success', 'El avalúo ha sido reactivado.']);

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        }catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error con']);

            Log::error("Error al reactivar aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

        }


    }

    public function reactivarAviso(Aviso $aviso){

        $this->modelo_editar = $aviso;

        try {

            (new SGCService())->inactivarTraslado($this->modelo_editar->traslado_sgc);

            $this->modelo_editar->update([
                                            'estado' => 'nuevo',
                                            'actualizado_por' => auth()->id()
                                        ]);

            $this->dispatch('mostrarMensaje', ['success', 'El aviso han sido reactivado.']);

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        }catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error con']);

            Log::error("Error al reactivar aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

        }


    }

    public function reactivarAvisoYAvaluo(Aviso $aviso){

        $this->modelo_editar = $aviso;

        try {

            (new SGCService())->inactivarTraslado($this->modelo_editar->traslado_sgc);

            (new PeritosExternosService())->reactivarAvaluo($this->modelo_editar->avaluo_spe);

            $this->modelo_editar->update([
                                            'avaluo_spe' => null,
                                            'estado' => 'nuevo',
                                            'actualizado_por' => auth()->id()
                                        ]);

            $this->dispatch('mostrarMensaje', ['success', 'El aviso y el avalúo han sido reactivados.']);

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        }catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error con']);

            Log::error("Error al reactivar aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

        }


    }


    public function imprimirAviso(Aviso $aviso){

        try {

            $pdf = (new ImprimirAvisosController())->imprimir($aviso);

            return response()->streamDownload(
                fn () => print($pdf->output()),
                $aviso->año . '-' . $aviso->folio . '-' . $aviso->usuario . '-aviso.pdf'
            );

        } catch (\Throwable $th) {

            Log::error("Error al imprimir aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

    }

    #[Computed]
    public function avisos(){

        return Aviso::with('creadoPor', 'actualizadoPor', 'entidad', 'predio')
                        ->when($this->filters['año'], fn($q, $año) => $q->where('año', $año))
                        ->when($this->filters['folio'], fn($q, $folio) => $q->where('folio', $folio))
                        ->when($this->filters['usuario'], fn($q, $usuario) => $q->where('usuario', $usuario))
                        ->where('entidad_id', auth()->user()->entidad_id)
                        ->where('tipo', 'aclaratorio')
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->pagination);

    }

    public function render()
    {
        return view('livewire.catastro.avisos.avisos')->extends('layouts.admin');
    }
}
