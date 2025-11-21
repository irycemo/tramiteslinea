<?php

namespace App\Livewire\Comun;

use Livewire\Component;
use Illuminate\Support\Arr;
use App\Services\SGCService;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;

class OficinasCatastro extends Component
{

    public $search;
    public $paginaActual = 1;
    public $paginaAnterior;
    public $paginaSiguiente;
    public $pagination = 10;

    public $modal = false;

    public $oficinaSeleccionada;

    public function nextPage(){ (int)$this->paginaActual++; $this->dispatch('gotoTop'); }

    public function previousPage(){ (int)$this->paginaActual--; $this->dispatch('gotoTop'); }

    public function abrirModalVerOficina($oficina){

        $this->modal = true;

        $this->oficinaSeleccionada =  $oficina;

    }

    public function render()
    {

        $oficinas = [];

        try {

            $data = (new SGCService())->consultarOficinas(
                                                            $this->search,
                                                            $this->paginaActual,
                                                            $this->pagination
                                                        );

            $this->paginaActual = Arr::get($data, 'meta.current_page');
            $this->paginaAnterior = Arr::get($data, 'links.prev');
            $this->paginaSiguiente = Arr::get($data, 'links.next');

            $oficinas = collect($data['data']);

        } catch (GeneralException $ex) {

            abort(403, message:$ex->getMessage());

        } catch (\Throwable $th) {

            Log::error("Error al consultar consultar oficinas es SGC. " . $th);

            abort(403, message:"Error al consultar oficinas");

        }


        return view('livewire.comun.oficinas-catastro', compact('oficinas'))->extends('layouts.admin');
    }
}
