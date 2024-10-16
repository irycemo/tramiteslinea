<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Aviso;
use Illuminate\Auth\Access\Response;

class AvisoPolicy
{

    public function view(User $user, Aviso $aviso): bool
    {

        if($user->hasRole('Administrador'))
            return true;

        return $user->entidad_id === $aviso->entidad_id;

    }

    public function update(User $user, Aviso $aviso): Response
    {

        return $user->entidad_id === $aviso->entidad_id
                ? Response::allow()
                : Response::deny('El aviso pertenece a otra entidad no tienes permisos para editarlo.');

    }

}
