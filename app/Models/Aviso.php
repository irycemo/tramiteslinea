<?php

namespace App\Models;

use App\Models\Actor;
use App\Models\Entidad;
use App\Models\Colindancia;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aviso extends Model
{

    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function colindancias(){
        return $this->hasMany(Colindancia::class);
    }

    public function actores(){
        return $this->hasMany(Actor::class);
    }

    public function transmitentes(){
        return $this->actores()->with('persona')->where('tipo', 'transmitente')->get();
    }

    public function entidad(){
        return $this->belongsTo(Entidad::class);
    }

}
