<?php

namespace App\Livewire\Rpp\Tramites\Ventanilla;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Services\STramtiesService;
use App\Traits\ImprimirReciboTrait;
use App\Traits\SapTrait;
use App\Traits\SolicitanteTrait;

class Comercio extends Component
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

    public function rules(){

        return [
            'servicio_id' => 'required|numeric'
        ];

    }

    public function updatedServicioId(){

        if($this->servicio_id == '') return;

        $this->servicioSeleccionado = collect($this->servicios)->where('id', $this->servicio_id)->first();

        $this->reset(['tramite']);

        $this->total = $this->servicioSeleccionado['ordinario'];

    }



    public function crearTramite(){

        if(auth()->user()->hasRole('Administrador')){

            $this->dispatch('mostrarMensaje', ['warning', 'Los administradores no pueden generar trámites.']);

            return;

        }

        $this->validate();

        try {

            $this->tramite = (new STramtiesService())->crearTramite(
                                                                $this->tipo_servicio,
                                                                $this->servicio_id,
                                                                $this->solicitante,
                                                                $this->nombre_solicitante,
                                                                $this->total,
                                                                auth()->user()->entidad_id,
                                                                []
                                                            );

            $this->dispatch('mostrarMensaje', ['success', 'Trámite ' . $this->tramite['año'] . '-' . $this->tramite['folio'] . '-' . $this->tramite['usuario'] . ' se registró con éxito']);

            $this->token = $this->encrypt_decrypt("encrypt", $this->tramite['linea_de_captura'] . $this->tramite['monto'] . config('services.sap.concepto') . $this->tramite['fecha_vencimiento']);

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error(
                "Error al crear trámite de rpp",
                [
                    'message' => $th->getMessage(),
                    'user_id' => auth()->id(),
                    'user' => auth()->user()->name,
                    'trace' => $th->getTraceAsString()
                ]
            );

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

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
                                                                        'D774'
                                                                    ]);

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
        return view('livewire.rpp.tramites.ventanilla.comercio');
    }
}
