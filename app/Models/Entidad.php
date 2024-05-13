<?php

namespace App\Models;

use App\Models\Aviso;
use App\Models\Observacion;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entidad extends Model
{

    use HasFactory;
    use ModelosTrait;
    use Notifiable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function avisos(){
        return $this->hasMany(Aviso::class);
    }

    public function titular(){
        return $this->belongsTo(User::class, 'notario');
    }

    public function notarioAdscrito(){
        return $this->belongsTo(User::class, 'adscrito');
    }

    public function observaciones(){
        return $this->hasMany(Observacion::class);
    }

    public function nombre(){

        if($this->numero_notaria){

            return 'Notaria ' . $this->numero_notaria;

        }else{

            return $this->dependencia;

        }

    }

}
