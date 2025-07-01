<?php

namespace App\Models;

use App\Models\Actor;
use App\Models\Terreno;
use App\Models\Colindancias;
use App\Models\Construccion;
use App\Models\TerrenoComun;
use App\Models\ConstruccionComun;
use Illuminate\Database\Eloquent\Model;

class Predio extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function colindancias(){
        return $this->hasMany(Colindancias::class);
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

    public function fiduciarias(){
        return $this->actores()->with('persona')->where('tipo', 'fiduciaria')->get();
    }

    public function terrenosComun(){
        return $this->hasMany(TerrenoComun::class);
    }

    public function construccionesComun(){
        return $this->hasMany(ConstruccionComun::class);
    }

    public function terrenos(){
        return $this->hasMany(Terreno::class);
    }

    public function construcciones(){
        return $this->hasMany(Construccion::class);
    }

    public function cuentaPredial(){

        return $this->localidad . '-' . $this->oficina . '-' . $this->tipo_predio . '-' . $this->numero_registro;

    }

    public function claveCatastral(){

        return $this->estado . '-' . $this->region_catastral . '-' . $this->municipio . '-' . $this->zona_catastral . '-' . $this->localidad . '-' . $this->sector . '-' . $this->manzana . '-' . $this->predio . '-' . $this->edificio . '-' . $this->departamento;

    }

}
