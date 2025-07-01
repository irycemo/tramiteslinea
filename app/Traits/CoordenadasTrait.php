<?php

namespace App\Traits;

use App\Services\Coordenadas\Coordenadas;


trait CoordenadasTrait
{

    public function updatedAvisoPredioXutm(){
        $this->convertirCoordenadas();
    }

    public function updatedAvisoPredioYutm(){
        $this->convertirCoordenadas();
    }

    public function updatedAvisoPredioZutm(){
        $this->convertirCoordenadas();
    }

    public function updatedAvisoPredioLat(){
        $this->convertirCoordenadas();
    }

    public function updatedAvisoPredioLon(){
        $this->convertirCoordenadas();
    }

    public function convertirCoordenadas(){

        if($this->aviso->predio->xutm && $this->aviso->predio->yutm && $this->aviso->predio->zutm){

            $ll = (new Coordenadas())->utm2ll($this->aviso->predio->xutm, $this->aviso->predio->yutm, $this->aviso->predio->zutm, true);

            if(!$ll['success']){

                $this->dispatch('mostrarMensaje', ['warning', $ll['msg']]);

                return;

            }else{

                $this->aviso->predio->lat = $ll['attr']['lat'];
                $this->aviso->predio->lon = $ll['attr']['lon'];

            }


        }elseif($this->aviso->predio->lat && $this->aviso->predio->lon){

            $ll = (new Coordenadas())->ll2utm($this->aviso->predio->lat, $this->aviso->predio->lon);

            if(!$ll['success']){

                $this->dispatch('mostrarMensaje', ['warning', $ll['msg']]);

                return;

            }else{

                if((float)$ll['attr']['zone'] < 13 || (float)$ll['attr']['zone'] > 14){

                    $this->dispatch('mostrarMensaje', ['warning', "Las coordenadas no corresponden a una zona válida."]);

                    $this->aviso->predio->lat = null;
                    $this->aviso->predio->lon = null;

                    return;

                }

                $this->aviso->predio->xutm = strval($ll['attr']['x']);
                $this->aviso->predio->yutm = strval($ll['attr']['y']);
                $this->aviso->predio->zutm = $ll['attr']['zone'];

            }

        }


    }

    public function resetearCoordenadas(){

        $this->reset([
            'aviso.predio.xutm',
            'aviso.predio.yutm',
            'aviso.predio.zutm',
            'aviso.predio.lat' ,
            'aviso.predio.lon' ,
        ]);

    }

}
