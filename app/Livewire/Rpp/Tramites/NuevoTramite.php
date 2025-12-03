<?php

namespace App\Livewire\Rpp\Tramites;

use Livewire\Component;
use App\Traits\SapTrait;
use App\Services\SrppService;
use Illuminate\Validation\Rule;
use App\Services\STramtiesService;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Http\Controllers\TramiteReciboController;

class NuevoTramite extends Component
{

    use SapTrait;

    public $servicios;
    public $servicio_id;
    public $servicioSeleccionado;
    public $tipo_servicio = "ordinario";
    public $solicitante;
    public $nombre_solicitante;

    public $total;

    public $predio = [];

    public $tramite;

    public $token;
    public $link_pago_linea;

    public $folio_real;
    public $tomo;
    public $registro;
    public $distrito;
    public $numero_propiedad;

    public $distritos;
    public $antecedentes = [];

    public $flags = [
        'antecedente' => true,
        'numero_propiedad' => true
    ];

    public function rules(){

        return [
            'tomo' => [Rule::requiredIf(in_array($this->servicioSeleccionado['clave_ingreso'], ['DL07']) && !$this->folio_real), 'nullable', 'numeric'],
            'registro' => [Rule::requiredIf(in_array($this->servicioSeleccionado['clave_ingreso'], ['DL07']) && !$this->folio_real), 'nullable', 'numeric'],
            'distrito' => [Rule::requiredIf(in_array($this->servicioSeleccionado['clave_ingreso'], ['DL07']) && !$this->folio_real), 'nullable', 'numeric'],
            'numero_propiedad' => [Rule::requiredIf(in_array($this->servicioSeleccionado['clave_ingreso'], ['DL07']) && !$this->folio_real), 'nullable', 'numeric'],
            'folio_real' => 'nullable',
        ];

    }

    public function updatedTomo(){

        if($this->tomo == ''){

            $this->reset('predio');

        }

        $this->reset(['antecedentes', 'tramite']);

    }

    public function updatedDistrito(){

        if($this->distrito == ''){

            $this->reset('predio');

        }

        $this->reset(['antecedentes', 'tramite']);

    }

    public function updatedRegistro(){

        if($this->registro == ''){

            $this->reset('predio');

        }

        $this->reset(['antecedentes', 'tramite']);

    }

    public function updatedNumeroPropiedad(){

        if($this->numero_propiedad == ''){

            $this->reset('predio');

            return;

        }

        $this->predio = [
            'folio_real' => $this->folio_real,
            'tomo' => $this->tomo,
            'registro' => $this->registro,
            'distrito' => $this->distrito,
            'numero_propiedad' => $this->numero_propiedad,
        ];

    }

    public function updatedServicioId(){

        $this->servicioSeleccionado = collect($this->servicios)->where('id', $this->servicio_id)->first();

        $this->resetearTodo();

        $this->total = $this->servicioSeleccionado['ordinario'];

    }

    public function resetearTodo(){

        $this->reset(['folio_real', 'tomo', 'registro', 'numero_propiedad', 'total', 'predio', 'antecedentes', 'tramite']);

    }

    public function updatedFolioReal(){

        if($this->folio_real == ''){

            $this->folio_real = null;

        }

        $this->reset(['predio', 'tomo', 'registro', 'numero_propiedad', 'distrito', 'tramite']);

    }

    public function cambiarFlagNumeroPropiedad(){

        $this->flags['numero_propiedad'] = true;

    }

    public function consultarAntecedentes(){

        $this->resetErrorBag();
        $this->resetValidation();

        $this->validate([
            'tomo' => ['nullable', Rule::requiredIf(!$this->folio_real), 'numeric'],
            'registro' => [Rule::requiredIf(!$this->folio_real), 'nullable', 'numeric'],
            'distrito' => [Rule::requiredIf(!$this->folio_real), 'nullable', 'numeric'],
            'folio_real' => [Rule::requiredIf(!$this->tomo && !$this->registro && !$this->distrito), 'nullable', 'numeric'],
        ]);

        try {

            $this->reset('antecedentes');

            $this->flags['numero_propiedad'] = false;

            $this->antecedentes = (new SrppService())->consultarAntecedentes($this->tomo, $this->registro, $this->distrito);

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al consultar antecedentes en nuevo tramite rpp por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function consultarFolioReal(){

        $this->resetErrorBag();
        $this->resetValidation();

        $this->validate([
            'tomo' => ['nullable', Rule::requiredIf(!$this->folio_real), 'numeric'],
            'registro' => [Rule::requiredIf(!$this->folio_real), 'nullable', 'numeric'],
            'distrito' => [Rule::requiredIf(!$this->folio_real), 'nullable', 'numeric'],
            'folio_real' => [Rule::requiredIf(!$this->tomo && !$this->registro && !$this->distrito), 'nullable', 'numeric'],
        ]);

        $folio_real = (new SrppService())->consultarFolioReal($this->folio_real, $this->tomo, $this->registro, $this->numero_propiedad, $this->distrito);

        if(empty($folio_real)) {

            return;

        }

        $this->folio_real = $folio_real['folio'];
        $this->tomo = $folio_real['tomo'];
        $this->registro = $folio_real['registro'];
        $this->distrito = $folio_real['distrito'];
        $this->numero_propiedad = $folio_real['numero_propiedad'];

        $this->predio = [
            'folio_real' => $folio_real['folio'],
            'tomo' => $folio_real['tomo'],
            'registro' => $folio_real['registro'],
            'distrito' => $folio_real['distrito'],
            'numero_propiedad' => $folio_real['numero_propiedad'],
        ];

    }

    public function crearTramite(){

        $this->validate();

        try {

            if($this->folio_real || $this->tomo || $this->registro || $this->distrito || $this->numero_propiedad){

                $this->consultarFolioReal();

            }

            $this->tramite = (new STramtiesService())->crearTramite(
                                                                $this->tipo_servicio,
                                                                $this->servicio_id,
                                                                $this->solicitante,
                                                                $this->nombre_solicitante,
                                                                $this->total,
                                                                auth()->user()->entidad_id,
                                                                $this->predio
                                                            );

            $this->dispatch('mostrarMensaje', ['success', 'Trámite ' . $this->tramite['año'] . '-' . $this->tramite['folio'] . '-' . $this->tramite['usuario'] . ' se registró con éxito']);

            $this->token = $this->encrypt_decrypt("encrypt", $this->tramite['linea_de_captura'] . $this->tramite['monto'] . config('services.sap.concepto') . $this->tramite['fecha_vencimiento']);

        } catch (GeneralException $ex) {

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

            $servicios = (new STramtiesService())->consultarServicios([
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
                                                                        'DL17',
                                                                        'DL07'
                                                                    ]);

            $this->servicios = collect($servicios['data'])->sortBy('nombre');

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

        $this->distritos = [
            18 => '18 Ario De Rosales',
            19 => '19 Tanhuato',
            2 => '02 Uruapan'
        ];

    }

    public function render()
    {
        return view('livewire.rpp.tramites.nuevo-tramite')->extends('layouts.admin');
    }
}
