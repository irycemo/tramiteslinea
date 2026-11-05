<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Aviso;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImprimirAvisosController;
use App\Traits\GuardarEnS3Trait;

class GenerarAvisoPdfController extends Controller
{

    use GuardarEnS3Trait;

    public function generarPdf(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $aviso = Aviso::find($validated['id']);

        try {

            if($aviso->caratula){

                if(app()->isProduction()){

                    return response()->json([
                        'data' => [
                            'pdf' => Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_caratulas') . $aviso->caratula->url, now()->addMinutes(10))
                        ]
                    ], 200);

                }else{

                    return response()->json([
                        'data' => [
                            'pdf' => Storage::disk('caratulas')->url($aviso->caratula->url)
                        ]
                    ], 200);

                }

            }else{

                $pdf = (new ImprimirAvisosController())->imprimir($aviso, auth()->user());

                $this->guardarEnS3($aviso, $pdf);

                $aviso->refresh();

                if(app()->isProduction()){

                    return response()->json([
                        'data' => [
                            'pdf' => Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_caratulas') . $aviso->caratula->url, now()->addMinutes(10))
                        ]
                    ], 200);

                }else{

                    return response()->json([
                        'data' => [
                            'pdf' => Storage::disk('caratulas')->url($aviso->caratula->url)
                        ]
                    ], 200);

                }

            }

        } catch (\Throwable $th) {

            Log::error("Error al generar pdf desde SGC en Lína." . $th);

            return response()->json([
                'error' => 'Hubo un error al generar el pdf.',
            ], 500);

        }

    }

}
