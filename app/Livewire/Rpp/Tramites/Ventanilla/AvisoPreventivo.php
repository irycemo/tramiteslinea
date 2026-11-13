<?php

namespace App\Livewire\Rpp\Tramites\Ventanilla;

use Livewire\Component;
use App\Models\File;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Models\AvisoPreventivo as AvisoPreventivoModel;
use App\Services\STramtiesService;
use App\Services\SrppService;
use Illuminate\Validation\Rule;
use App\Traits\SapTrait;
use App\Traits\ImprimirReciboTrait;
use App\Traits\SolicitanteTrait;

class AvisoPreventivo extends Component
{

    use SolicitanteTrait;
    use ImprimirReciboTrait;
    use SapTrait;
    use WithFileUploads;

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
    public $propiedad = [];

    public $distritos;
    public $antecedentes = [];

    public $descripcion_acto;
    public $documento_entrada;
    public $fecha_documento;

    public function rules(){

        return [
            'descripcion_acto' => 'required',
            'documento_entrada' => 'required|mimes:pdf',
            'servicio_id' => 'required|numeric',
            'folio_real' => Rule::requiredIf(
                                $this->distrito === null &&
                                $this->tomo === null &&
                                $this->registro === null &&
                                $this->numero_propiedad === null
                            ),
            'tomo' => Rule::requiredIf($this->folio_real == null),
            'distrito' => Rule::requiredIf($this->folio_real == null),
            'registro' => Rule::requiredIf($this->folio_real == null),
            'numero_propiedad' => Rule::requiredIf($this->folio_real == null),
            'fecha_documento' => 'required|before:tomorrow'
        ];

    }

    public function updatedFolioReal(){

        if($this->folio_real == ''){

            $this->folio_real = null;

        }

        $this->reset(['propiedad', 'tomo', 'registro', 'numero_propiedad', 'distrito', 'tramite']);

    }

    public function updatedTomo(){

        if($this->tomo == ''){

            $this->reset(['propiedad', 'folio_real']);

        }

        $this->reset(['antecedentes', 'tramite']);

    }

    public function updatedDistrito(){

        if($this->distrito == ''){

            $this->reset(['propiedad', 'folio_real']);

        }

        $this->reset(['antecedentes', 'tramite']);

    }

    public function updatedRegistro(){

        if($this->registro == ''){

            $this->reset(['propiedad', 'folio_real']);

        }

        $this->reset(['antecedentes', 'tramite']);

    }

    public function updatedNumeroPropiedad(){

        if($this->numero_propiedad == ''){

            $this->reset(['propiedad', 'folio_real']);

            return;

        }

        $this->propiedad = [
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

        $this->reset(['folio_real', 'tomo', 'registro', 'numero_propiedad', 'total', 'propiedad', 'antecedentes', 'tramite', 'descripcion_acto', 'documento_entrada']);

    }

    public function consultarFolioReal(){

        $this->resetErrorBag();
        $this->resetValidation();

        $folio_real = (new SrppService())->consultarFolioReal($this->folio_real);

        $this->propiedad = [
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

            $this->tramite = (new STramtiesService())->crearTramitePrimerAviso(
                                                                $this->tipo_servicio,
                                                                $this->servicio_id,
                                                                $this->solicitante,
                                                                $this->nombre_solicitante,
                                                                $this->total,
                                                                auth()->user()->entidad_id,
                                                                $this->propiedad,
                                                                $this->fecha_documento,
                                                                auth()->user()->entidad->titular(),
                                                                auth()->user()->entidad->numero_notaria
                                                            );

            $this->token = $this->encrypt_decrypt("encrypt", $this->tramite['linea_de_captura'] . $this->tramite['monto'] . config('services.sap.concepto') . $this->tramite['fecha_vencimiento']);

            $aviso_preventivo = AvisoPreventivoModel::create([
                'estado' => 'nuevo',
                'tramite_id' => $this->tramite['id'],
                'tramite_año' => $this->tramite['año'],
                'tramite_folio' => $this->tramite['folio'],
                'tramite_usuario' => $this->tramite['usuario'],
                'folio_real' => $this->folio_real,
                'descripcion_acto' => $this->descripcion_acto,
                'entidad_id' => auth()->user()->entidad_id,
                'creado_por' => auth()->id()
            ]);

            if(app()->isProduction()){

                $url = $this->documento->store(config('services.ses.documento_entrada'), 's3');

            }else{

                $url = $this->documento_entrada->store('/', 'documento_entrada');

            }

            File::create([
                'fileable_id' => $aviso_preventivo->id,
                'fileable_type' => AvisoPreventivoModel::class,
                'descripcion' => 'documento entrada',
                'url' => $url
            ]);

            $this->dispatch('mostrarMensaje', ['success', 'Trámite ' . $this->tramite['año'] . '-' . $this->tramite['folio'] . '-' . $this->tramite['usuario'] . ' se registró con éxito']);

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

            $this->reset('servicio_id');

        } catch (\Throwable $th) {

            Log::error(
                "Error al crear trámite de aviso preventivo.",
                [
                    'message' => $th->getMessage(),
                    'user_id' => auth()->id(),
                    'user' => auth()->user()->name,
                    'trace' => $th->getTraceAsString()
                ]
            );

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

            $this->reset('servicio_id');

        }

    }

    public function mount(){

        try {

            $servicios = (new STramtiesService())->consultarServicios(['DN83']);

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
        return view('livewire.rpp.tramites.ventanilla.aviso-preventivo');
    }

}
