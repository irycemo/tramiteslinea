<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Aviso;
use Illuminate\Http\Request;
use App\Mail\OperarAvisoMail;
use App\Mail\RechazarAvisoMail;
use App\Mail\AutorizarAvisoMail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\AvisoResource;
use App\Http\Requests\ObservacionRequest;
use App\Http\Resources\ObservacionResource;

class AvisoApiController extends Controller
{

    public function consultarAviso(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $aviso = Aviso::find($validated['id']);

        if(!$aviso){

            return response()->json([
                'error' => "No se encontraron resultados.",
            ], 404);

        }

        return (new AvisoResource($aviso))->response()->setStatusCode(200);

    }

    public function rechazarAviso(ObservacionRequest $request){

        $validated = $request->validated();

        $aviso = Aviso::find($validated['aviso_id']);

        if(!$aviso){



        }

        try {

            $aviso->update(['estado' => 'rechazado']);

            $observacion = $aviso->observacionesLista()->create([
                'estado' => 'nuevo',
                'observacion' => $validated['observacion'],
                'oficina_sgc' => $validated['oficina_sgc'],
                'entidad_id' => $validated['entidad_id'],
            ]);

            Mail::to($observacion->entidad->email)->send(new RechazarAvisoMail($observacion));

            return (new ObservacionResource($observacion))->response()->setStatusCode(200);

        } catch (\Throwable $th) {

            Log::error("Error al crear observación por el Sistema de Gestión Catastral" . $th);

            return response()->json([
                'error' => "No se pudo crear la observación.",
            ], 500);

        }

    }

    public function autorizarAviso(Request $request){

        $validated = $request->validate([
            'aviso_id' => 'required|numeric|min:1',
            'observaciones' => 'nullable'
        ]);

        $aviso = Aviso::find($validated['aviso_id']);

        if(!$aviso){

            return response()->json([
                'error' => "No se encontraron resultados.",
            ], 404);

        }

        try {

            $aviso->update(['estado' => 'autorizado']);

            Mail::to($aviso->entidad->email)->send(new AutorizarAvisoMail($validated['observaciones'] ?? null, $aviso));

            return response()->json([
                'error' => "Actualización exitosa.",
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al autorizar aviso por el Sistema de Gestión Catastral: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            return response()->json([
                'error' => "Error al autorizar el aviso.",
            ], 500);

        }

    }

    public function operarAviso(Request $request){

        $validated = $request->validate([
            'aviso_id' => 'required|numeric|min:1',
        ]);

        $aviso = Aviso::find($validated['aviso_id']);

        if(!$aviso){

            return response()->json([
                'error' => "No se encontraron resultados.",
            ], 404);

        }

        try {

            $aviso->update(['estado' => 'operado']);

            Mail::to($aviso->entidad->email)->send(new OperarAvisoMail($aviso));

            return response()->json([
                'error' => "Actualización exitosa.",
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al operar aviso por el Sistema de Gestión Catastral: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            return response()->json([
                'error' => "Error al operar el aviso.",
            ], 500);

        }

    }

}
