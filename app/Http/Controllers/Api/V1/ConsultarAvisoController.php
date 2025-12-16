<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Aviso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AvisoResource;
use App\Http\Requests\AvisoFolioRequest;
use App\Http\Resources\AvisosListaResource;
use App\Http\Requests\ConsultarAvisosRequest;

class ConsultarAvisoController extends Controller
{

    public function consultarAvisos(ConsultarAvisosRequest $request){

        $validated = $request->validated();

        $avisos = Aviso::with('predio:id,localidad,oficina,tipo_predio,numero_registro', 'entidad:id,numero_notaria')
                        ->where('estado', 'autorizado')
                        ->when(isset($validated['año']), function($q) use($validated){
                            $q->where('año', $validated['año']);
                        })
                        ->when(isset($validated['folio']), function($q) use($validated){
                            $q->where('folio', $validated['folio']);
                        })
                        ->when(isset($validated['usuario']), function($q) use($validated){
                            $q->where('usuario', $validated['usuario']);
                        })
                        ->when(isset($validated['localidad']), function($q) use($validated){
                            $q->whereHas('predio', function($q) use($validated){
                                $q->where('localidad', $validated['localidad']);
                            });
                        })
                        ->when(isset($validated['oficina']), function($q) use($validated){
                            $q->whereHas('predio', function($q) use($validated){
                                $q->where('oficina', $validated['oficina']);
                            });
                        })
                        ->when(isset($validated['tipo_predio']), function($q) use($validated){
                            $q->whereHas('predio', function($q) use($validated){
                                $q->where('tipo_predio', $validated['tipo_predio']);
                            });
                        })
                        ->when(isset($validated['numero_registro']), function($q) use($validated){
                            $q->whereHas('predio', function($q) use($validated){
                                $q->where('numero_registro', $validated['numero_registro']);
                            });
                        })
                        ->orderBy('id', 'desc')
                        ->paginate($validated['pagination'], ['*'], 'page', $validated['pagina']);

        return AvisosListaResource::collection($avisos)->response()->setStatusCode(200);

    }

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
