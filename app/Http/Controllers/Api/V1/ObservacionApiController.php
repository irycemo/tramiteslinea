<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Observacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\ObservacionRequest;
use App\Http\Resources\ObservacionResource;

class ObservacionApiController extends Controller
{

    public function crearObservacion(ObservacionRequest $request){

        $validated = $request->validated();

        try {

            $observacion = Observacion::create([
                'estado' => 'nuevo',
                'observacion' => $validated['observacion'],
                'tipo_tramite' => $validated['tipo_tramite'],
                'tramite_sgc' => $validated['tramite_sgc'],
                'oficina_sgc' => $validated['oficina_sgc'],
                'aviso_id' => $validated['aviso_id'],
                'entidad_id' => $validated['entidad_id'],
            ]);

            return (new ObservacionResource($observacion))->response()->setStatusCode(200);

        } catch (\Throwable $th) {

            Log::error("Error al crear observación por el Sistema de Gestión Catastral" . $th);

            return response()->json([
                'error' => "No se pudo crear la observación.",
            ], 500);

        }

    }

}
