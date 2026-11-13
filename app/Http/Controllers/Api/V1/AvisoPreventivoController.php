<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActualizarMovimientoRegistralRequest;
use App\Http\Requests\ConsultarDocumentoEntradaRequest;
use App\Models\AvisoPreventivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvisoPreventivoController extends Controller
{

    public function consultarAvisoPreventivo(ConsultarDocumentoEntradaRequest $request){

        $validated = $request->validated();

        $modelo = match($validated['tipo_inscripcion']){
            'aviso_preventivo' => AvisoPreventivo::where('tramite_id', $validated['tramite_id'])->first(),
        };

        if(! $modelo){

            return response()->json([
                'error' => 'No se encontro la inscripción.',
            ], 404);

        }

        info($modelo);

        if(app()->isProduction()){

            return response()->json([
                'data' => [
                    'documento_entrada_url' => Storage::disk('s3')->url(config('services.ses.documento_entrada') . $modelo->documentoEntrada->url)
                ]
            ], 200);

        }else{

            return response()->json([
                'data' => [
                    'documento_entrada_url' => Storage::disk('documento_entrada')->url($modelo->documentoEntrada->url),
                    'descripcion_acto' => $modelo->descripcion_acto
                ]
            ], 200);

        }

    }

    public function actualizarMovimientoRegistral(ActualizarMovimientoRegistralRequest $request){

        $validated = $request->validated();

        $aviso_preventivo = AvisoPreventivo::where('tramite_id', $validated['tramite_id'])->first();

        if(! $aviso_preventivo){

            return response()->json([
                'error' => "No se encontro el aviso preventivo.",
            ], 404);

        }

        $aviso_preventivo->update(['movimiento_registral_id' => $validated['movimiento_registral_id']]);

        return response()->json([
            'data' => [
                "message" => "El aviso preventivo se actualizó con éxito."
            ],
        ], 200);

    }

    public function actualizarEstado(Request $request){

        $validated = $request->validate(['movimiento_registral_id' => 'required|numeric|min:1']);

        $aviso_preventivo = AvisoPreventivo::where('movimiento_registral_id', $validated['movimiento_registral_id'])->first();

        if(! $aviso_preventivo){

            return response()->json([
                'error' => "No se encontro el aviso preventivo.",
            ], 404);

        }

        $aviso_preventivo->update(['estado' => 'elaborado']);

        return response()->json([
            'data' => [
                "message" => "El aviso preventivo se actualizó con éxito."
            ],
        ], 200);

    }

}
