<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Aviso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DesvincularAvaluoController extends Controller
{

    public function desvincularAvaluo(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $avisos = Aviso::where('avaluo_spe', $validated['id'])->get();

        $aviso_invalido = $avisos->where('estado', '!=', 'nuevo')->first();

        if($aviso_invalido){

            return response()->json([
                'error' => "El aviso " . $aviso_invalido->año . '-' . $aviso_invalido->folio . '-' . $aviso_invalido->usuario . ' no esta nuevo, no es posible desvincularlo.',
            ], 401);

        }

        try {

            DB::transaction(function () use ($avisos){

                foreach($avisos as  $aviso){

                    $aviso->update(['avaluo_spe' => null]);

                }

            });

            return response()->json([
                'data' => "El avalúo se desvinculo con éxito.",
            ], 200);

        } catch (\Throwable $th) {

            Log::error("Error al desvincular avalúo. " . $th);

            return response()->json([
                'error' => "Error al desvincular el avalúo.",
            ], 500);

        }

    }

}
