<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;

class TramiteReciboController extends Controller
{

    public function imprimir(array $tramite){

        $generatorPNG = new BarcodeGeneratorPNG();

        $pdf = Pdf::loadView('tramites.orden', compact('tramite', 'generatorPNG'));

        $pdf->render();

        return $pdf;

    }

}
