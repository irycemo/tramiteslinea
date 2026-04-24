<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Aviso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AvisoResource;
use App\Http\Requests\AvisoFolioRequest;
use App\Http\Requests\ConsultarAvisosRequest;
use App\Http\Resources\AvisoApiResource;

class ConsultarAvisoController extends Controller
{

    public function consultarAvisos(ConsultarAvisosRequest $request){

        $validated = $request->validated();

        $avisos = Aviso::with(
                                'predio.colindancias',
                                'entidad',
                                'archivo'
                        )
                        ->where('estado', 'operado')
                        ->whereHas('predio', function($q) use($validated){
                            $q->where('localidad', $validated['localidad'])
                                ->where('oficina', $validated['oficina'])
                                ->where('tipo_predio', $validated['tipo_predio'])
                                ->whereBetween('numero_registro', [$validated['numero_registro_inicial'], $validated['numero_registro_final']]);
                        })
                        ->get();

        return AvisoApiResource::collection($avisos)->response()->setStatusCode(200);

    }

    public function consultarAvisoFolio(AvisoFolioRequest $request){

        $validated = $request->validated();

        $aviso = Aviso::with(
                                'predio.colindancias',
                                'entidad',
                                'archivo'
                        )
                        ->where('estado', 'operado')
                        ->where('año', $validated['año'])
                        ->where('folio', $validated['folio'])
                        ->where('folio', $validated['folio'])
                        ->first();

        return (new AvisoApiResource($aviso))->response()->setStatusCode(200);

    }

    public function consultarAviso(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $aviso = Aviso::with('predio')->find($validated['id']);

        if(!$aviso){

            return response()->json([
                'error' => "El aviso no existe.",
            ], 404);

        }

        if(! in_array($aviso->estado, ['cerrado', 'autorizado'])){

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

        if(! in_array($aviso->estado, ['cerrado', 'autorizado'])){

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
