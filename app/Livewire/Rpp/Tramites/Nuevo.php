<?php

namespace App\Livewire\Rpp\Tramites;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Http\Client\ConnectionException;

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

    public $total;

    public $tramite;

    public $token;
    public $url_pago_linea;

    protected function rules(){
        return [
            'servicio' => 'required',
            'solicitante' => 'required',
            'nombre_solicitante' => 'required',
         ];
    }

    public function updatedServicio(){

        if($this->servicio == ''){

            $this->resetearTodo();

            return;

        }

        $this->servicioSeleccionado = collect($this->servicios)->where('id', $this->servicio)->first();

        $this->resetearTodo();

        $this->total = $this->servicioSeleccionado['ordinario'];

    }

    public function updatedTipoServicio(){

        if($this->tipo_servicio != 'ordinario' && $this->servicioSeleccionado['urgente'] === '0.00'){

            $this->reset('tipo_servicio');

            $this->dispatch('mostrarMensaje', ['error', 'El trámite solo tiene servicio ordinario']);

            return;

        }

    }

    public function resetearTodo(){

        $this->reset([
            'tipo_servicio',
            'total',
            'tramite',
        ]);

    }

    public function crearTramite(){

        $this->validate();

        if(auth()->user()->hasRole('Dependencia')) $this->total = 0;

        try {

            $response = Http::withToken(env('SISTEMA_TRAMITES_TOKEN'))
                                ->accept('application/json')
                                ->post(env('SISTEMA_TRAMITES_CREAR_TRAMITE'), [
                                                                'tipo_tramite' => $this->tipo_tramite,
                                                                'tipo_servicio' => $this->tipo_servicio,
                                                                'servicio_id' => $this->servicio,
                                                                'solicitante' => $this->solicitante,
                                                                'nombre_solicitante' => $this->nombre_solicitante,
                                                                'monto' => $this->total,
                                                                'cantidad' => 1,
                                                                'usuario_tramites_linea_id' => auth()->user()->entidad->id,
                                                            ]);

            $data = json_decode($response, true);

            if($response->status() === 200){

                $this->tramite = $data['data'];

                $this->dispatch('mostrarMensaje', ['success', 'Trámite ' . $this->tramite['año'] . '-' . $this->tramite['folio'] . '-' . $this->tramite['usuario'] . ' se registró con éxito']);

                $this->token = $this->encrypt_decrypt("encrypt", $this->tramite['linea_de_captura'] . $this->tramite['monto'] . "IRYCEM" . $this->tramite['fecha_vencimiento']);

                if($this->tipo_tramite === 'exento'){

                    $this->resetearTodo();

                    return;

                }

            }else{

                Log::error($data);

                $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

            }

        } catch (ConnectionException $th) {

            Log::error("Error al cargar servicio nuevo en trámties: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

            abort(500, message:"Ha ocurrido un error en el sistema comuniquese con el departamento de operaciones y desarrollo de sistemas.");

        }catch (\Throwable $th) {

            Log::error("Error al cargar servicio nuevo en trámties: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'regcatastral.2023@gob';
        $secret_iv = 'regcatastral.2023@gob';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    public function getToken(){

        $output = false;

        $string = $this->tramite['linea_de_captura'] . $this->tramite['monto'] . "IRYCEM" . $this->tramite['fecha_vencimiento'];

        $encrypt_method = "AES-256-CBC";

        $secret_key = 'regcatastral.2023@gob';

        $secret_iv = 'regcatastral.2023@gob';

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

            $response =  Http::post('http://10.0.250.55:8081/pagolinea', [
                'concepto' => "IRYCEM",
                'lcaptura' => $this->tramite['linea_de_captura'],
                'monto' => $this->tramite['monto'],
                'urlRetorno' => route('tramites'),
                'fecha_vencimiento' => $this->tramite['fecha_vencimiento'],
                'tkn' => $this->getToken()
            ]);

            dd(json_decode($response, true));

        } catch (\Throwable $th) {

            Log::error("Error al pagar trámtie en linínea: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

        }

    }

    public function mount(){

        try {

            $response = Http::withToken(env('SISTEMA_TRAMITES_TOKEN'))
                                ->accept('application/json')
                                ->get(env('SISTEMA_TRAMITES_CONSULTA_SERVICIOS'), [
                                                                                    'claves' =>[
                                                                                        'DC94',
                                                                                        'DC95',
                                                                                        'DC97',
                                                                                        'DC96',
                                                                                        'DL21',
                                                                                        'DL22',
                                                                                        'DL23',
                                                                                        'DL24',
                                                                                        'DL25',
                                                                                        'DL26',
                                                                                        'DL27',
                                                                                        'DL16',
                                                                                        'DL17'
                                                                                    ]
                                                                                ]);

            if($response->status() === 200){

                $this->servicios = collect(json_decode($response, true)['data']);

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

            }else{

                $this->servicios = [];

            }

        } catch (ConnectionException $th) {

            Log::error("Error al cargar servicio nuevo en trámties: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            abort(500, message:"Ha ocurrido un error en el sistema comuniquese con el departamento de operaciones y desarrollo de sistemas.");

        }

        if(env('loacl') == "1"){

            $this->url_pago_linea  = "https://pagoenlinea.michoacan.gob.mx/pagolinea";

        }else{

            $this->url_pago_linea  = "http://10.0.250.55:8081/pagolinea";

        }

    }

    public function render()
    {
        return view('livewire.rpp.tramites.nuevo')->extends('layouts.admin');
    }
}
