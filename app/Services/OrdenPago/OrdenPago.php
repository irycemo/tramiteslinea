<?php

namespace App\Services\OrdenPago;

use Barryvdh\DomPDF\Facade\Pdf;
use Picqer\Barcode\BarcodeGeneratorPNG;

class OrdenPago
{

    public function orden($tramite){

        $generatorPNG = new BarcodeGeneratorPNG();

        $pdf = Pdf::loadView('tramites.orden', compact('tramite', 'generatorPNG'));

        $pdf->render();

        return $pdf->stream('orden_' . $tramite->folio . '.pdf');

    }

}
