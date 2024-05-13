<?php

namespace App\Livewire\Usuarios\Aviso;

use App\Models\Aviso;
use Livewire\Component;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class ActoEscritura extends Component
{

    public $oficinas;
    public $municipios;
    public $municipioSeleccionado;
    public $localidades = [];
    public $localidadSeleccionada;
    public $actos;
    public $tipos_escritura;
    public $actualizacion = false;

    public $numero_registro;
    public $region_catastral;
    public $municipio;
    public $localidad;
    public $sector;
    public $zona_catastral;
    public $manzana;
    public $predio;
    public $edificio;
    public $departamento;
    public $tipo_predio;
    public $oficina;

    public $avisoId;
    public Aviso $aviso;

    public $revision = false;
    public $años;
    public $año_aviso;
    public $folio_aviso;
    public $usuario_aviso;

    protected function rules(){
        return [
            'aviso.predio_sgc' => 'required',
            'aviso.acto' => 'required',
            'aviso.fecha_ejecutoria' => 'required|date',
            'aviso.tipo_escritura' => 'required',
            'aviso.numero_escritura' => 'required|numeric',
            'aviso.volumen_escritura' => 'required|numeric',
            'aviso.lugar_otorgamiento' => 'required|'. utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.fecha_otorgamiento' => 'required|date',
            'aviso.lugar_firma' => 'required|'. utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.fecha_firma' => 'required|date',
            'aviso.estado' => 'required',
            'aviso.region_catastral' => 'required',
            'aviso.municipio' => 'required',
            'aviso.zona_catastral' => 'required',
            'aviso.localidad' => 'required',
            'aviso.sector' => 'required',
            'aviso.manzana' => 'required',
            'aviso.predio' => 'required',
            'aviso.edificio' => 'required',
            'aviso.departamento' => 'required',
            'aviso.oficina' => 'required',
            'aviso.tipo_predio' => 'required',
            'aviso.numero_registro' => 'required',
         ];
    }

    protected $validationAttributes  = [
        'aviso.tipo_escritura' => 'tipo de escritura',
        'aviso.tipo_escritura' => 'tipo de escritura',
        'aviso.numero_escritura' => 'número de escritura',
        'aviso.lugar_otorgamiento' => 'lugar de otorgamiento',
        'aviso.fecha_otorgamiento' => 'fecha de otorgamiento',
        'aviso.lugar_fecha' => 'lugar de fecha',
        'aviso.fecha_fecha' => 'fecha de fecha',
        'aviso.predio' => 'cuenta y clave catastral',
        'aviso.volumen_escritura' => 'volumen'

    ];

    public function updatedMunicipioSeleccionado(){

        $this->reset([
            'aviso.predio',
            'numero_registro',
            'region_catastral',
            'municipio',
            'localidad',
            'sector',
            'zona_catastral',
            'manzana',
            'predio',
            'edificio',
            'departamento',
            'tipo_predio',
            'oficina',
        ]);

        if($this->municipioSeleccionado === ''){

            $this->reset(['localidad', 'oficina', 'municipioSeleccionado', 'localidadSeleccionada']);

            return;

        }

        $this->oficina = $this->oficinas->where('id', $this->municipioSeleccionado)->first()['oficina'];

        $this->localidad = $this->oficinas->where('id', $this->municipioSeleccionado)->first()['localidad'];

        $this->localidades = $this->oficinas->where('cabecera', $this->municipioSeleccionado);

    }

    public function updatedLocalidadSeleccionada(){

        $this->reset([
            'aviso.predio',
            'numero_registro',
            'region_catastral',
            'municipio',
            'localidad',
            'sector',
            'zona_catastral',
            'manzana',
            'predio',
            'edificio',
            'departamento',
            'tipo_predio',
        ]);

        if($this->localidadSeleccionada === ''){

            $this->localidad = 1;

            return;

        }


        $this->localidad = $this->oficinas->where('id', $this->localidadSeleccionada)->first()['localidad'];

    }

    public function updated($property, $value){

        if(in_array($property, ['tipo_predio', 'numero_registro', 'localidad', 'oficina'])){

            $this->reset([
                'aviso.predio',
                'region_catastral',
                'municipio',
                'sector',
                'zona_catastral',
                'manzana',
                'predio',
                'edificio',
                'departamento',
            ]);

        }

    }

    public function crearModeloVacio(){
        $this->aviso = Aviso::make(['estado' => 'nuevo']);
    }

    public function buscarAviso(){

        $this->validate([
            'año_aviso' => 'required',
            'folio_aviso' => 'required',
            'usuario_aviso' => 'required'
        ]);

        $aviso = Aviso::where('año', $this->año_aviso)
                        ->where('folio', $this->folio_aviso)
                        ->where('usuario', $this->usuario_aviso)
                        ->first();

        if(!$aviso){

            $this->dispatch('mostrarMensaje', ['error', "No se encontro el aviso."]);

            return;

        }

        try {

            DB::transaction(function () use($aviso){

                $this->aviso->estado = 'nuevo';
                $this->aviso->predio_sgc = $aviso->predio_sgc;
                $this->aviso->año = now()->format('Y');
                $this->aviso->folio = (Aviso::where('año', $this->aviso->año)->where('usuario', auth()->user()->clave)->max('folio') ?? 0) + 1;
                $this->aviso->usuario = auth()->user()->clave;
                $this->aviso->region_catastral = $aviso->region_catastral;
                $this->aviso->municipio = $aviso->municipio;
                $this->aviso->zona_catastral = $aviso->zona_catastral;
                $this->aviso->localidad = $aviso->localidad;
                $this->aviso->sector = $aviso->sector;
                $this->aviso->manzana = $aviso->manzana;
                $this->aviso->predio = $aviso->predio;
                $this->aviso->edificio = $aviso->edificio;
                $this->aviso->departamento = $aviso->departamento;
                $this->aviso->oficina = $aviso->oficina;
                $this->aviso->tipo_predio = $aviso->tipo_predio;
                $this->aviso->numero_registro = $aviso->numero_registro;
                $this->aviso->acto = $aviso->acto;
                $this->aviso->fecha_ejecutoria = $aviso->fecha_ejecutoria;
                $this->aviso->tipo_escritura = $aviso->tipo_escritura;
                $this->aviso->numero_escritura = $aviso->numero_escritura;
                $this->aviso->volumen_escritura = $aviso->volumen_escritura;
                $this->aviso->lugar_otorgamiento = $aviso->lugar_otorgamiento;
                $this->aviso->fecha_otorgamiento = $aviso->fecha_otorgamiento;
                $this->aviso->lugar_firma = $aviso->lugar_firma;
                $this->aviso->fecha_firma = $aviso->fecha_firma;
                $this->aviso->tipo_vialidad = $aviso->tipo_vialidad;
                $this->aviso->tipo_asentamiento = $aviso->tipo_asentamiento;
                $this->aviso->nombre_vialidad = $aviso->nombre_vialidad;
                $this->aviso->numero_exterior = $aviso->numero_exterior;
                $this->aviso->numero_exterior_2 = $aviso->numero_exterior_2;
                $this->aviso->numero_adicional = $aviso->numero_adicional;
                $this->aviso->numero_adicional_2 = $aviso->numero_adicional_2;
                $this->aviso->numero_interior = $aviso->numero_interior;
                $this->aviso->nombre_asentamiento = $aviso->nombre_asentamiento;
                $this->aviso->codigo_postal = $aviso->codigo_postal;
                $this->aviso->lote_fraccionador = $aviso->lote_fraccionador;
                $this->aviso->manzana_fraccionador = $aviso->manzana_fraccionador;
                $this->aviso->etapa_fraccionador = $aviso->etapa_fraccionador;
                $this->aviso->nombre_predio = $aviso->nombre_predio;
                $this->aviso->nombre_edificio = $aviso->nombre_edificio;
                $this->aviso->clave_edificio = $aviso->clave_edificio;
                $this->aviso->departamento_edificio = $aviso->departamento_edificio;
                $this->aviso->superficie_terreno = $aviso->superficie_terreno;
                $this->aviso->superficie_construccion = $aviso->superficie_construccion;
                $this->aviso->cantidad_tramitada = $aviso->cantidad_tramitada;
                $this->aviso->descripcion_fideicomiso = $aviso->descripcion_fideicomiso;
                $this->aviso->observaciones = $aviso->observaciones;
                $this->aviso->valor_adquisicion = $aviso->valor_adquisicion;
                $this->aviso->valor_catastral = $aviso->valor_catastral;
                $this->aviso->uso_de_predio = $aviso->uso_de_predio;
                $this->aviso->fecha_reduccion = $aviso->fecha_reduccion;
                $this->aviso->valor_construccion_vivienda = $aviso->valor_construccion_vivienda;
                $this->aviso->valor_construccion_otro = $aviso->valor_construccion_otro;
                $this->aviso->porcentaje_adquisicion = $aviso->porcentaje_adquisicion;
                $this->aviso->reduccion = $aviso->reduccion;
                $this->aviso->base_gravable = $aviso->base_gravable;
                $this->aviso->sin_reduccion = $aviso->sin_reduccion;
                $this->aviso->no_genera_isai = $aviso->no_genera_isai;
                $this->aviso->valor_base = $aviso->valor_base;
                $this->aviso->valor_isai = $aviso->valor_isai;
                $this->aviso->anexos = $aviso->anexos;
                $this->aviso->xutm = $aviso->xutm;
                $this->aviso->yutm = $aviso->yutm;
                $this->aviso->zutm = $aviso->zutm;
                $this->aviso->lon = $aviso->lon;
                $this->aviso->lat = $aviso->lat;
                $this->aviso->entidad_id = $aviso->entidad_id;
                $this->aviso->aviso_original = $aviso->id;
                $this->aviso->certificado_sgc = $aviso->certificado_sgc;
                $this->aviso->avaluo_spe = $aviso->avaluo_spe;
                $this->aviso->creado_por = auth()->id();
                $this->aviso->save();

                foreach($aviso->colindancias as $colindancia){

                    $this->aviso->colindancias()->create([
                        'viento' => $colindancia->viento,
                        'longitud' => $colindancia->longitud,
                        'descripcion' => $colindancia->descripcion,
                        'creado_por' => auth()->id()
                    ]);

                }

                foreach($aviso->transmitentes() as $transmitente){

                    $this->aviso->actores()->create([
                        'tipo' => 'transmitente',
                        'persona_id' => $transmitente->persona->id,
                        'porcentaje' => $transmitente['porcentaje'],
                        'porcentaje_nuda' => $transmitente['porcentaje_nuda'],
                        'porcentaje_usufructo' => $transmitente['porcentaje_usufructo'],
                        'creado_por' => auth()->id()
                    ]);

                }

                foreach($aviso->adquirientes() as $adquiriente){

                    $this->aviso->actores()->create([
                        'persona_id' => $adquiriente->persona->id,
                        'tipo' => 'adquiriente',
                        'porcentaje' => $adquiriente->porcentaje,
                        'porcentaje_nuda' => $adquiriente->porcentaje_nuda,
                        'porcentaje_usufructo' => $adquiriente->porcentaje_usufructo,
                        'creado_por' => auth()->id()
                    ]);

                }

                foreach($aviso->fideicomitentes() as $fideicomitente){

                    $this->aviso->actores()->create([
                        'persona_id' => $fideicomitente->persona->id,
                        'tipo' => 'fideicomitente',
                        'creado_por' => auth()->id()
                    ]);

                }

                foreach($aviso->fideicomisarios() as $fideicomisario){

                    $this->aviso->actores()->create([
                        'persona_id' => $fideicomisario->persona->id,
                        'tipo' => 'fideicomisario',
                        'creado_por' => auth()->id()
                    ]);

                }

                foreach($aviso->fiduciaria() as $fiduciaria){

                    $this->aviso->actores()->create([
                        'persona_id' => $fiduciaria->persona->id,
                        'tipo' => 'fiduciaria',
                        'creado_por' => auth()->id()
                    ]);

                }

            });

            $this->reset(['revision', 'año_aviso', 'folio_aviso', 'usuario_aviso']);

            redirect()->route('aviso', $this->aviso);

        } catch (\Throwable $th) {

            Log::error("Error al cargar aviso en avisos: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function buscarCuentaPredial(){

        $this->validate([
            'numero_registro' => 'required',
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo_predio' => 'required|numeric|min:1|max:2',
        ]);

        $response = Http::withToken(env('SGC_ACCESS_TOKEN'))->accept('application/json')->asForm()->post(env('SGC_CONSULTA_CUENTA_PREDIAL'),[
            'localidad' => $this->localidad,
            'oficina' => $this->oficina,
            'tipo_predio' => $this->tipo_predio,
            'numero_registro' => $this->numero_registro
        ]);

        if($response->status() == 200){

            $data = json_decode($response, true);

            $this->aviso->predio_sgc = $data['data']['id'];
            $this->region_catastral = $data['data']['region_catastral'];
            $this->municipio = $data['data']['municipio'];
            $this->zona_catastral = $data['data']['zona_catastral'];
            $this->localidad = $data['data']['localidad'];
            $this->sector = $data['data']['sector'];
            $this->manzana = $data['data']['manzana'];
            $this->predio = $data['data']['predio'];
            $this->edificio = $data['data']['edificio'];
            $this->departamento = $data['data']['departamento'];


            $this->aviso->region_catastral = $data['data']['region_catastral'];
            $this->aviso->municipio = $data['data']['municipio'];
            $this->aviso->zona_catastral = $data['data']['zona_catastral'];
            $this->aviso->localidad = $data['data']['localidad'];
            $this->aviso->sector = $data['data']['sector'];
            $this->aviso->manzana = $data['data']['manzana'];
            $this->aviso->predio = $data['data']['predio'];
            $this->aviso->edificio = $data['data']['edificio'];
            $this->aviso->departamento = $data['data']['departamento'];
            $this->aviso->oficina = $data['data']['oficina'];
            $this->aviso->tipo_predio = $data['data']['tipo_predio'];
            $this->aviso->numero_registro = $data['data']['numero_registro'];

        }elseif($response->status() == 401){

            $data = json_decode($response, true);

            $this->dispatch('mostrarMensaje', ['error', $data['error']]);

        }else{

            $this->dispatch('mostrarMensaje', ['error', "No se encontro registro en el padrón catastral con la cuenta predial ingresada."]);

        }

    }

    public function crear(){

        $this->validate();

        try {

            $this->aviso->estado = 'nuevo';
            $this->aviso->año = now()->format('Y');
            $this->aviso->usuario = auth()->user()->clave;
            $this->aviso->folio = (Aviso::where('año', $this->aviso->año)->where('usuario', $this->aviso->usuario)->max('folio') ?? 0) + 1;
            $this->aviso->entidad_id = auth()->user()->entidad_id;
            $this->aviso->creado_por = auth()->id();
            $this->aviso->save();

            $this->dispatch('cargarAviso', id:$this->aviso->id);

            $this->dispatch('mostrarMensaje', ['success', "El aviso se guardó correctamente."]);

            $this->actualizacion = true;


        } catch (\Throwable $th) {

            Log::error("Error al crear aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function actualizar(){

        $this->authorize('update', $this->aviso);

        $this->validate();

        try {

            $this->aviso->actualizado_por = auth()->id();
            $this->aviso->save();

            $this->dispatch('mostrarMensaje', ['success', "El aviso se actualizó correctamente."]);

            $this->actualizacion = true;


        } catch (\Throwable $th) {

            Log::error("Error al crear aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function mount(){

        try {

            $response = Http::withToken(env('SGC_ACCESS_TOKEN'))->accept('application/json')->get(env('SGC_OFICINAS'));

            if($response->status() !== 200){

                abort(500, message:"Ha ocurrido un error en el sistema comuniquese con el departamento de operaciones y desarrollo de sistemas.");

            }

            $this->oficinas = collect(json_decode($response, true)['data']);

        } catch (ConnectionException $th) {

            Log::error("Error al cargar oficinas en avisos: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

            abort(500, message:"Ha ocurrido un error en el sistema comuniquese con el departamento de operaciones y desarrollo de sistemas.");

        }

        if($this->avisoId){

            $this->aviso = Aviso::find($this->avisoId);

            try {

                $response = Http::withToken(env('SGC_ACCESS_TOKEN'))->accept('application/json')->asForm()->post(env('SGC_CONSULTA_PREDIO'), ['id' => $this->aviso->predio_sgc]);

                $data = collect(json_decode($response, true));

                $this->region_catastral = $data['data']['region_catastral'];
                $this->municipio = $data['data']['municipio'];
                $this->zona_catastral = $data['data']['zona_catastral'];
                $this->localidad = $data['data']['localidad'];
                $this->sector = $data['data']['sector'];
                $this->manzana = $data['data']['manzana'];
                $this->predio = $data['data']['predio'];
                $this->edificio = $data['data']['edificio'];
                $this->departamento = $data['data']['departamento'];
                $this->oficina = $data['data']['oficina'];
                $this->tipo_predio = $data['data']['tipo_predio'];
                $this->numero_registro = $data['data']['numero_registro'];

            } catch (ConnectionException $th) {

                Log::error("Error al cargar predio en avisos: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

                $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

                abort(500, message:"Ha ocurrido un error en el sistema comuniquese con el departamento de operaciones y desarrollo de sistemas.");

            }

            $this->actualizacion = true;

        }else{

            $this->crearModeloVacio();

        }

        $this->municipios = $this->oficinas->whereNull('cabecera')->sortBy('nombre');

        $this->actos = Constantes::ACTOS;

        $this->años = Constantes::AÑOS;

        $this->año_aviso = now()->format('Y');

    }

    public function render()
    {

        if($this->aviso->getKey()) $this->authorize('view', $this->aviso);

        return view('livewire.usuarios.aviso.acto-escritura');
    }
}
