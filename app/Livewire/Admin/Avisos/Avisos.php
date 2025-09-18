<?php

namespace App\Livewire\Admin\Avisos;

use App\Models\Aviso;
use App\Models\Entidad;
use Livewire\Component;
use App\Services\SGCService;
use Livewire\WithPagination;
use App\Constantes\Constantes;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Http\Controllers\ImprimirAvisosController;

class Avisos extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $años;
    public $año;
    public $rechazos = [];
    public $entidades;

    public $modalObservaciones = false;
    public $modalRechazos = false;

    public $filters = [
        'año' => '',
        'folio' => '',
        'usuario' => '',
        'entidad_id' => '',
        'tipo' => '',
        'localidad' => '',
        'oficina' => '',
        't_predio' => '',
        'registro' => ''
    ];

    public Aviso $modelo_editar;

    public function updatedFilters() { $this->resetPage(); }

    public function crearModeloVacio(){
        $this->modelo_editar =  Aviso::make();
    }

    public function abrirModalRechazos(Aviso $aviso){

        $this->modelo_editar = $aviso;

        if(!$this->modelo_editar->traslado_sgc){

            $this->dispatch('mostrarMensaje', ['warning', 'No hay rechazos']);

            return;

        }

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

        $this->filters['año'] = now()->format('Y');

        $this->entidades = Entidad::select('id','dependencia','numero_notaria')->orderBy('numero_notaria')->orderBy('dependencia')->get();

    }

    #[Computed]
    public function avisos(){

        return Aviso::with('creadoPor:id,name', 'actualizadoPor:id,name', 'entidad:id,numero_notaria,dependencia', 'predio:id,localidad,oficina,tipo_predio,numero_registro')
                        ->when($this->filters['año'], fn($q, $año) => $q->where('año', $año))
                        ->when($this->filters['folio'], fn($q, $folio) => $q->where('folio', $folio))
                        ->when($this->filters['usuario'], fn($q, $usuario) => $q->where('usuario', $usuario))
                        ->when($this->filters['entidad_id'], fn($q, $entidad_id) => $q->where('entidad_id', $entidad_id))
                        ->when($this->filters['tipo'], fn($q, $tipo) => $q->where('tipo', $tipo))
                        ->when($this->filters['localidad'], function($q, $localidad){
                            $q->WhereHas('predio', function($q) use($localidad){
                                $q->where('localidad', $localidad);
                            });
                        })
                        ->when($this->filters['oficina'], function($q, $oficina){
                            $q->WhereHas('predio', function($q) use($oficina){
                                $q->where('oficina', $oficina);
                            });
                        })
                        ->when($this->filters['t_predio'], function($q, $t_predio){
                            $q->WhereHas('predio', function($q) use($t_predio){
                                $q->where('tipo_predio', $t_predio);
                            });
                        })
                        ->when($this->filters['registro'], function($q, $registro){
                            $q->WhereHas('predio', function($q) use($registro){
                                $q->where('numero_registro', $registro);
                            });
                        })
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->pagination);

    }

    public function render()
    {
        return view('livewire.admin.avisos.avisos')->extends('layouts.admin');
    }
}
