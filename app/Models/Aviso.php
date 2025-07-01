<?php

namespace App\Models;

use App\Models\File;
use App\Models\Predio;
use App\Models\Entidad;
use App\Models\Antecedente;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Aviso extends Model implements Auditable
{

    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getEstadoColorAttribute()
    {
        return [
            'nuevo' => 'blue-400',
            'cerrado' => 'green-400',
            'autorizado' => 'indigo-400',
            'rechazado' => 'red-400',
        ][$this->estado] ?? 'gray-400';
    }

    public function entidad(){
        return $this->belongsTo(Entidad::class);
    }

    public function antecedentes(){
        return $this->hasMany(Antecedente::class);
    }

    public function files(){
        return $this->morphMany(File::class, 'fileable');
    }

    public function archivo(){
        return $this->morphOne(File::class, 'fileable')->where('descripcion', 'archivo');
    }

    public function croquis(){
        return $this->morphOne(File::class, 'fileable')->where('descripcion', 'croquis');
    }

    public function predio(){
        return $this->belongsTo(Predio::class);
    }

    public function cuentaPredial(){

        return $this->localidad . '-' . $this->oficina . '-' . $this->tipo_predio . '-' . $this->numero_registro;

    }

    public function claveCatastral(){

        return '16-' . $this->region_catastral . '-' . $this->municipio . '-' . $this->zona_catastral . '-' . $this->localidad . '-' . $this->sector . '-' . $this->manzana . '-' . $this->predio . '-' . $this->edificio . '-' . $this->departamento;

    }

}
