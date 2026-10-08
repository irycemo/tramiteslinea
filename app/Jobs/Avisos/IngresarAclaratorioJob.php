<?php

namespace App\Jobs\Avisos;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Models\Aviso;
use App\Services\SGCService;
use Illuminate\Foundation\Queue\Queueable;

class IngresarAclaratorioJob implements ShouldQueue
{
    use Queueable;

    public Aviso $aviso;

    public function __construct(int $aviso_id)
    {

        $this->aviso = Aviso::find($aviso_id);

    }

    public function handle(): void
    {

        $data_traslado = (new SGCService())->ingresarAvisoAclaratorio(
                                                                    $this->aviso->predio_sgc,
                                                                    $this->aviso->tramite_sgc,
                                                                    $this->aviso->id,
                                                                    $this->aviso->entidad_id,
                                                                    $this->aviso->entidad->nombre(),
                                                                    $this->aviso->año,
                                                                    $this->aviso->folio,
                                                                    $this->aviso->usuario,
                                                                    $this->aviso->acto,
                                                                    $this->aviso->estado,
                                                                );

        $this->aviso->update(['traslado_sgc' => $data_traslado['traslado_id']]);

    }

    public function failed(?\Throwable $exception): void
    {

        $this->aviso->update([
            'traslado_sgc' => null,
        ]);

        Log::error('Falló el Job de aviso aclaratorio', [
            'aviso_id' => $this->aviso->id,
            'error' => $exception?->getMessage(),
            'trace' => $exception
        ]);

    }

}
