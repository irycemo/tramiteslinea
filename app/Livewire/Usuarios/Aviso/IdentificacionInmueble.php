<?php

namespace App\Livewire\Usuarios\Aviso;

use App\Models\Aviso;
use Livewire\Component;
use App\Models\Colindancia;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Services\Coordenadas\Coordenadas;
use Illuminate\Http\Client\ConnectionException;

class IdentificacionInmueble extends Component
{

    public $codigos_postales;
    public $tipoVialidades;
    public $tipoAsentamientos;
    public $nombres_asentamientos = [];

    public $vientos;
    public $medidas = [];

    public Aviso $aviso;
    public $avisoId;

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
            'medidas.*.descripcion' => 'required|string|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso' => 'required',
            'aviso.tipo_asentamiento' => 'required',
            'aviso.nombre_asentamiento' => 'required',
            'aviso.tipo_vialidad' => 'required',
            'aviso.nombre_vialidad' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso.numero_exterior' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso.numero_exterior_2' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso.numero_interior' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso.numero_adicional_2' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso.numero_adicional' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso.codigo_postal' => 'required|numeric',
            'aviso.lote_fraccionador' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso.manzana_fraccionador' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso.etapa_fraccionador' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso.nombre_predio'  => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso.nombre_edificio' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso.clave_edificio' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso.departamento_edificio' => 'nullable|regex:/^[a-zA-Z0-9\s]+$/',
            'aviso.xutm' => 'nullable|string',
            'aviso.yutm' => 'nullable|string',
            'aviso.zutm' => 'nullable',
            'aviso.lat' => 'required',
            'aviso.lon' => 'required',
            'aviso.superficie_terreno' => 'required|numeric',
            'aviso.superficie_construccion' => 'nullable|numeric',
            'aviso.valor_catastral' => 'required|numeric',
            'aviso.cantidad_tramitada' => 'required',
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
        $this->aviso = Aviso::make();
    }

    public function updatedAvisoCodigoPostal(){

        try {

            $response = Http::withToken(env('SGC_ACCESS_TOKEN'))->accept('application/json')->get(env('SGC_CODIGOS_POSTALES'), ['codigo' => $this->aviso->codigo_postal]);

            if($response->status() === 200){

                $this->codigos_postales = collect(json_decode($response, true)['data']);

            }else{

                $this->dispatch('mostrarMensaje', ['error', json_decode($response, true)['error']]);

                return;

            }

            foreach ($this->codigos_postales as $codigo) {

                array_push($this->nombres_asentamientos, $codigo['nombre_asentamiento']);

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

    }

    public function render()
    {
        return view('livewire.usuarios.aviso.identificacion-inmueble');
    }
}
