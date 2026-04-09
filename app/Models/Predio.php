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
        return $this->actores()->with('persona')->where('tipo', 'transmitente')->get()->sortBy('persona.nombre');
    }

    public function adquirientes(){
        return $this->actores()->with('persona')->where('tipo', 'adquiriente')->get()->sortBy('persona.nombre');
    }

    public function fideicomitentes(){
        return $this->actores()->with('persona')->where('tipo', 'fideicomitente')->get()->sortBy('persona.nombre');
    }

    public function fideicomisarios(){
        return $this->actores()->with('persona')->where('tipo', 'fideicomisario')->get()->sortBy('persona.nombre');
    }

    public function fiduciarias(){
        return $this->actores()->with('persona')->where('tipo', 'fiduciaria')->get()->sortBy('persona.nombre');
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

    public function getSuperficieConstruccionFormateadaAttribute(){

        if($this->attributes['superficie_construccion'] == 0) return null;

        $partes = explode('.', strval($this->attributes['superficie_construccion']));

        return $partes[0] . $this->parteDecimal($this->attributes['superficie_construccion']);

    }

    public function getSuperficieTotalConstruccionFormateadaAttribute(){

        if($this->attributes['superficie_total_construccion'] == 0) return null;

        $partes = explode('.', strval($this->attributes['superficie_total_construccion']));

        return $partes[0] . $this->parteDecimal($this->attributes['superficie_total_construccion']);

    }

    public function getSuperficieTerrenoFormateadaAttribute(){

        if($this->attributes['superficie_terreno'] == 0) return null;

        if($this->tipo_predio == 2){

            $string =  str_pad((string)(intval($this->attributes['superficie_terreno'])), 6, '0', STR_PAD_LEFT);

            return substr($string,0, -4) . '-' .
                    substr($string,-4, -2) . '-' .
                    substr($string, -2, strlen($string)) .
                    $this->parteDecimal($this->attributes['superficie_terreno']);

        }else{

            $partes = explode('.', strval($this->attributes['superficie_terreno']));

            return $partes[0] . $this->parteDecimal($this->attributes['superficie_terreno']);

        }

    }

    public function getSuperficieTotalTerrenoFormateadaAttribute(){

        if($this->attributes['superficie_total_terreno'] == 0) return null;

        if($this->tipo_predio == 2){

            $string =  str_pad((string)(intval($this->attributes['superficie_total_terreno'])), 6, '0', STR_PAD_LEFT);

            return substr($string,0, -4) . '-' .
                    substr($string,-4, -2) . '-' .
                    substr($string, -2, strlen($string)) .
                    $this->parteDecimal($this->attributes['superficie_total_terreno']);

        }else{

            $partes = explode('.', strval($this->attributes['superficie_total_terreno']));

            return $partes[0] . $this->parteDecimal($this->attributes['superficie_total_terreno']);

        }

    }

    public function getSuperficieNotarialFormateadaAttribute(){

        if($this->attributes['superficie_notarial'] == 0) return null;

        if($this->tipo_predio == 2){

            $string =  str_pad((string)(intval($this->attributes['superficie_notarial'])), 6, '0', STR_PAD_LEFT);

            return substr($string,0, -4) . '-' .
                    substr($string,-4, -2) . '-' .
                    substr($string, -2, strlen($string)) .
                    $this->parteDecimal($this->attributes['superficie_notarial']);

        }else{

            $partes = explode('.', strval($this->attributes['superficie_notarial']));

            return $partes[0] . $this->parteDecimal($this->attributes['superficie_notarial']);

        }

    }

    public function getSuperficieJudicialFormateadaAttribute(){

        if($this->attributes['superficie_judicial'] == 0) return null;

        if($this->tipo_predio == 2){

            $string =  str_pad((string)(intval($this->attributes['superficie_judicial'])), 6, '0', STR_PAD_LEFT);

            return substr($string,0, -4) . '-' .
                    substr($string,-4, -2) . '-' .
                    substr($string, -2, strlen($string)) .
                    $this->parteDecimal($this->attributes['superficie_judicial']);

        }else{

            $partes = explode('.', strval($this->attributes['superficie_judicial']));

            return $partes[0] . $this->parteDecimal($this->attributes['superficie_judicial']);

        }

    }

    public function parteDecimal($numero){

        $numero = $numero + 0.0;

        $partes = explode('.', strval($numero));

        if(!isset($partes[1])){

            return '.00';

        }

        $lenDecimal = strlen($partes[1]);

        if($lenDecimal == 1){

            return '.' . $partes[1] . '0';

        }

        return '.' . $partes[1];

    }

}
