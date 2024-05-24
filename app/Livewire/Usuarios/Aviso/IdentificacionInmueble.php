<?php

namespace App\Livewire\Usuarios\Aviso;

use App\Models\File;
use App\Models\Aviso;
use Livewire\Component;
use App\Models\Colindancia;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Services\Coordenadas\Coordenadas;
use Illuminate\Http\Client\ConnectionException;

class IdentificacionInmueble extends Component
{

    use WithFileUploads;

    public $codigos_postales;
    public $tipoVialidades;
    public $tipoAsentamientos;
    public $nombres_asentamientos = [];
    public $años;
    public $año;

    public $vientos;
    public $medidas = [];
    public $croquis;

    public Aviso $aviso;
    public $avisoId;

    public $folio;

    protected $listeners = ['cargarAviso'];

    protected function rules(){
        return [
            'medidas.*' => 'required',
            'medidas.*.viento' => 'required|string',
            'medidas.*.longitud' => [
                                        'required',
                                        'numeric',
                                        'min:0',
                                    ],
            'medidas.*.descripcion' => 'required|'. utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso' => 'required',
            'aviso.tipo_asentamiento' => 'required',
            'aviso.nombre_asentamiento' => 'required',
            'aviso.tipo_vialidad' => 'required',
            'aviso.nombre_vialidad' => 'required|'. utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.numero_exterior' => 'required|'. utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.numero_exterior_2' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.numero_interior' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.numero_adicional_2' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.numero_adicional' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.codigo_postal' => 'required|numeric',
            'aviso.lote_fraccionador' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.manzana_fraccionador' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.etapa_fraccionador' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.nombre_predio'  => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.nombre_edificio' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.clave_edificio' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.departamento_edificio' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'aviso.xutm' => 'nullable|string',
            'aviso.yutm' => 'nullable|string',
            'aviso.zutm' => 'nullable',
            'aviso.lat' => 'required',
            'aviso.lon' => 'required',
            'aviso.superficie_terreno' => 'required|numeric',
            'aviso.superficie_construccion' => 'nullable|numeric',
            'aviso.valor_catastral' => 'required|numeric',
            'aviso.cantidad_tramitada' => 'required',
            'aviso.avaluo_spe' => 'nullable',
            'croquis' => 'nullable|image',
         ];
    }

    protected $validationAttributes  = [
        'medidas.*.viento' => 'viento',
        'medidas.*.longitud' => 'longitud',
        'medidas.*.descripcion' => 'descripción',
    ];

    protected $messages = [
        'aviso.required' => '. Primero debe cargar el aviso'
    ];

    public function crearModeloVacio(){
        $this->aviso = Aviso::make(['estado' => 'nuevo']);
    }

