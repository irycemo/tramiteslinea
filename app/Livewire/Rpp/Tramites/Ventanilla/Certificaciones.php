<?php

namespace App\Livewire\Rpp\Tramites\Ventanilla;

use Livewire\Component;
use App\Services\SrppService;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Services\STramtiesService;
use App\Traits\SapTrait;
use App\Traits\ImprimirReciboTrait;
use App\Traits\SolicitanteTrait;

class Certificaciones extends Component
{

    use SolicitanteTrait;
    use ImprimirReciboTrait;
    use SapTrait;

    public $servicios;
    public $servicio_id;
    public $servicioSeleccionado;

    public $tipo_servicio = "ordinario";
    public $solicitante;
    public $nombre_solicitante;
    public $total;

    public $tramite;

    public $token;
    public $link_pago_linea;

    public $folio_real;
    public $tomo;
    public $registro;
    public $distrito;
    public $numero_propiedad;
    public $predio = [];

    public $distritos;
    public $antecedentes = [];

    public function rules(){

        return [
            'servicio_id' => 'required|numeric',
            'folio_real' => Rule::requiredIf(
                                $this->servicioSeleccionado['clave_ingreso'] === 'DL07' &&
                                $this->distrito === null &&
                                $this->tomo === null &&
                                $this->registro === null &&
                                $this->numero_propiedad === null
                            ),
            'tomo' => Rule::requiredIf($this->folio_real == null && $this->servicioSeleccionado['clave_ingreso'] === 'DL07'),
            'distrito' => Rule::requiredIf($this->folio_real == null && $this->servicioSeleccionado['clave_ingreso'] === 'DL07'),
            'registro' => Rule::requiredIf($this->folio_real == null && $this->servicioSeleccionado['clave_ingreso'] === 'DL07'),
            'numero_propiedad' => Rule::requiredIf($this->folio_real == null && $this->servicioSeleccionado['clave_ingreso'] === 'DL07'),
        ];

    }

    public function updatedFolioReal(){

        if($this->folio_real == ''){

            $this->folio_real = null;

        }

        $this->reset(['predio', 'tomo', 'registro', 'numero_propiedad', 'distrito', 'tramite']);

    }

    public function updatedTomo(){

        if($this->tomo == ''){

            $this->reset(['predio', 'folio_real']);

        }

        $this->reset(['antecedentes', 'tramite']);

    }

    public function updatedDistrito(){

        if($this->distrito == ''){

            $this->reset(['predio', 'folio_real']);

        }

        $this->reset(['antecedentes', 'tramite']);

    }

    public function updatedRegistro(){

        if($this->registro == ''){

            $this->reset(['predio', 'folio_real']);

        }

        $this->reset(['antecedentes', 'tramite']);

    }

    public function updatedNumeroPropiedad(){

        if($this->numero_propiedad == ''){

            $this->reset(['predio', 'folio_real']);

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

        if($this->servicio_id == '') return;

        $this->servicioSeleccionado = collect($this->servicios)->where('id', $this->servicio_id)->first();

        $this->resetearTodo();

        $this->total = $this->servicioSeleccionado['ordinario'];

    }

    public function resetearTodo(){

        $this->reset(['folio_real', 'tomo', 'registro', 'numero_propiedad', 'total', 'predio', 'antecedentes', 'tramite']);

    }

    public function consultarFolioReal(){

        $this->resetErrorBag();
        $this->resetValidation();

        $folio_real = (new SrppService())->consultarFolioReal($this->folio_real);

        $this->predio = [
            'folio_real' => $folio_real['folio'],
            'tomo' => $folio_real['tomo'],
            'registro' => $folio_real['registro'],
            'distrito' => $folio_real['distrito'],
            'numero_propiedad' => $folio_real['numero_propiedad'],
        ];

    }

    public function crearTramite(){

        if(auth()->user()->hasRole('Administrador')){

            $this->dispatch('mostrarMensaje', ['warning', 'Los administradores no pueden generar trámites.']);

            return;

        }

        $this->validate();

        try {

            if($this->folio_real){

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

            Log::error(
                "Error al crear trámite certificado de gravamen.",
                [
                    'message' => $th->getMessage(),
                    'user_id' => auth()->id(),
                    'usser' => auth()->user()->name,
                    'trace' => $th->getTraceAsString()
                ]
            );

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function mount(){

        try {

            $servicios = (new STramtiesService())->consultarServicios(['DL07']);

            $this->servicios = collect($servicios['data'])->sortBy('nombre');

        } catch (GeneralException $ex) {

            abort(403, message:"Error al consultar servicios");

        } catch (\Throwable $th) {

            Log::error(
                "Error al consultar consultar servicios es SGC.",
                [
                    'message' => $th->getMessage(),
                    'usuario_id' => auth()->id(),
                    'usuario' => auth()->user()->name,
                    'trace' => $th->getTraceAsString()
                ]
            );

            abort(403, message:"Error al consultar servicios");

        }

        $this->solicitante();

        $this->link_pago_linea = config('services.sap.link_pago_linea');

    }

    public function render()
    {
        return view('livewire.rpp.tramites.ventanilla.certificaciones');
    }

}
