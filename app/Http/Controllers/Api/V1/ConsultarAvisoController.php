<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Aviso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AvisoResource;

class ConsultarAvisoController extends Controller
{

    public function consultarAviso(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

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

        return (new AvisoResource($aviso))->response()->setStatusCode(200);

    }

}
