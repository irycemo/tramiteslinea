<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __invoke(Request $request)
    {

        $query = $request->query();

        $preguntas = Pregunta::latest()->take(5)->get();

        return view('dashboard', compact('query', 'preguntas'));

    }

}
