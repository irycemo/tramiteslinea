<?php

namespace App\Livewire\Usuarios\Tramites;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Barryvdh\DomPDF\Facade\Pdf;
use Picqer\Barcode\BarcodeGeneratorPNG;

class Nuevo extends Component
{

    public $servicios;
    public $servicio;
    public $servicioSeleccionado;
    public $tipo_servicio = "ordinario";
    public $numero_oficio;
    public $solicitante;
    public $nombre_solicitante;
    public $tipo_tramite;

    public $localidad;
    public $oficina;
    public $tipo;
    public $registro;

    public $total;

    public $predios = [];
    public $predio;

    public $multi_predios = [3,4,6];

    public $tramite;

    public $token;

    protected function rules(){
        return [
            'servicio' => 'required',
            'numero_oficio' => Rule::requiredIf(auth()->user()->hasRole('Dependencia')),
            'solicitante' => 'required',
            'nombre_solicitante' => 'required',
            'tipo_tramite' => 'required',
            'predios' => 'required',
         ];
    }

    public function updatedServicio(){

        $this->servicioSeleccionado = collect($this->servicios)->where('id', $this->servicio)->first();

        $this->resetearTodo();

    }

    public function updatedTipoServicio(){

        if($this->tipo_servicio != 'ordinario' && $this->servicioSeleccionado['urgente'] === '0.00'){

            $this->reset('tipo_servicio');

            $this->dispatch('mostrarMensaje', ['error', 'El trámite solo tiene servicio ordinario']);

            return;

        }

        $costo = (float)$this->servicioSeleccionado[$this->tipo_servicio];

        $this->total = count($this->predios) * $costo;



    }

    public function resetearTodo(){

        $this->reset([
            'localidad',
            'oficina',
            'tipo',
            'registro',
            'tipo_servicio',
            'predios',
            'predio',
            'total',
            'tramite',
            'numero_oficio'
        ]);

    }

    public function agregarPredio(){

        if(!in_array($this->servicio, $this->multi_predios) && count($this->predios) >= 1){

            $this->dispatch('mostrarMensaje', ['error', 'El trámite solo puede tener un predio']);

            return;

        }

        $this->validate([
            'registro' => 'required',
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo' => 'required|numeric|min:1|max:2',
        ]);

        $response = Http::withToken(env('SGC_ACCESS_TOKEN'))->accept('application/json')->asForm()->post(env('SGC_CONSULTA_CUENTA_PREDIAL'),[
            'localidad' => $this->localidad,
            'oficina' => $this->oficina,
            'tipo_predio' => $this->tipo,
            'numero_registro' => $this->registro
        ]);

        if($response->status() == 200){

            $data = json_decode($response, true);

            if(collect($this->predios)->where('id', $data['data']['id'])->first()){

                $this->dispatch('mostrarMensaje', ['error', 'El predio ya se encuentra en la lista']);

                return;

            }

            array_push($this->predios,
                [
                    'id' => $data['data']['id'],
                    'localidad' => $data['data']['localidad'],
                    'oficina' => $data['data']['oficina'],
                    'tipo_predio' => $data['data']['tipo_predio'],
                    'numero_registro' => $data['data']['numero_registro'],
                ]
            );

            $this->total = $this->total + (float)$this->servicioSeleccionado[$this->tipo_servicio];

            $this->reset(['localidad', 'oficina', 'tipo', 'registro']);

        }elseif($response->status() == 401){

            $data = json_decode($response, true);

            $this->dispatch('mostrarMensaje', ['error', $data['error']]);

        }else{

            $this->dispatch('mostrarMensaje', ['error', "No se encontro registro en el padrón catastral con la cuenta predial ingresada."]);

        }

    }

    public function quitarPredio($a){

        unset($this->predios[$a]);

        $this->total = $this->total - (float)$this->servicioSeleccionado[$this->tipo_servicio];

    }

