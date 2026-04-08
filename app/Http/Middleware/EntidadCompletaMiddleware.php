<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EntidadCompletaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(! auth()->user()->hasRole(['Administrador', 'Consulta'])){

            if(! auth()->user()->entidad){

                abort(403, 'El usuario no esta asociado a una entidad.');

            }

            if(auth()->user()->entidad->estado != 'activo'){

                abort(403, 'La entidad a la que pertenece no esta activa.');

            }else{

                if(
                    auth()->user()->hasRole(['Notario', 'Notario adscrito', 'Gestor']) &&
                    (
                        (auth()->user()->entidad->notario === null && auth()->user()->entidad->adscrito === null) ||
                        auth()->user()->entidad->numero_notaria === null
                    )
                ){

                    abort(403, 'La entidad a la que pertenece no tiene sus datos completos.');

                }

            }

        }

        return $next($request);

    }
}
