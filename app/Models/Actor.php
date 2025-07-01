<?php

namespace App\Models;

use App\Models\Persona;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{

    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function persona(){
        return $this->belongsTo(Persona::class);
    }

}
