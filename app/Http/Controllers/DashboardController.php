<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __invoke(Request $request)
    {

        $query = $request->query();

        return view('dashboard', compact('query'));

    }

}
