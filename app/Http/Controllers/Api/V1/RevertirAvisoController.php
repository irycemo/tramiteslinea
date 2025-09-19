<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Aviso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class RevertirAvisoController extends Controller
{

    public function rechazarAviso(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $aviso = Aviso::with('predio')->find($validated['id']);

        if(!$aviso){

            return response()->json([
                'error' => "El aviso no existe.",
            ], 404);

        }

        try {

            $aviso->update(['estado' => 'autorizado']);

            return response()->json([
                'data' => "El aviso cambio a autorizado con éxito.",
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al reactivar aviso. " . $th);

            return response()->json([
                'error' => "Error al rechazar el aviso.",
            ], 500);

        }

    }

}
