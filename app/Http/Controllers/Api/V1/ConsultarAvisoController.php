<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Aviso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AvisoFolioRequest;
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

    public function consultarAvisoConFolio(AvisoFolioRequest $request){

        $validated = $request->validated();

        $aviso = Aviso::where('año', $validated['año'])
                            ->where('folio', $validated['folio'])
                            ->where('folio', $validated['folio'])
                            ->first();

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

        return response()->json([
            'data' => [
                'id' => $aviso->id
            ],
        ], 200);

    }

}
