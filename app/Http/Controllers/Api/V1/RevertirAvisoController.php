<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Mail\AvsioRevertidoMail;
use App\Mail\RevertirRechazoMail;
use App\Models\Aviso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RevertirAvisoController extends Controller
{

    public function revertirAviso(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1', 'observaciones' => 'nullable|string']);

        $aviso = Aviso::with('predio')->find($validated['id']);

        if(!$aviso){

            return response()->json([
                'error' => "El aviso no existe.",
            ], 404);

        }

        try {

            Mail::to($aviso->entidad->email)->send(new AvsioRevertidoMail($aviso, $validated['observaciones']));

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

    public function revertirRechazo(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1', 'observaciones' => 'nullable|string']);

        $aviso = Aviso::with('predio')->find($validated['id']);

        if(!$aviso){

            return response()->json([
                'error' => "El aviso no existe.",
            ], 404);

        }

        try {

            Mail::to($aviso->entidad->email)->send(new RevertirRechazoMail($aviso, $validated['observaciones']));

            $aviso->update(['estado' => 'cerrado']);

            return response()->json([
                'data' => "El aviso cambio a cerrado con éxito.",
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al reactivar aviso. " . $th);

            return response()->json([
                'error' => "Error al rechazar el aviso.",
            ], 500);

        }

    }

}