    public function updatedAvisoCodigoPostal(){

        try {

            $response = Http::withToken(env('SGC_ACCESS_TOKEN'))->accept('application/json')->get(env('SGC_CODIGOS_POSTALES'), ['codigo' => $this->aviso->codigo_postal]);

            if($response->status() === 200){

                $this->codigos_postales = collect(json_decode($response, true)['data']);

                if($this->codigos_postales->count()){

                    foreach ($this->codigos_postales as $codigo) {

                        array_push($this->nombres_asentamientos, $codigo['nombre_asentamiento']);
                    }

                }

                if($this->aviso->nombre_asentamiento){

                    array_push($this->nombres_asentamientos, $this->aviso->nombre_asentamiento);

                }

                $this->nombres_asentamientos = array_filter($this->nombres_asentamientos);

            }else{

                $this->dispatch('mostrarMensaje', ['error', json_decode($response, true)['error']]);

                return;

            }

        } catch (ConnectionException $th) {

            Log::error("Error al cargar oficinas en avisos: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function updatedAvisoNombreAsentamiento(){

        if($this->aviso->nombre_asentamiento != "")
            $this->aviso->tipo_asentamiento = $this->codigos_postales->where('nombre_asentamiento', $this->aviso->nombre_asentamiento)->first()['tipo_asentamiento'];
        else
            $this->aviso->tipo_asentamiento = null;

    }

    public function updated($value){

        if(in_array($value, ['aviso.xutm', 'aviso.yutm','aviso.zutm', 'aviso.lat', 'aviso.lon']))
            $this->convertirCoordenadas();

    }

    public function cargarAviso($id){

        $this->reset('medidas');

        $this->aviso = Aviso::find($id);

        foreach ($this->aviso->colindancias as $colindancia) {

            $this->medidas[] = [
                'id' => $colindancia->id,
                'viento' => $colindancia->viento,
                'longitud' => $colindancia->longitud,
                'descripcion' => $colindancia->descripcion,
            ];

        }

        if(count($this->medidas) == 0)
            $this->agregarMedida();

    }

    public function cargarAvaluo(){

        $this->validate(['año' => 'required', 'folio' => 'required']);

        try {

            $response = Http::acceptJson()
                        ->withToken(env('SISTEMA_PERITOS_EXTERNOS_TOKEN'))
                        ->withQueryParameters([
                            'año' => $this->año,
                            'folio' => $this->folio
                        ])
                        ->get(env('SISTEMA_PERITOS_EXTERNOS_CONSULTAR_AVALUO'));


            $data = json_decode($response, true);

            if($response->status() === 200){

                if($this->aviso->predio_sgc !== $data['data']['predio_sgc']){

                    $this->dispatch('mostrarMensaje', ['error', 'El predio del aviso y el predio del avalúo no son el mismo.']);

                    return;

                }

                $this->aviso->colindancias()->delete();

                $this->reset('medidas');

                $this->aviso->avaluo_spe = $data['data']['id'];
                $this->aviso->tipo_asentamiento = $data['data']['tipo_asentamiento'];
                $this->aviso->nombre_asentamiento = $data['data']['nombre_asentamiento'];
                $this->aviso->tipo_vialidad = $data['data']['tipo_vialidad'];
                $this->aviso->nombre_vialidad = $data['data']['nombre_vialidad'];
                $this->aviso->numero_exterior = $data['data']['numero_exterior'];
                $this->aviso->numero_exterior_2 = $data['data']['numero_exterior_2'];
                $this->aviso->numero_interior = $data['data']['numero_interior'];
                $this->aviso->numero_adicional_2 = $data['data']['numero_adicional_2'];
                $this->aviso->numero_adicional = $data['data']['numero_adicional'];
                $this->aviso->codigo_postal = $data['data']['codigo_postal'];
                $this->aviso->lote_fraccionador = $data['data']['lote_fraccionador'];
                $this->aviso->manzana_fraccionador = $data['data']['manzana_fraccionador'];
                $this->aviso->etapa_fraccionador = $data['data']['etapa_fraccionador'];
                $this->aviso->nombre_predio = $data['data']['nombre_predio'];
                $this->aviso->nombre_edificio = $data['data']['nombre_edificio'];
                $this->aviso->clave_edificio = $data['data']['clave_edificio'];
                $this->aviso->departamento_edificio = $data['data']['departamento_edificio'];
                $this->aviso->xutm = $data['data']['xutm'];
                $this->aviso->yutm = $data['data']['yutm'];
                $this->aviso->zutm = $data['data']['zutm'];
                $this->aviso->lat = $data['data']['lat'];
                $this->aviso->lon = $data['data']['lon'];
                $this->aviso->superficie_terreno = $data['data']['superficie_terreno'];
                $this->aviso->superficie_construccion = $data['data']['superficie_construccion'];
                $this->aviso->valor_catastral = $data['data']['valor_catastral'];

                $this->updatedAvisoCodigoPostal();

                foreach ($data['data']['colindancias'] as $colindancia) {

                    $this->medidas[] =[
                        'id' => null,
                        'viento' => $colindancia['viento'],
                        'longitud' => $colindancia['longitud'],
                        'descripcion' => $colindancia['descripcion'],
                    ];

                }

                $file = File::where('fileable_id', $this->aviso->id)->where('fileable_type', 'App\Models\Aviso')->where('descripcion', 'croquis')->first();

                if($file){

                    Storage::disk('avisos')->delete($file->url);

                    $file->delete();

                }

                $contents = file_get_contents($data['data']['croquis']);

                $extension = pathinfo(parse_url($data['data']['croquis'], PHP_URL_PATH), PATHINFO_EXTENSION);

                $name = Str::random(40) . '.' . $extension;

                Storage::disk('avisos')->put($name, $contents);

                File::create([
                    'fileable_id' => $this->aviso->id,
                    'fileable_type' => 'App\Models\Aviso',
                    'descripcion' => 'croquis',
                    'url' => $name
                ]);

            }else if($response->status() === 404 || $response->status() === 401){

                $this->dispatch('mostrarMensaje', ['error', $data['error']]);

            }else{

                Log::error("Error al cargar transmitentes por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . json_encode($data));

                $this->dispatch('mostrarMensaje', ['error', 'Hubo un error']);

            }

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error']);
            Log::error("Error al consultar avaluo en Sistema de Peritos Externos por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

        }

    }

    public function convertirCoordenadas(){

        if($this->aviso->xutm && $this->aviso->yutm && $this->aviso->zutm){

            $ll = (new Coordenadas())->utm2ll($this->aviso->xutm, $this->aviso->yutm, $this->aviso->zutm, true);

            if(!$ll['success']){

                $this->dispatch('mostrarMensaje', ['error', $ll['msg']]);

                return;

            }else{

                $this->aviso->lat = $ll['attr']['lat'];
                $this->aviso->lon = $ll['attr']['lon'];

            }


        }elseif($this->aviso->lat && $this->aviso->lon){

            $ll = (new Coordenadas())->ll2utm($this->aviso->lat, $this->aviso->lon);

            if(!$ll['success']){

                $this->dispatch('mostrarMensaje', ['error', $ll['msg']]);

                return;

            }else{

                if((float)$ll['attr']['zone'] < 13 || (float)$ll['attr']['zone'] > 14){

                    $this->dispatch('mostrarMensaje', ['error', "Las coordenadas no corresponden a una zona válida."]);

                    $this->aviso->lat = null;
                    $this->aviso->lon = null;

                    return;

                }

                $this->aviso->xutm = strval($ll['attr']['x']);
                $this->aviso->yutm = strval($ll['attr']['y']);
                $this->aviso->zutm = $ll['attr']['zone'];

            }

        }


    }

    public function updatedMedidas($value, $index){

        $i = explode('.', $index);

        if(isset($this->medidas[$i[0]]['viento']) && $this->medidas[$i[0]]['viento'] == 'ANEXO'){

            $this->medidas[$i[0]]['longitud'] = 0;

        }

    }

    public function agregarMedida(){

        $this->medidas[] = ['viento' => null, 'longitud' => null, 'descripcion' => null, 'id' => null];

    }

    public function borrarMedida($index){

        $this->validate(['aviso' => 'required']);

        $this->authorize('update',$this->aviso);

        try {

            $this->aviso->colindancias()->where('id', $this->medidas[$index]['id'])->delete();

        } catch (\Throwable $th) {
            Log::error("Error al borrar colindancia por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

        unset($this->medidas[$index]);

        $this->medidas = array_values($this->medidas);

    }

    public function guardar(){

        $this->validate();

        try {

            DB::transaction(function () {

                if($this->croquis){

                    if($this->aviso->croquis()->first()){

                        $file = File::where('fileable_id', $this->aviso->id)->where('fileable_type', 'App\Models\Aviso')->where('descripcion', 'croquis')->first();

                        Storage::disk('avisos')->delete($file->url);

                        $file->delete();

                    }

                    $pdf = $this->croquis->store('/', 'avisos');

                    File::create([
                        'fileable_id' => $this->aviso->id,
                        'fileable_type' => 'App\Models\Aviso',
                        'descripcion' => 'croquis',
                        'url' => $pdf
                    ]);

                }

                $this->aviso->actualizado_por = auth()->id();
                $this->aviso->save();

                foreach ($this->medidas as $key =>$medida) {

                    if($medida['id'] == null){

                        $aux = $this->aviso->colindancias()->create([
                            'viento' => $medida['viento'],
                            'longitud' => $medida['longitud'],
                            'descripcion' => $medida['descripcion'],
                        ]);

                        $this->medidas[$key]['id'] = $aux->id;

                    }else{

                        Colindancia::find($medida['id'])->update([
                            'viento' => $medida['viento'],
                            'longitud' => $medida['longitud'],
                            'descripcion' => $medida['descripcion'],
                        ]);

                    }

                }

                $this->dispatch('mostrarMensaje', ['success', "La información guardó con éxito"]);

            });

        } catch (\Throwable $th) {
            Log::error("Error al crear medidas por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function mount(){

        $this->vientos = Constantes::VIENTOS;

        $this->medidas = [
            ['viento' => null, 'longitud' => null, 'descripcion' => null, 'id' => null]
        ];

        if($this->avisoId){

            $this->cargarAviso($this->avisoId);

            array_push($this->nombres_asentamientos, $this->aviso->nombre_asentamiento);

        }else{

            $this->crearModeloVacio();

        }

        $this->tipoVialidades = Constantes::TIPO_VIALIDADES;

        $this->tipoAsentamientos = Constantes::TIPO_ASENTAMIENTO;

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.usuarios.aviso.identificacion-inmueble');
    }
}
