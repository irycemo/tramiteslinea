<?php

namespace App\Livewire\Catastro\Avisos;

use App\Models\File;
use App\Models\Aviso;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\SGCService;
use Livewire\WithFileUploads;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Storage;

class ArchivoRevision extends Component
{

    use WithFileUploads;

    public Aviso $aviso;
    public $avisoId;

    public $documento;

    public $modal = false;
    public $años;
    public $año_aviso;
    public $folio_aviso;
    public $usuario_aviso;
    public $nombre_entidad;

    protected function rules(){
        return [
            'documento' => 'nullable|mimes:pdf',
            'aviso.observaciones' => 'nullable'
        ];
    }

    #[On('cargarAviso')]
    public function cargarAviso($id = null){

        if(isset($this->avisoId)){

            $this->aviso = Aviso::with('predio')->find($this->avisoId);

        }else{

            $this->aviso = Aviso::with('predio')->find($id);

        }

    }

    public function abrirModal(){

        try {

            $this->revisarAvisoCompleto();

            $this->modal = true;

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);
        }

    }

    public function revisarAvisoCompleto(){

        if(!$this->aviso->predio->colindancias->count()){

            throw new GeneralException("Debe ingresar las colindancias.");

        }

        if($this->aviso->aviso_id){

            if(!$this->aviso->predio->transmitentes()->count()){

                throw new GeneralException("Debe ingresar la información de transmitentes.");

            }

        }

        if(!$this->aviso->predio->adquirientes()->count()){

            throw new GeneralException("Debe ingresar la información de adquirientes.");

        }

        if(!$this->aviso->archivo()->first()){

            throw new GeneralException("Debe subir el archivo.");

        }

        if($this->aviso->aviso_id){

            $this->revisarPorcentajesConTransmitentes();

        }else{

            $this->revisarPorcentajesSinTransmitentes();

        }

    }

    public function revisarPorcentajesConTransmitentes(){

        $porcentaje_propiedad_transmitentes = $this->aviso->predio->actores()->where('tipo', 'transmitente')->sum('porcentaje_propiedad');

        $porcentaje_nuda_transmitentes = $this->aviso->predio->actores()->where('tipo', 'transmitente')->sum('porcentaje_nuda');

        $porcentaje_usufructo_transmitentes = $this->aviso->predio->actores()->where('tipo', 'transmitente')->sum('porcentaje_usufructo');

        $porcentaje_propiedad_adquirientes = $this->aviso->predio->actores()->where('tipo', 'adquiriente')->sum('porcentaje_propiedad');

        $porcentaje_nuda_adquirientes = $this->aviso->predio->actores()->where('tipo', 'adquiriente')->sum('porcentaje_nuda');

        $porcentaje_usufructo_adquirientes = $this->aviso->predio->actores()->where('tipo', 'adquiriente')->sum('porcentaje_usufructo');

        if(($porcentaje_propiedad_adquirientes + $porcentaje_nuda_adquirientes) > ($porcentaje_propiedad_transmitentes + $porcentaje_nuda_transmitentes)){

            throw new GeneralException("Revisar los porcentajes de de los adquirientes.");

        }

        if(($porcentaje_propiedad_adquirientes + $porcentaje_usufructo_adquirientes) > ($porcentaje_propiedad_transmitentes + $porcentaje_usufructo_transmitentes)){

            throw new GeneralException("Revisar los porcentajes de de los adquirientes.");

        }

    }

    public function revisarPorcentajesSinTransmitentes(){

        $porcentaje_propiedad_adquirientes = $this->aviso->predio->actores()->where('tipo', 'adquiriente')->sum('porcentaje_propiedad');

        $porcentaje_nuda_adquirientes = $this->aviso->predio->actores()->where('tipo', 'adquiriente')->sum('porcentaje_nuda');

        $porcentaje_usufructo_adquirientes = $this->aviso->predio->actores()->where('tipo', 'adquiriente')->sum('porcentaje_usufructo');

        if(($porcentaje_propiedad_adquirientes + $porcentaje_nuda_adquirientes) < 99.99){

            throw new GeneralException("Revisar los porcentajes de de los adquirientes.");

        }

        if(($porcentaje_propiedad_adquirientes + $porcentaje_usufructo_adquirientes) < 99.99){

            throw new GeneralException("Revisar los porcentajes de de los adquirientes.");

        }

    }

    public function revisarAvisosConIdTramite($id){

        $aviso = Aviso::where('tramite_sgc', $id)->first();

        if($aviso && $aviso->id != $this->aviso->id) throw new GeneralException("El trámite del aviso ya esta asociado con otro aviso.");

    }


    public function cerrar(){

        try {

            $this->revisarAvisoCompleto();

            $data_tramite_aviso = (new SGCService())->consultarTramieAviso($this->año_aviso, $this->folio_aviso, $this->usuario_aviso, $this->aviso->predio_sgc);

            $this->revisarAvisosConIdTramite($data_tramite_aviso['tramite_id']);

            $data_traslado = (new SGCService())->ingresarRevisionAviso(
                                                                    $this->aviso->predio_sgc,
                                                                    (int)$data_tramite_aviso['tramite_id'],
                                                                    $this->aviso->id,
                                                                    $this->aviso->entidad_id,
                                                                    $this->aviso->entidad->nombre(),
                                                                );

            $this->aviso->update([
                'tramite_sgc' => $data_tramite_aviso['tramite_id'],
                'traslado_sgc' => $data_traslado['traslado_id'],
                'estado' => 'cerrado'
            ]);

            return to_route('mis_revisiones');

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al cerrar aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function guardar(){

        $this->validate();

        try {

            DB::transaction(function () {

                if($this->documento){

                    if($this->aviso->archivo()->first()){

                        $file = File::where('fileable_id', $this->aviso->id)
                                        ->where('fileable_type', 'App\Models\Aviso')
                                        ->where('descripcion', 'archivo')
                                        ->first();

                        Storage::disk('avisos')->delete($file->url);

                        $file->delete();

                    }

                    $pdf = $this->documento->store('/', 'avisos');

                    File::create([
                        'fileable_id' => $this->aviso->id,
                        'fileable_type' => 'App\Models\Aviso',
                        'descripcion' => 'archivo',
                        'url' => $pdf
                    ]);

                }

                $this->aviso->actualizado_por = auth()->id();
                $this->aviso->save();

                $this->dispatch('mostrarMensaje', ['success', "La información se guardó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al giuardar archivo de aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        if($this->avisoId){

            $this->cargarAviso();

        }

        $this->años = Constantes::AÑOS;

        $this->año_aviso = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.catastro.avisos.archivo-revision');
    }
}
