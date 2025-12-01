<?php

namespace App\Livewire\Catastro\Tramites;

use Livewire\Component;
use Illuminate\Support\Arr;
use App\Services\SGCService;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Http\Controllers\TramiteReciboController;
use App\Traits\SapTrait;

class MisTramites extends Component
{

    use SapTrait;

    public $estados;
    public $estado;
    public $años;
    public $folio;
    public $tipo_servicio;
    public $servicio;
    public $año;
    public $paginaActual = 1;
    public $paginaAnterior;
    public $paginaSiguiente;
    public $pagination = 10;
    public $servicios;

    public $modal = false;

    public $tramiteSeleccionado;

    public $token;
    public $link_pago_linea;

    public function updatedFolio(){

        if($this->folio == '') $this->folio = null;

    }

    public function nextPage(){ (int)$this->paginaActual++; $this->dispatch('gotoTop'); }

    public function previousPage(){ (int)$this->paginaActual--; $this->dispatch('gotoTop'); }

    public function abrirModalVer($tramite){

        $this->modal = true;

        $this->tramiteSeleccionado =  $tramite;

        if($this->tramiteSeleccionado['estado'] === 'nuevo'){

            $this->token = $this->encrypt_decrypt("encrypt", $this->tramiteSeleccionado['linea_de_captura'] . $this->tramiteSeleccionado['monto'] . config('services.sap.concepto') . $this->tramiteSeleccionado['fecha_vencimiento']);

        }

    }

    public function genererOrdenPago($tramite){

        try {

            $pdf = (new TramiteReciboController())->imprimir($tramite);

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'orden_' . $tramite['año'] . '-' . $tramite['folio'] . '-' . $tramite['usuario'] . '.pdf'
            );

        } catch (\Throwable $th) {

            Log::error("Error al generar orden de pago por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

        $this->estado = request()->query('estado');

        $this->link_pago_linea = config('services.sap.link_pago_linea');

        try {

            $servicios = (new SGCService())->consultarServicios(['DM34', 'D728', 'D729', 'D730']);

            $this->servicios = collect($servicios['data']);

        } catch (GeneralException $ex) {

            abort(403, message:$ex->getMessage());

            Log::error("Error al consultar consultar servicios es SGC. " . $th);

        } catch (\Throwable $th) {

            abort(403, message:"Error al consultar servicios");

            Log::error("Error al consultar consultar servicios es SGC. " . $th);

        }

    }

    public function render()
    {

        $tramites = [];

        try {

            $data = (new SGCService())->consultarTramites(
                                                                 auth()->user()->entidad_id,
                                                                 $this->estado,
                                                                 $this->año,
                                                                 $this->folio,
                                                                 $this->tipo_servicio,
                                                                 $this->servicio,
                                                                 $this->paginaActual,
                                                                 $this->pagination
                                                                );

            $this->paginaActual = Arr::get($data, 'meta.current_page');
            $this->paginaAnterior = Arr::get($data, 'links.prev');
            $this->paginaSiguiente = Arr::get($data, 'links.next');

            $tramites = collect($data['data']);

        } catch (GeneralException $ex) {

            abort(403, message:$ex->getMessage());

        } catch (\Throwable $th) {

            Log::error("Error al consultar consultar tramites es SGC. " . $th);

            abort(403, message:"Error al consultar tramites");

        }

        return view('livewire.catastro.tramites.mis-tramites', compact('tramites'))->extends('layouts.admin');
    }
}
