<?php

namespace App\Livewire\Catastro\Avisos;

use App\Models\Aviso;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Constantes\Constantes;
use App\Traits\ColindanciasTrait;
use App\Traits\CoordenadasTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IdentificacionInmuebleRevision extends Component
{

    use ColindanciasTrait;
    use CoordenadasTrait;

    public Aviso $aviso;
    public $avisoId;

    public $tipoAsentamientos;
    public $tipoVialidades;

    protected function rules(){

        return [
            'aviso.cantidad_tramitada' => 'required',
            'aviso.predio.tipo_asentamiento' => 'required',
            'aviso.predio.nombre_asentamiento' => 'required',
            'aviso.predio.tipo_vialidad' => 'required',
            'aviso.predio.nombre_vialidad' => 'required',
            'aviso.predio.numero_exterior' => 'required',
            'aviso.predio.numero_exterior_2' => 'nullable',
            'aviso.predio.numero_interior' => 'nullable',
            'aviso.predio.numero_adicional_2' => 'nullable',
            'aviso.predio.numero_adicional' => 'nullable',
            'aviso.predio.codigo_postal' => 'required|numeric',
            'aviso.predio.lote_fraccionador' => 'nullable',
            'aviso.predio.manzana_fraccionador' => 'nullable',
            'aviso.predio.etapa_fraccionador' => 'nullable',
            'aviso.predio.nombre_predio'  => 'nullable',
            'aviso.predio.nombre_edificio' => 'nullable',
            'aviso.predio.clave_edificio' => 'nullable',
            'aviso.predio.departamento_edificio' => 'nullable',
            'aviso.predio.xutm' => 'nullable|string',
            'aviso.predio.yutm' => 'nullable|string',
            'aviso.predio.zutm' => 'nullable',
            'aviso.predio.lat' => 'required|numeric',
            'aviso.predio.lon' => 'required|numeric',
         ] + $this->rulesColindancias;

    }

    protected function validationAttributes()
    {

        return [
            'aviso.cantidad_tramitada' => 'cantidad tramitada',
        ] + $this->validationAttributesColindancias;

    }

    #[On('cargarAviso')]
    public function cargarAviso($id = null){

        if(isset($this->avisoId)){

            $this->aviso = Aviso::find($this->avisoId);

        }else{

            $this->aviso = Aviso::find($id);

        }

        $this->cargarColindancias($this->aviso->predio);

    }

    public function guardar(){

        $this->validate();

        try {

            DB::transaction(function () {

                $this->guardarColindancias($this->aviso->predio);

                $this->aviso->predio->save();
                $this->aviso->actualizado_por = auth()->id();
                $this->aviso->save();

            });

            $this->dispatch('mostrarMensaje', ['success', "La información se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al guardar identificación del inmueble por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }


    }

    public function mount(){

        $this->vientos = Constantes::VIENTOS;

        if($this->avisoId){

            $this->cargarAviso();

        }

        $this->tipoAsentamientos = Constantes::TIPO_ASENTAMIENTO;

        $this->tipoVialidades = Constantes::TIPO_VIALIDADES;

    }

    public function render()
    {
        return view('livewire.catastro.avisos.identificacion-inmueble-revision');
    }
}
