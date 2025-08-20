<?php

namespace App\Livewire\Catastro\Tramites;

use App\Exceptions\GeneralException;
use App\Http\Controllers\TramiteReciboController;
use Livewire\Component;
use App\Services\SGCService;
use App\Traits\SapTrait;
use Illuminate\Support\Facades\Log;

class NuevoTramite extends Component
{

    use SapTrait;

    public $servicios;
    public $servicio_id;
    public $servicioSeleccionado;
    public $tipo_servicio = "ordinario";
    public $solicitante;
    public $nombre_solicitante;

    public $localidad;
    public $oficina;
    public $tipo;
    public $registro;

    public $total;

    public $predios = [];
    public $predio;

    public $tramite;

    public $token;
    public $link_pago_linea;

    protected function rules(){
        return [
            'servicio_id' => 'required',
            'solicitante' => 'required',
            'nombre_solicitante' => 'required',
            'tipo_servicio' => 'required',
            'predios' => 'required',
         ];
    }

    public function updatedServicioId(){

        if($this->servicio_id == ''){

            $this->resetearTodo();

            return;

        }

        $this->servicioSeleccionado = collect($this->servicios)->where('id', $this->servicio_id)->first();

        $this->resetearTodo();

    }

    public function updatedTipoServicio(){

        if($this->tipo_servicio != 'ordinario' && $this->servicioSeleccionado['urgente'] === '0.00'){

            $this->reset('tipo_servicio');

            $this->dispatch('mostrarMensaje', ['warning', 'El trámite solo tiene servicio ordinario']);

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
        ]);

    }

    public function agregarPredio(){

        $this->validate([
            'registro' => 'required',
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo' => 'required|numeric|min:1|max:2',
        ]);

        try {

            $predio = (new SGCService())->consultarCuentaPredial($this->localidad, $this->oficina, $this->tipo, $this->registro);

            if(collect($this->predios)->where('id', $predio['id'])->first()){

                throw new GeneralException('El predio ya se encuentra en la lista');

            }

            array_push($this->predios,
                [
                    'id' => $predio['id'],
                    'localidad' => $predio['localidad'],
                    'oficina' => $predio['oficina'],
                    'tipo_predio' => $predio['tipo_predio'],
                    'numero_registro' => $predio['numero_registro'],
                ]
            );

            $this->total = $this->total + (float)$this->servicioSeleccionado[$this->tipo_servicio];

            $this->reset(['localidad', 'oficina', 'tipo', 'registro']);

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al agregar predio en nuevo trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function quitarPredio($a){

        unset($this->predios[$a]);

        $this->total = $this->total - (float)$this->servicioSeleccionado[$this->tipo_servicio];

    }

    public function crearTramite(){

        $this->validate();

        try {

            $this->tramite = (new SGCService())->crearTramite(
                                                                $this->tipo_servicio,
                                                                $this->servicio_id,
                                                                $this->solicitante,
                                                                $this->nombre_solicitante,
                                                                $this->total,
                                                                count($this->predios),
                                                                auth()->user()->entidad_id,
                                                                $this->predios
                                                            );

            $this->dispatch('mostrarMensaje', ['success', 'Trámite ' . $this->tramite['año'] . '-' . $this->tramite['folio'] . '-' . $this->tramite['usuario'] . ' se registró con éxito']);

            $this->token = $this->encrypt_decrypt("encrypt", $this->tramite['linea_de_captura'] . $this->tramite['monto'] . "IRYCEM" . $this->tramite['fecha_vencimiento']);

        }catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al agregar predio en nuevo trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function pagarVentanilla(){

        try {

            $pdf = (new TramiteReciboController())->imprimir($this->tramite);

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'orden_' . $this->tramite['año'] . '-' . $this->tramite['folio'] . '-' . $this->tramite['usuario'] . '.pdf'
            );

        } catch (\Throwable $th) {

            Log::error("Error al generar orden de pago por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        try {

            $servicios = (new SGCService())->consultarServicios(['DM34', 'D728', 'D729', 'D730', 'DM35', 'DM32']);

            $this->servicios = collect($servicios['data']);

        } catch (GeneralException $ex) {

            abort(403, message:"Error al consultar servicios");

        } catch (\Throwable $th) {

            Log::error("Error al consultar consultar servicios es SGC. " . $th);

            abort(403, message:"Error al consultar servicios");

        }

        if(auth()->user()->hasRole(['Notario', 'Gestor'])){

            $this->solicitante = 'Notaría';

            $this->nombre_solicitante =  auth()->user()->entidad->numero_notaria . ' - ' . auth()->user()->entidad->notarioTitular->name;

        }elseif(auth()->user()->hasRole('Dependencia')){

            $this->solicitante = 'Usuario';

            $this->nombre_solicitante =  auth()->user()->entidad->dependencia;

        }elseif(auth()->user()->hasRole('AMPI')){

            $this->solicitante = 'Usuario';

            $this->nombre_solicitante =  auth()->user()->entidad->dependencia;

        }elseif(auth()->user()->hasRole('Abogado')){

            $this->solicitante = 'Usuario';

            $this->nombre_solicitante =  auth()->user()->name;

        }

        $this->link_pago_linea = config('services.sap.link_pago_linea');

    }

    public function render()
    {
        return view('livewire.catastro.tramites.nuevo-tramite')->extends('layouts.admin');
    }
}
