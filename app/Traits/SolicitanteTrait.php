<?php

namespace App\Traits;

trait SolicitanteTrait
{

    public function solicitante():void
    {

        if(auth()->user()->hasRole(['Notario', 'Gestor'])){

            $this->solicitante = 'Notaría';

            $this->nombre_solicitante =  'Notario ' . auth()->user()->entidad->numero_notaria . ' - ' . auth()->user()->entidad->titular();

        }elseif(auth()->user()->hasRole(['Dependencia', 'Asociacion inmobiliaria'])){

            $this->solicitante = 'Usuario';

            $this->nombre_solicitante =  auth()->user()->entidad->dependencia;

        }elseif(auth()->user()->hasRole('AMPI')){

            $this->solicitante = 'Usuario';

            $this->nombre_solicitante =  auth()->user()->entidad->dependencia;

        }elseif(auth()->user()->hasRole('Abogado')){

            $this->solicitante = 'Usuario';

            $this->nombre_solicitante =  auth()->user()->name;

        }

    }

}
