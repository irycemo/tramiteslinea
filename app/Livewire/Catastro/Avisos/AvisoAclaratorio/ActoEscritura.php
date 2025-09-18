<?php

namespace App\Livewire\Catastro\Avisos\AvisoAclaratorio;

use App\Models\File;
use App\Models\Aviso;
use App\Models\Predio;
use App\Models\Persona;
use Livewire\Component;
use App\Services\SGCService;
use App\Constantes\Constantes;
use App\Traits\BuscarPersonaTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;

class ActoEscritura extends Component
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
    public $revision_aviso;

    public $aclaratorio_año;
    public $aclaratorio_folio;
    public $aclaratorio_usuario;

    public $localidad;
    public $oficina;
    public $tipo_predio;
    public $numero_registro;

    public $data_tramite_aviso;

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
            'aclaratorio_año' => 'required',
            'aclaratorio_folio' => 'required',
            'aclaratorio_usuario' => 'required',
        ]);

        try {

            $this->revision_aviso = Aviso::where('año', $this->año_aviso)
                                        ->where('folio', $this->folio_aviso)
                                        ->where('usuario', $this->usuario_aviso)
                                        ->where('entidad_id', auth()->user()->entidad_id)
                                        ->first();

            if(!$this->revision_aviso){

                throw new GeneralException('El trámite del aviso aclaratorio no existe.');

            }

            if($this->revision_aviso->estado != 'operado'){

                throw new GeneralException('El trámite de la revisión de aviso no esta operado.');

            }

            $this->data_tramite_aviso = (new SGCService())->consultarTramieAvisoAclaratorio($this->aclaratorio_año, $this->aclaratorio_folio, $this->aclaratorio_usuario, null);

            DB::transaction(function (){

                $this->clonarAviso();

                $this->aviso = Aviso::create([
                    'aviso_id' => $this->revision_aviso->id,
                    'tipo' => 'aclaratorio',
                    'estado' => 'nuevo',
                    'predio_sgc' => $this->revision_aviso->predio_sgc,
                    'año' => now()->format('Y'),
                    'usuario' => auth()->user()->clave,
                    'folio' => (Aviso::where('año', now()->format('Y'))->where('usuario', auth()->user()->clave)->max('folio') ?? 0) + 1,
                    'creado_por' => auth()->id(),
                    'predio_id' => $this->predio->id,
                    'entidad_id' => auth()->user()->entidad_id,
                    'tramite_sgc' => $this->data_tramite_aviso['tramite_id']
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
            'aclaratorio_año' => 'required',
            'aclaratorio_folio' => 'required',
            'aclaratorio_usuario' => 'required',
        ]);

        try {

            DB::transaction(function (){

                $data_predio = (new SGCService())->consultarPredio($this->localidad, $this->oficina, $this->tipo_predio, $this->numero_registro);

                $this->data_tramite_aviso = (new SGCService())->consultarTramieAvisoAclaratorio($this->aclaratorio_año, $this->aclaratorio_folio, $this->aclaratorio_usuario, $data_predio['id']);

                $this->procesarPredio($data_predio);

                $this->aviso = Aviso::create([
                    'tipo' => 'aclaratorio',
                    'estado' => 'nuevo',
                    'predio_sgc' => $data_predio['id'],
                    'año' => now()->format('Y'),
                    'usuario' => auth()->user()->clave,
                    'folio' => (Aviso::where('año', now()->format('Y'))->where('usuario', auth()->user()->clave)->max('folio') ?? 0) + 1,
                    'creado_por' => auth()->id(),
                    'predio_id' => $this->predio->id,
                    'entidad_id' => auth()->user()->entidad_id,
                    'tramite_sgc' => $this->data_tramite_aviso['tramite_id']
                ]);

            });

            $this->dispatch('cargarAviso', $this->aviso->id);

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        }catch (\Throwable $th) {

            Log::error("Error al consultar predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function clonarAviso(){

        $this->predio = $this->revision_aviso->predio->replicate();

        $this->predio->save();

        foreach($this->revision_aviso->predio->colindancias as $colindancia){

            $this->predio->colindancias()->create([
                'viento' => $colindancia['viento'],
                'longitud' => $colindancia['longitud'],
                'descripcion' => $colindancia['descripcion'],
            ]);

        }

        $this->revision_aviso->predio->actores->load('persona');

        foreach($this->revision_aviso->predio->actores as $actor){

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

        foreach ($this->revision_aviso->files as $archivo) {

            File::create([
                'fileable_id' => $this->aviso->id,
                'fileable_type' => 'App\Models\Aviso',
                'url' => $archivo->url,
                'descripcion' => $archivo->descripcion,
            ]);

        }

        foreach($this->revision_aviso->antecedentes as $antecedente){

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

    public function procesarPredio($data){

        $this->predio = Predio::create([
            'estado' => $data['estado'],
            'region_catastral' => $data['region_catastral'],
            'municipio' => $data['municipio'],
            'zona_catastral' => $data['zona_catastral'],
            'localidad' => $data['localidad'],
            'sector' => $data['sector'],
            'manzana' => $data['manzana'],
            'predio' => $data['predio'],
            'edificio' => $data['edificio'],
            'departamento' => $data['departamento'],
            'oficina' => $data['oficina'],
            'tipo_predio' => $data['tipo_predio'],
            'numero_registro' => $data['numero_registro'],
            'codigo_postal' => $data['codigo_postal'],
            'nombre_asentamiento' => $data['nombre_asentamiento'],
            'tipo_asentamiento' => $data['tipo_asentamiento'],
            'tipo_vialidad' => $data['tipo_vialidad'],
            'nombre_vialidad' => $data['nombre_vialidad'],
            'numero_exterior' => $data['numero_exterior'],
            'numero_exterior_2' => $data['numero_exterior_2'],
            'numero_interior' => $data['numero_interior'],
            'numero_adicional' => $data['numero_adicional'],
            'numero_adicional_2' => $data['numero_adicional_2'],
            'lote_fraccionador' => $data['lote_fraccionador'],
            'manzana_fraccionador' => $data['manzana_fraccionador'],
            'etapa_fraccionador' => $data['etapa_fraccionador'],
            'nombre_edificio' => $data['nombre_edificio'],
            'clave_edificio' => $data['clave_edificio'],
            'departamento_edificio' => $data['departamento_edificio'],
            'nombre_predio' => $data['nombre_predio'],
            'xutm' => $data['xutm'],
            'yutm' => $data['yutm'],
            'zutm' => $data['zutm'],
            'lon' => $data['lon'],
            'lat' => $data['lat'],
            'uso_1' => $data['uso_1'],
            'uso_2' => $data['uso_2'],
            'uso_3' => $data['uso_3'],
            'superficie_terreno' => $data['superficie_terreno'],
            'area_comun_terreno' => $data['area_comun_terreno'],
            'superficie_construccion' => $data['superficie_construccion'],
            'area_comun_construccion' => $data['area_comun_construccion'],
            'superficie_total_terreno' => $data['superficie_total_terreno'],
            'superficie_total_construccion' => $data['superficie_total_construccion'],
            'valor_total_terreno' => $data['valor_total_terreno'],
            'valor_total_construccion' => $data['valor_total_construccion'],
            'valor_catastral' => $data['valor_catastral'],
        ]);

        foreach($data['colindancias'] as $colindancia){

            $this->predio->colindancias()->create([
                'viento' => $colindancia['viento'],
                'longitud' => $colindancia['longitud'],
                'descripcion' => $colindancia['descripcion'],
            ]);

        }

        foreach($data['propietarios'] as $propietario){

            $persona = $this->buscarPersona(
                                                $propietario['persona']['rfc'],
                                                $propietario['persona']['curp'],
                                                $propietario['persona']['tipo'],
                                                $propietario['persona']['nombre'],
                                                $propietario['persona']['ap_materno'],
                                                $propietario['persona']['ap_paterno'],
                                                $propietario['persona']['razon_social']

                                            );

            if(!$persona){

                $persona = Persona::create([
                    'tipo' => $propietario['persona']['tipo'],
                    'nombre' => $propietario['persona']['nombre'],
                    'multiple_nombre' => $propietario['persona']['multiple_nombre'],
                    'ap_paterno' => $propietario['persona']['ap_paterno'],
                    'ap_materno' => $propietario['persona']['ap_materno'],
                    'curp' => $propietario['persona']['curp'],
                    'rfc' => $propietario['persona']['rfc'],
                    'razon_social' => $propietario['persona']['razon_social'],
                    'fecha_nacimiento' => $propietario['persona']['fecha_nacimiento'],
                    'nacionalidad' => $propietario['persona']['nacionalidad'],
                    'estado_civil' => $propietario['persona']['estado_civil'],
                    'calle' => $propietario['persona']['calle'],
                    'numero_exterior' => $propietario['persona']['numero_exterior'],
                    'numero_interior' => $propietario['persona']['numero_interior'],
                    'colonia' => $propietario['persona']['colonia'],
                    'entidad' => $propietario['persona']['entidad'],
                    'municipio' => $propietario['persona']['municipio'],
                    'ciudad' => $propietario['persona']['ciudad'],
                    'cp' => $propietario['persona']['cp']
                ]);

            }

            $this->predio->actores()->create([
                'tipo' => 'transmitente',
                'persona_id' => $persona->id,
                'porcentaje_propiedad' => $propietario['porcentaje_propiedad'],
                'porcentaje_nuda' => $propietario['porcentaje_nuda'],
                'porcentaje_usufructo' => $propietario['porcentaje_usufructo'],
            ]);

        }

    }

    public function guardar(){

        $this->validate();

        try {

            $this->aviso->entidad_id = auth()->user()->entidad_id;
            $this->aviso->creado_por = auth()->id();
            $this->aviso->save();

            $this->aviso->audits()->latest()->first()->update(['tags' => 'Guardó acto de escritura']);

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

            $this->aviso->audits()->latest()->first()->update(['tags' => 'actualizó acto de escritura']);

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

        $this->aclaratorio_año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.catastro.avisos.aviso-aclaratorio.acto-escritura');
    }
}
