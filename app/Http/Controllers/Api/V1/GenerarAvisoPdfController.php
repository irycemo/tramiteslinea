<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Aviso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImprimirAvisosController;

class GenerarAvisoPdfController extends Controller
{

    public function generarPdf(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $aviso = Aviso::find($validated['id']);

        try {

            $pdf = (new ImprimirAvisosController())->imprimir($aviso);

            return response()->json([
                'data' => [
                    'pdf' => base64_encode($pdf->stream())
                ]
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al generar pdf desde SGC en Lína." . $th);

            return response()->json([
                'error' => 'Hubo un error al generar el pdf.',
            ], 500);

        }

    }

}
