<?php

namespace App\Models;

use App\Models\User;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{

    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_At'];

    public function usuarios(){
        return $this->belongsToMany(User::class);
    }

}
