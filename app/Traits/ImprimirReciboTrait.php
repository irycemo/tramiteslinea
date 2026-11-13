<?php

namespace App\Traits;

use App\Http\Controllers\TramiteReciboController;
use Illuminate\Support\Facades\Log;

trait ImprimirReciboTrait
{

    public function imprimirRecibo(array $tramite){

        try {

            $pdf = (new TramiteReciboController())->imprimir($tramite);

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'orden_' . $tramite['año'] . '-' . $tramite['folio'] . '-' . $tramite['usuario'] . '.pdf'
            );

        } catch (\Throwable $th) {

            Log::error(
                "Error al crear trámite de rpp",
                [
                    'message' => $th->getMessage(),
                    'user_id' => auth()->id(),
                    'usser' => auth()->user()->name,
                    'trace' => $th->getTraceAsString()
                ]
            );

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

}
