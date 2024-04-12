<?php

namespace App\Livewire\Usuarios\Aviso;

use App\Models\Aviso;
use Livewire\Component;
use App\Constantes\Constantes;
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

    protected function rules(){
        return [
            'aviso.predio' => 'required',
            'aviso.acto' => 'required',
            'aviso.fecha_ejecutoria' => 'required|date',
            'aviso.tipo_escritura' => 'required',
            'aviso.numero_escritura' => 'required|numeric',
            'aviso.volumen_escritura' => 'required|numeric',
            'aviso.lugar_otorgamiento' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso.fecha_otorgamiento' => 'required|date',
            'aviso.lugar_firma' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso.fecha_firma' => 'required|date',
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

    public function crearModeloVacio(){
        $this->aviso = Aviso::make();
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

            $this->aviso->predio = $data['data']['id'];
            $this->region_catastral = $data['data']['region_catastral'];
            $this->municipio = $data['data']['municipio'];
            $this->zona_catastral = $data['data']['zona_catastral'];
            $this->localidad = $data['data']['localidad'];
            $this->sector = $data['data']['sector'];
            $this->manzana = $data['data']['manzana'];
            $this->predio = $data['data']['predio'];
            $this->edificio = $data['data']['edificio'];
            $this->departamento = $data['data']['departamento'];

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

            $this->oficinas = collect(json_decode($response, true)['data']);

        } catch (ConnectionException $th) {

            Log::error("Error al cargar oficinas en avisos: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

            abort(500, message:"Ha ocurrido un error en el sistema comuniquese con el departamento de operaciones y desarrollo de sistemas.");

        }

        if($this->avisoId){

            $this->aviso = Aviso::find($this->avisoId);

            try {

                $response = Http::withToken(env('SGC_ACCESS_TOKEN'))->accept('application/json')->asForm()->post(env('SGC_CONSULTA_PREDIO'), ['id' => $this->aviso->predio]);

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

    }

    public function render()
    {

        if($this->aviso->getKey()) $this->authorize('view', $this->aviso);

        return view('livewire.usuarios.aviso.acto-escritura');
    }
}
