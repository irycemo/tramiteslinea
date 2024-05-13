<?php

namespace App\Models;

use App\Models\Aviso;
use App\Models\Entidad;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Observacion extends Model
{

    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function aviso(){
        return $this->belongsTo(Aviso::class);
    }

    public function entidad(){
        return $this->belongsTo(Entidad::class);
    }

}
