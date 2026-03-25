<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Aviso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DesvincularAvaluoController extends Controller
{

    public function rechazarAviso(Request $request){

        $validated = $request->validate(['id' => 'required|numeric|min:1']);

        $avisos = Aviso::whereIn('avaluo_spe', $validated['id'])->where('estado', 'nuevo')->get();

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
