<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{

    protected $fillable = ['fileable_id', 'fileable_type', 'url', 'descripcion'];

    public function fileable(){
        return $this->morphTo();
    }

    public function getLink(){

        if(app()->isProduction()){

            return Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_caratulas') . $this->url, now()->addMinutes(60));

        }else{

            return Storage::disk('caratulas')->url($this->url);

        }

    }

}
