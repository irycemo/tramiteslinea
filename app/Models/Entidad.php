<?php

namespace App\Models;

use App\Models\Aviso;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entidad extends Model
{

    use HasFactory;
    use ModelosTrait;

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

}
