<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Mail\AvsioRevertidoMail;
use App\Mail\RevertirAutorizadoMail;
use App\Mail\RevertirRechazoMail;
use App\Models\Aviso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RevertirAvisoController extends Controller
{

    public function reactivartirAviso(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1', 'observaciones' => 'nullable|string']);

        $aviso = Aviso::with('predio')->find($validated['id']);

        if(!$aviso){

            return response()->json([
                'error' => "El aviso no existe.",
            ], 404);

        }

        try {

            $aviso->update(['estado' => 'nuevo', 'actualizado_por' => auth()->id()]);

            $aviso->audits()->latest()->first()->update(['tags' => 'Reactivó aviso']);

            return response()->json([
                'data' => "El aviso cambio a nuevo con éxito.",
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al reactivar aviso. " . $th);

            return response()->json([
                'error' => "Error al reactivar el aviso.",
            ], 500);

        }

    }

    public function revertirAviso(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1', 'observaciones' => 'nullable|string']);

        $aviso = Aviso::with('predio')->find($validated['id']);

        if(!$aviso){

            return response()->json([
                'error' => "El aviso no existe.",
            ], 404);

        }

        try {

            $observaciones = $validated['observaciones'] ?? null;

            Mail::to($aviso->entidad->email)->send(new AvsioRevertidoMail($aviso, $observaciones));

            $aviso->update(['estado' => 'nuevo', 'actualizado_por' => auth()->id()]);

            $aviso->audits()->latest()->first()->update(['tags' => 'Revirtió aviso']);

            return response()->json([
                'data' => "El aviso cambio a nuevo con éxito.",
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al reactivar aviso. " . $th);

            return response()->json([
                'error' => "Error al reactivar el aviso.",
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

            $observaciones = $validated['observaciones'] ?? null;

            Mail::to($aviso->entidad->email)->send(new RevertirRechazoMail($aviso, $observaciones));

            $aviso->update(['estado' => 'cerrado', 'actualizado_por' => auth()->id()]);

            $aviso->audits()->latest()->first()->update(['tags' => 'Revirtió rechazo aviso']);

            return response()->json([
                'data' => "El aviso cambio a nuevo con éxito.",
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al reactivar aviso. " . $th);

            return response()->json([
                'error' => "Error al rechazar el aviso.",
            ], 500);

        }

    }

    public function revertirAutorizado(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1', 'observaciones' => 'nullable|string']);

        $aviso = Aviso::with('predio')->find($validated['id']);

        if(!$aviso){

            return response()->json([
                'error' => "El aviso no existe.",
            ], 404);

        }

        try {

            $observaciones = $validated['observaciones'] ?? null;

            Mail::to($aviso->entidad->email)->send(new RevertirAutorizadoMail($aviso, $observaciones));

            $aviso->update(['estado' => 'cerrado', 'actualizado_por' => auth()->id()]);

            $aviso->audits()->latest()->first()->update(['tags' => 'Revirtió autorización aviso']);

            return response()->json([
                'data' => "El aviso cambio a nuevo con éxito.",
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al reactivar aviso. " . $th);

            return response()->json([
                'error' => "Error al revertir el aviso.",
            ], 500);

        }

    }

    public function corregirOperacion(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $aviso = Aviso::with('predio')->find($validated['id']);

        if(!$aviso){

            return response()->json([
                'error' => "El aviso no existe.",
            ], 404);

        }

        try {

            $aviso->update(['estado' => 'autorizado', 'actualizado_por' => auth()->id()]);

            $aviso->audits()->latest()->first()->update(['tags' => 'Corrigio operación']);

            return response()->json([
                'data' => "El aviso cambio a autorizado con éxito.",
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al corregir operación. " . $th);

            return response()->json([
                'error' => "Error al corregir operación.",
            ], 500);

        }

    }

    public function corregirAutorizacion(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $aviso = Aviso::with('predio')->find($validated['id']);

        if(!$aviso){

            return response()->json([
                'error' => "El aviso no existe.",
            ], 404);

        }

        try {

            $aviso->update(['estado' => 'cerrado', 'actualizado_por' => auth()->id()]);

            $aviso->audits()->latest()->first()->update(['tags' => 'Corrigio autorización']);

            return response()->json([
                'data' => "El aviso cambio a cerrado con éxito.",
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al corregir autorización. " . $th);

            return response()->json([
                'error' => "Error al corregir autorización.",
            ], 500);

        }

    }

}
