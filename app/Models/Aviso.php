<?php

namespace App\Models;

use App\Models\File;
use App\Models\Actor;
use App\Models\Entidad;
use App\Models\Antecedente;
use App\Models\Colindancia;
use App\Models\Observacion;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aviso extends Model
{

    use HasFactory;
    use ModelosTrait;

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

    public function colindancias(){
        return $this->hasMany(Colindancia::class);
    }

    public function actores(){
        return $this->hasMany(Actor::class);
    }

    public function transmitentes(){
        return $this->actores()->with('persona')->where('tipo', 'transmitente')->get();
    }

    public function adquirientes(){
        return $this->actores()->with('persona')->where('tipo', 'adquiriente')->get();
    }

    public function fideicomitentes(){
        return $this->actores()->with('persona')->where('tipo', 'fideicomitente')->get();
    }

    public function fideicomisarios(){
        return $this->actores()->with('persona')->where('tipo', 'fideicomisario')->get();
    }

    public function fiduciaria(){
        return $this->actores()->with('persona')->where('tipo', 'fiduciaria')->get();
    }

    public function entidad(){
        return $this->belongsTo(Entidad::class);
    }

    public function antecedentes(){
        return $this->hasMany(Antecedente::class);
    }

    public function archivo(){
        return $this->morphOne(File::class, 'fileable')->where('descripcion', 'archivo');
    }

    public function croquis(){
        return $this->morphOne(File::class, 'fileable')->where('descripcion', 'croquis');
    }

    public function observacionesLista(){
        return $this->hasMany(Observacion::class);
    }

    public function cuentaPredial(){

        return $this->localidad . '-' . $this->oficina . '-' . $this->tipo_predio . '-' . $this->numero_registro;

    }

    public function claveCatastral(){

        return '16-' . $this->region_catastral . '-' . $this->municipio . '-' . $this->zona_catastral . '-' . $this->localidad . '-' . $this->sector . '-' . $this->manzana . '-' . $this->predio . '-' . $this->edificio . '-' . $this->departamento;

    }

}
