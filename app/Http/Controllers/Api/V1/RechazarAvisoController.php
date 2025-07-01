<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Aviso;
use App\Mail\AvsioRechazadoMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RechazarAvisoRequest;

class RechazarAvisoController extends Controller
{

    public function rechazarAviso(RechazarAvisoRequest $request){

        $validated = $request->validated();

        $aviso = Aviso::with('predio')->find($validated['id']);

        if(!$aviso){

            return response()->json([
                'error' => "El aviso no existe.",
            ], 404);

        }

        if($aviso->estado === 'operado'){

            return response()->json([
                'error' => "El aviso  esta operado.",
            ], 401);

        }

        try {

            DB::transaction(function () use ($aviso, $validated){

                $aviso->update(['estado' => 'rechazado']);

                Mail::to($aviso->entidad->email)->send(new AvsioRechazadoMail($aviso, $validated['observaciones']));

            });

            return response()->json([
                'data' => "El aviso se rechazo con éxito.",
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al rechazar aviso. " . $th);

            return response()->json([
                'error' => "Error al rechazar el aviso.",
            ], 500);

        }

    }

}
