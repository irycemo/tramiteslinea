<?php

namespace App\Livewire\Catastro\Avisos;

use App\Models\File;
use App\Models\Aviso;
use App\Models\Predio;
use Livewire\Component;
use App\Constantes\Constantes;
use App\Traits\BuscarPersonaTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Services\SGCService;

class ActoEscrituraRevision extends Component
{

    use BuscarPersonaTrait;

    public $avisoId;
    public Aviso $aviso;
    public Predio $predio;

    public $actos;
    public $tipos_escritura;
    public $actualizacion = false;

    public $radio;
    public $años;
    public $año_aviso;
    public $folio_aviso;
    public $usuario_aviso;
    public $aviso_aclaratorio;

    public $localidad;
    public $oficina;
    public $tipo_predio;
    public $numero_registro;

    protected function rules(){
        return [
            'predio' => 'required',
            'aviso.acto' => 'required',
            'aviso.fecha_ejecutoria' => 'nullable|date',
            'aviso.tipo_escritura' => 'required',
            'aviso.numero_escritura' => 'required|numeric',
            'aviso.volumen_escritura' => 'required|numeric',
            'aviso.lugar_otorgamiento' => 'required',
            'aviso.fecha_otorgamiento' => 'required|date',
            'aviso.lugar_firma' => 'required',
            'aviso.fecha_firma' => 'required|date',
         ];
    }

    public function consultarAviso(){

        $this->validate([
            'año_aviso' => 'required',
            'folio_aviso' => 'required',
            'usuario_aviso' => 'required',
        ]);

        try {

            $this->aviso_aclaratorio = Aviso::where('año', $this->año_aviso)
                                        ->where('folio', $this->folio_aviso)
                                        ->where('usuario', $this->usuario_aviso)
                                        ->where('estado', 'operado')
                                        ->where('entidad_id', auth()->user()->entidad_id)
                                        ->first();

            if(!$this->aviso_aclaratorio){

                throw new GeneralException('El trámite del aviso aclaratorio no existe.');

            }

            DB::transaction(function (){

                $this->clonarAviso();

                $this->aviso = Aviso::create([
                    'aviso_id' => $this->aviso_aclaratorio->id,
                    'tipo' => 'revision',
                    'estado' => 'nuevo',
                    'predio_sgc' => $this->aviso_aclaratorio->predio_sgc,
                    'año' => now()->format('Y'),
                    'usuario' => auth()->user()->clave,
                    'folio' => (Aviso::where('año', now()->format('Y'))->where('usuario', auth()->user()->clave)->max('folio') ?? 0) + 1,
                    'creado_por' => auth()->id(),
                    'predio_id' => $this->predio->id,
                    'entidad_id' => auth()->user()->entidad_id
                ]);

                $this->clonarRelaciones();

            });

            $this->dispatch('cargarAviso', $this->aviso->id);

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        }catch (\Throwable $th) {

            Log::error("Error al consultar aviso aclaratorio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function consultarCuentaPredial(){

        $this->validate([
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo_predio' => 'required',
            'numero_registro' => 'required',
        ]);

        try {

            $data = (new SGCService())->consultarPredio($this->localidad, $this->oficina, $this->tipo_predio, $this->numero_registro);


        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        }catch (\Throwable $th) {

            Log::error("Error al consultar predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function clonarAviso(){

        $this->predio = $this->aviso_aclaratorio->predio->replicate();

        $this->predio->save();

        foreach($this->aviso_aclaratorio->predio->colindancias as $colindancia){

            $this->predio->colindancias()->create([
                'viento' => $colindancia['viento'],
                'longitud' => $colindancia['longitud'],
                'descripcion' => $colindancia['descripcion'],
            ]);

        }

        $this->aviso_aclaratorio->predio->actores->load('persona');

        foreach($this->aviso_aclaratorio->predio->actores as $actor){

            $this->predio->actores()->create([
                'tipo' => $actor->tipo,
                'persona_id' => $actor->persona->id,
                'porcentaje_propiedad' => $actor->porcentaje_propiedad,
                'porcentaje_nuda' => $actor->porcentaje_nuda,
                'porcentaje_usufructo' => $actor->porcentaje_usufructo,
            ]);

        }

    }

    public function clonarRelaciones(){

        foreach ($this->aviso_aclaratorio->files as $archivo) {

            File::create([
                'fileable_id' => $this->aviso->id,
                'fileable_type' => 'App\Models\Aviso',
                'url' => $archivo->url,
                'descripcion' => $archivo->descripcion,
            ]);

        }

        foreach($this->aviso_aclaratorio->antecedentes as $antecedente){

            $this->aviso->antecedentes()->create([
                'folio_real' => $antecedente->folio_real,
                'movimiento_registral' => $antecedente->movimiento_registral,
                'tomo' => $antecedente->tomo,
                'registro' => $antecedente->registro,
                'seccion' => $antecedente->seccion,
                'distrito' => $antecedente->distrito,
                'acto' => $antecedente->acto,
            ]);

        }

    }

    public function guardar(){

        $this->validate();

        try {

            $this->aviso->entidad_id = auth()->user()->entidad_id;
            $this->aviso->creado_por = auth()->id();
            $this->aviso->save();

            $this->dispatch('cargarAviso', $this->aviso->id);

            $this->dispatch('mostrarMensaje', ['success', "El aviso se guardó correctamente."]);

            $this->actualizacion = true;


        } catch (\Throwable $th) {

            Log::error("Error al crear aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function actualizar(){

        $this->validate();

        try {

            $this->aviso->actualizado_por = auth()->id();
            $this->aviso->save();

            $this->dispatch('mostrarMensaje', ['success', "El aviso se actualizó correctamente."]);

            $this->dispatch('cargarAviso', $this->aviso->id);

            $this->actualizacion = true;


        } catch (\Throwable $th) {

            Log::error("Error al crear aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function mount(){

        if($this->avisoId){

            $this->aviso = Aviso::find($this->avisoId);

            $this->predio = $this->aviso->predio;

            $this->actualizacion = true;

        }

        $this->actos = Constantes::ACTOS;

        $this->tipos_escritura = Constantes::TIPO_ESCRITURA;

        $this->años = Constantes::AÑOS;

        $this->año_aviso = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.catastro.avisos.acto-escritura-revision');
    }
}
