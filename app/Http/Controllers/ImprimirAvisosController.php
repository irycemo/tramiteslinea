<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use Barryvdh\DomPDF\Facade\Pdf;

class ImprimirAvisosController extends Controller
{

    public function imprimir(Aviso $aviso){

        $aviso->load('predio.actores.persona');

        $datos_control = (object)[];

        $datos_control->impreso_por = auth()->user()->name;
        $datos_control->impreso_en = now()->format('d/m/Y H:i:s');

        $pdf = Pdf::loadView('avisos.aviso', [
            'datos_control' => $datos_control,
            'predio' => $aviso->predio,
            'aviso' => $aviso,
        ]);

        $pdf->render();

        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(480, 745, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

        $canvas->page_text(35, 745, 'Aviso - ' . $aviso->año .'-' . $aviso->folio .'-' . $aviso->usuario, null, 9, array(1, 1, 1));

        return $pdf;

    }

}
