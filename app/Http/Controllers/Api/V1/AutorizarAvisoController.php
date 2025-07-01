<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Aviso;
use App\Mail\AvisoAutorizadoMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\AutorizarAvisoRequest;

class AutorizarAvisoController extends Controller
{

    public function autorizarAviso(AutorizarAvisoRequest $request){

        $validated = $request->validated();

        $aviso = Aviso::with('predio')->find($validated['id']);

        if(!$aviso){

            return response()->json([
                'error' => "El aviso no existe.",
            ], 404);

        }

        if(!in_array($aviso->estado, ['cerrado', 'autorizado'])){

            return response()->json([
                'error' => "El aviso no esta cerrado ó autorizado.",
            ], 401);

        }


        try {

            DB::transaction(function () use ($aviso, $validated){

                $aviso->update(['estado' => 'autorizado']);

                Mail::to($aviso->entidad->email)->send(new AvisoAutorizadoMail($aviso, $validated['observaciones'] ?? null));

            });

            return response()->json([
                'data' => "El aviso se autorizó con éxito.",
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al autorizar aviso. " . $th);

            return response()->json([
                'error' => "Error al autorizar el aviso.",
            ], 500);

        }

    }

}
