<?php

namespace App\Traits;

use App\Models\File;
use App\Models\Aviso;
use Illuminate\Support\Facades\Storage;

trait GuardarEnS3Trait
{

    private function guardarEnS3(Aviso $aviso, $pdf): void
    {

        $filename = 'aviso_' . $aviso->folioAviso() . '_' . now()->format('Ymd_His') . '.pdf';

        $clave = config('services.ses.ruta_pdfs') . $filename;

        if(app()->isProduction()){

            Storage::disk('s3')->put(
                $clave,
                $pdf->output(),
                [
                    'ContentType' => 'application/pdf',
                    'ContentDisposition' => 'attachment; filename="' . $filename . '"',
                ]
            );

        }else{

            Storage::put('caratulas/' . $filename, $pdf->output());

        }

        File::create([
            'fileable_type' => Aviso::class,
            'fileable_id' => $aviso->id,
            'url' => $filename,
            'descripcion' => 'caratula',
        ]);

    }

}
