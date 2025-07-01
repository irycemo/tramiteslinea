<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Aviso;
use Illuminate\Http\Request;
use App\Mail\AvisoOperadoMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class OperarAvisoController extends Controller
{

    public function operarAviso(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $aviso = Aviso::with('predio')->find($validated['id']);

        if(!$aviso){

            return response()->json([
                'error' => "El aviso no existe.",
            ], 404);

        }

        if($aviso->estado !== 'autorizado'){

            return response()->json([
                'error' => "El aviso no esta autorizado.",
            ], 401);

        }

        try {

            DB::transaction(function () use ($aviso){

                $aviso->update(['estado' => 'operado']);

                Mail::to($aviso->entidad->email)->send(new AvisoOperadoMail($aviso));

            });

            return response()->json([
                'data' => "El aviso se autorizó con éxito.",
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al operar aviso. " . $th);

            return response()->json([
                'error' => "Error al operar el aviso.",
            ], 500);

        }

    }

}