    public function crearTramite(){

        $this->validate();

        if(auth()->user()->hasRole('Dependencia')) $this->total = 0;

        try {

            $response = Http::withToken(env('SGC_ACCESS_TOKEN'))->accept('application/json')->post(env('SGC_CREAR_TRAMITE'), [
                                                                                                                'tipo_tramite' => $this->tipo_tramite,
                                                                                                                'tipo_servicio' => $this->tipo_servicio,
                                                                                                                'servicio_id' => $this->servicio,
                                                                                                                'solicitante' => $this->solicitante,
                                                                                                                'nombre_solicitante' => $this->nombre_solicitante,
                                                                                                                'monto' => $this->total,
                                                                                                                'cantidad' => count($this->predios),
                                                                                                                'numero_oficio' => $this->numero_oficio,
                                                                                                                'usuario_tramites_linea_id' => auth()->user()->entidad->id,
                                                                                                                'predios' => $this->predios
                                                                                                            ]);

            $data = json_decode($response, true);

            if($response->status() === 200){

                $this->tramite = $data['data'];

                $this->dispatch('mostrarMensaje', ['success', 'Trámite ' . $this->tramite['año'] . '-' . $this->tramite['folio'] . '-' . $this->tramite['usuario'] . ' se registró con éxito']);

                if($this->tipo_tramite === 'exento'){

                    $this->resetearTodo();

                    return;

                }

            }else{

                dd($data);

                $this->dispatch('mostrarMensaje', ['error', $data['error']]);

            }

        } catch (ConnectionException $th) {

            Log::error("Error al cargar servicio nuevo en trámties: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

            abort(500, message:"Ha ocurrido un error en el sistema comuniquese con el departamento de operaciones y desarrollo de sistemas.");

        }

    }

    public function getToken(){

        $output = false;

        $string = $this->tramite['monto'] . $this->servicioSeleccionado['nombre'] . $this->tramite['fecha_vencimiento'];

        $encrypt_method = "AES-256-CBC";

        $secret_key = 'IRYCEMC';

        $secret_iv = 'Gm8rHEM2011b';

        $key = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);

        $output = base64_encode($output);

        $this->token =  $output;

    }

    public function pagarVentanilla(){

        $generatorPNG = new BarcodeGeneratorPNG();

        $pdf = Pdf::loadView('tramites.orden', ['tramite' => $this->tramite, 'generatorPNG' => $generatorPNG])->output();

        $this->resetearTodo();

        return response()->streamDownload(
            fn () => print($pdf),
            'orden_de_pago.pdf'
        );

    }

    public function pagarEnLinea(){

        try {

            return redirect('http://10.0.250.55/plinea/PagoLinea/', [
                'concepto' => $this->servicioSeleccionado['nombre'],
                'lcaptura' => $this->tramite['linea_de_captura'],
                'monto' => $this->tramite['monto'],
                'urlRetorno' => route('tramites'),
                'fecha_vencimiento' => $this->tramite['fecha_vencimiento'],
                'tkn' => $this->getToken()
            ]);

        } catch (\Throwable $th) {

            Log::error("Error al pagar trámtie en linínea: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

        }

    }

    public function mount(){

        try {

            $response = Http::withToken(env('SGC_ACCESS_TOKEN'))->accept('application/json')->get(env('SGC_CONSULTA_SERVICIOS'), [
                                                                                                                                    'ids' =>[3,4,5,6,7,8,9,10,11,66,67,68,64,65,57,55]
                                                                                                                                ]);

            $this->servicios = collect(json_decode($response, true)['data']);

        } catch (ConnectionException $th) {

            Log::error("Error al cargar servicio nuevo en trámties: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

            abort(500, message:"Ha ocurrido un error en el sistema comuniquese con el departamento de operaciones y desarrollo de sistemas.");

        }

        if(auth()->user()->hasRole(['Notario', 'Gestor'])){

            $this->solicitante = 'Notaría';

            $this->nombre_solicitante =  auth()->user()->entidad->numero_notaria . ' - ' . auth()->user()->entidad->titular->name;

            $this->tipo_tramite = 'normal';

        }elseif(auth()->user()->hasRole('Dependencia')){

            $this->solicitante = 'Escrituración social';

            $this->nombre_solicitante =  auth()->user()->entidad->dependencia;

            $this->tipo_tramite = 'exento';

        }elseif(auth()->user()->hasRole('AMPI')){

            $this->solicitante = 'Usuario';

            $this->nombre_solicitante =  auth()->user()->entidad->dependencia;

            $this->tipo_tramite = 'normal';

        }elseif(auth()->user()->hasRole('Abogado')){

            $this->solicitante = 'Usuario';

            $this->nombre_solicitante =  auth()->user()->name;

            $this->tipo_tramite = 'normal';

        }

    }

    public function render()
    {
        return view('livewire.usuarios.tramites.nuevo')->extends('layouts.admin');
    }
}
