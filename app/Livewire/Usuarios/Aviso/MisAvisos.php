<?php

namespace App\Livewire\Usuarios\Aviso;

use App\Models\Aviso;
use Livewire\Component;
use Livewire\WithPagination;
use App\Constantes\Constantes;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\ComponentesTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class MisAvisos extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $años;
    public $año;

    public $modalObservaciones = false;

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

    public function abrirVerObservaciones(Aviso $aviso){

        $this->modelo_editar = $aviso;

        $this->modalObservaciones = true;

    }

    public function reactivarAvaluo(Aviso $aviso){

        $this->modelo_editar = $aviso;

        try {

            $response = Http::acceptJson()
                        ->withToken(env('SISTEMA_PERITOS_EXTERNOS_TOKEN'))
                        ->withQueryParameters([
                            'id' => $this->modelo_editar->avaluo_spe,
                        ])
                        ->get(env('SISTEMA_PERITOS_EXTERNOS_REACTIVAR_AVALUO'));


            $data = json_decode($response, true);

            if($response->status() === 200){

                $this->modelo_editar->update(['estado' => 'nuevo', 'actualizado_por' => auth()->id()]);

                $this->dispatch('mostrarMensaje', ['success', 'El aviso y el avalúo han sido reactivados.']);

            }else if($response->status() === 404 || $response->status() === 401){

                $this->dispatch('mostrarMensaje', ['error', $data['error']]);

            }else{

                Log::error("Error al reactivar aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . json_encode($data));

                $this->dispatch('mostrarMensaje', ['error', 'Hubo un error']);

            }

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error con']);

            Log::error("Error al reactivar avalúp por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

        }


    }

    public function reactivarAviso(Aviso $aviso){

        $this->modelo_editar = $aviso;

        try {

            $this->modelo_editar->update(['estado' => 'nuevo', 'actualizado_por' => auth()->id()]);

            $this->dispatch('mostrarMensaje', ['success', 'El aviso y el avalúo han sido reactivados.']);

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error con']);

            Log::error("Error al reactivar aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

        }


    }

    public function imprimirAviso(Aviso $aviso){

        try {

            $pdf = Pdf::loadView('avisos.aviso', ['aviso' => $aviso, 'municipio' => 'MORELIA']);

            $pdf->render();

            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->get_canvas();

            $canvas->page_text(480, 794, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

            $canvas->page_text(35, 794, "Aviso: " . $aviso->año . "-" . $aviso->folio . "-" . $aviso->usuario , null, 10, array(1, 1, 1));

            $pdf = $dom_pdf->output();

            return response()->streamDownload(
                fn () => print($pdf),
                'aviso.pdf'
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

    public function render()
    {

        $avisos = Aviso::with('creadoPor', 'actualizadoPor', 'entidad', 'observacionesLista')
                            ->when($this->filters['año'], fn($q, $año) => $q->where('año', $año))
                            ->when($this->filters['folio'], fn($q, $folio) => $q->where('folio', $folio))
                            ->when($this->filters['usuario'], fn($q, $usuario) => $q->where('usuario', $usuario))
                            ->where('entidad_id', auth()->user()->entidad_id)
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        return view('livewire.usuarios.aviso.mis-avisos', compact('avisos'))->extends('layouts.admin');
    }
}
