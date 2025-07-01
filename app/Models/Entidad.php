<?php

namespace App\Models;

use App\Models\User;
use App\Models\Aviso;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Entidad extends Model
{

    use ModelosTrait;
    use Notifiable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function avisos(){
        return $this->hasMany(Aviso::class);
    }

    public function notarioTitular(){
        return $this->belongsTo(User::class, 'notario');
    }

    public function notarioAdscrito(){
        return $this->belongsTo(User::class, 'adscrito');
    }

    public function nombre(){

        if($this->numero_notaria){

            return 'Notaria ' . $this->numero_notaria;

        }elseif($this->dependencia){

            return $this->dependencia;

        }else{

            return null;

        }

    }

}
