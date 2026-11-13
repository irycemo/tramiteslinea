<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\File;
use App\Traits\ModelosTrait;

class AvisoPreventivo extends Model
{

    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getEstadoColorAttribute()
    {
        return [
            'nuevo' => 'blue-400',
            'elaborado' => 'green-400',
        ][$this->estado] ?? 'gray-400';
    }

    public function entidad(){
        return $this->belongsTo(Entidad::class);
    }

    public function documentoEntrada(){
        return $this->morphOne(File::class, 'fileable');
    }

    public function tramiteFolio(){

        return $this->tramite_año . '-' . $this->tramite_folio . '-' . $this->tramite_usuario;

    }

}
