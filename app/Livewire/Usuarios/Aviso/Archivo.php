<?php

namespace App\Livewire\Usuarios\Aviso;

use Exception;
use App\Models\File;
use App\Models\Aviso;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Constantes\Constantes;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Archivo extends Component
{

    use WithFileUploads;

    public Aviso $aviso;
    public $avisoId;

    public $documento;
    public $croquis;

    public $modal = false;
    public $años;
    public $año_tramite;
    public $año_certificado;
    public $año_avaluo;
    public $folio_tramite;
    public $folio_certificado;
    public $folio_avaluo;
    public $usuario = 11;
    public $nombre_entidad;

    protected function rules(){
        return [
            'documento' => 'nullable|mimes:pdf',
            'aviso.observaciones' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.()\/\-," ]*$/'),
        ];
    }

    protected $listeners = ['cargarAviso'];

    public function crearModeloVacio(){
        $this->aviso = Aviso::make(['estado' => 'nuevo']);
    }

    public function cargarAviso($id){

        $this->aviso = Aviso::find($id);

    }

    public function resetear(){

        $this->reset([
            'documento'
        ]);
    }

    public function guardar(){

        $this->validate();

        try {

            DB::transaction(function () {

                if($this->documento){

                    if($this->aviso->archivo()->first()){

                        $file = File::where('fileable_id', $this->aviso->id)->where('fileable_type', 'App\Models\Aviso')->where('descripcion', 'archivo')->first();

                        Storage::disk('avisos')->delete($file->url);

                        $file->delete();

                    }

                    $pdf = $this->documento->store('/', 'avisos');

                    File::create([
                        'fileable_id' => $this->aviso->id,
                        'fileable_type' => 'App\Models\Aviso',
                        'descripcion' => 'archivo',
                        'url' => $pdf
                    ]);

                }

                $this->aviso->actualizado_por = auth()->id();
                $this->aviso->save();

                $this->dispatch('mostrarMensaje', ['success', "La información se guardó con éxito."]);

                $this->resetear();

            });

        } catch (\Throwable $th) {

            Log::error("Error al giuardar archivo de aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function revisar(){

        if(!$this->aviso->predio_sgc){

            $this->dispatch('mostrarMensaje', ['error', "Debe ingresar la información de Acto / Escritura."]);

            return true;

        }

        if(!$this->aviso->colindancias->count()){

            $this->dispatch('mostrarMensaje', ['error', "Debe ingresar las colindancias información de identificación de inmueble."]);

            return true;

        }

        if(!$this->aviso->transmitentes()->count()){

            $this->dispatch('mostrarMensaje', ['error', "Debe ingresar la información de transmitentes."]);

            return true;

        }

        if(!$this->aviso->adquirientes()->count()){

            $this->dispatch('mostrarMensaje', ['error', "Debe ingresar la información de adquirientes."]);

            return true;

        }

        if(!$this->aviso->valor_isai){

            $this->dispatch('mostrarMensaje', ['error', "Debe ingresar la información de ISAI."]);

            return true;

        }

        if(!$this->aviso->archivo()->first()){

            $this->dispatch('mostrarMensaje', ['error', "Debe subir el archivo."]);

            return true;

        }

        if(!$this->aviso->croquis()->first()){

            $this->dispatch('mostrarMensaje', ['error', "Debe subir el croquis."]);

            return true;

        }

        if($this->revisarProcentajes())  return true;

    }

    public function revisarProcentajes(){

        $pn_adquirientes = 0;

        $pn_transmitentes = 0;

        $pu_adquirientes = 0;

        $pu_transmitentes = 0;

        $pp_adquirientes = 0;

        $pp_transmitentes = 0;

        foreach($this->aviso->adquirientes() as $adquiriente){

            $pn_adquirientes = $pn_adquirientes + $adquiriente->porcentaje_nuda;

            $pu_adquirientes = $pu_adquirientes + $adquiriente->porcentaje_usufructo;

            $pp_adquirientes = $pp_adquirientes + $adquiriente->porcentaje;

        }

        foreach($this->aviso->transmitentes() as $transmitente){

            $pn_transmitentes = $pn_transmitentes + $transmitente->porcentaje_nuda;

            $pu_transmitentes = $pu_transmitentes + $transmitente->porcentaje_usufructo;

            $pp_transmitentes = $pp_transmitentes + $transmitente->porcentaje;

        }

        if($pp_adquirientes > $pp_transmitentes){

            $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes de propiedad no es igual."]);

            return true;

        }

        if($pp_transmitentes == 0){

            if($pn_adquirientes > $pn_transmitentes){

                $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes de nuda no es igual."]);

                return true;

            }

            if($pu_adquirientes > $pu_transmitentes){

                $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes de usufructo no es igual."]);

                return true;

            }

        }else{

            if($pn_adquirientes > $pp_transmitentes){

                $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes de nuda no es igual."]);

                return true;

            }

            if($pu_adquirientes > $pp_transmitentes){

                $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes de usufructo no es igual."]);

                return true;

            }

        }

    }

    public function consultarTramite(){

        $response = Http::acceptJson()
                        ->withToken(env('SGC_ACCESS_TOKEN'))
                        ->withQueryParameters([
                            'entidad' => auth()->user()->entidad_id,
                            'año' => $this->año_tramite,
                            'folio' => $this->folio_tramite,
                        ])
                        ->get(env('SGC_CONSULTA_TRAMITE'));


        $data = json_decode($response, true);

        if($response->status() === 200){

            $aviso = Aviso::where('tramite_sgc', $data['data']['id'])->first();

            if($aviso){

                $this->dispatch('mostrarMensaje', ['error', "El trámite ya fue usado en otro aviso."]);

                return true;

            }

            if(!$this->aviso->aviso_original){

                if(!in_array($data['data']['servicio_id'], [66,67])){

                    $this->dispatch('mostrarMensaje', ['error', "El trámite del aviso no corresponde a una revisión de avisio."]);

                    return true;

                }

            }else{

                if($data['data']['servicio_id'] !== 68){

                    $this->dispatch('mostrarMensaje', ['error', "El trámite del aviso no corresponde a un aviso aclaratorio de predio."]);

                    return true;

                }

            }

            if($data['data']['estado'] === 'nuevo'){

                $this->dispatch('mostrarMensaje', ['error', "El trámite del aviso no esta pagado."]);

                return true;

            }

            if($data['data']['estado'] === 'concluido'){

                $this->dispatch('mostrarMensaje', ['error', "El trámite del aviso esta concluido."]);

                return true;

            }

            if(!collect($data['data']['predios'])->where('id', $this->aviso->predio_sgc)->first()){

                $this->dispatch('mostrarMensaje', ['error', "El predio del trámite del aviso no coincide con el predio del aviso a cerrar."]);

                return true;

            }

            $this->aviso->tramite_sgc = $data['data']['id'];

        }elseif($response->status() === 404){

            $this->dispatch('mostrarMensaje', ['error', "No se encotró el trámite del aviso."]);

            return true;

        }else{

            Log::error("Error al consultar tramite de aviso en cierre por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $response);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

            return true;

        }

    }

    public function consultarCertificado(){

        $response = Http::acceptJson()
                        ->withToken(env('SGC_ACCESS_TOKEN'))
                        ->withQueryParameters([
                            'año' => $this->año_certificado,
                            'folio' => $this->folio_certificado,
                            'localidad' => $this->aviso->localidad,
                            'oficina' => $this->aviso->oficina,
                            'tipo_predio' => $this->aviso->tipo_predio,
                            'numero_registro' => $this->aviso->numero_registro,
                        ])
                        ->get(env('SGC_CONSULTA_CERTIFICADO'));


        $data = json_decode($response, true);

        if($response->status() === 200){

            $fecha_certificado = Carbon::createFromFormat('d-m-Y H:i:s', $data['data']['created_at']);

            if($fecha_certificado < now()->subDays(30)){

                $this->dispatch('mostrarMensaje', ['error', "El certificado tiene mas de 3 meses desde su elaboración."]);

                return true;

            }

            $this->aviso->certificado_sgc = $data['data']['tramite_id'];

        }elseif($response->status() === 404 || $response->status() === 401){

            $this->dispatch('mostrarMensaje', ['error', $data['error']]);

            return true;

        }else{

            Log::error("Error al consultar tramite de certificado en cierre por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $response);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

            return true;

        }

    }

    public function consultarAvaluo(){

        $response = Http::acceptJson()
                        ->withToken(env('SISTEMA_PERITOS_EXTERNOS_TOKEN'))
                        ->withQueryParameters([
                            'año' => $this->año_avaluo,
                            'folio' => $this->folio_avaluo
                        ])
                        ->get(env('SISTEMA_PERITOS_EXTERNOS_CONSULTAR_AVALUO'));


        $data = json_decode($response, true);

        if($response->status() === 200){

            $fecha_certificado = Carbon::createFromFormat('d-m-Y H:i:s', $data['data']['created_at']);

            if($fecha_certificado < now()->subDays(30)){

                $this->dispatch('mostrarMensaje', ['error', "El avalúo tiene mas de 3 meses desde su elaboración."]);

                return true;

            }

            if($data['data']['estado'] !== 'concluido'){

                $this->dispatch('mostrarMensaje', ['error', 'El avalúo debe estar concluido.']);

                return true;

            }

            if($this->aviso->predio_sgc !== $data['data']['predio_sgc']){

                $this->dispatch('mostrarMensaje', ['error', 'El predio del aviso y el predio del avalúo no son el mismo.']);

                return;

            }

            $this->aviso->avaluo_spe = $data['data']['id'];

        }elseif($response->status() === 404 || $response->status() === 401){

            $this->dispatch('mostrarMensaje', ['error', $data['error']]);

            return true;

        }else{

            Log::error("Error al consultar avalúo de aviso en cierre por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $response);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

            return true;

        }

    }

    public function cerrar(){

        if($this->revisar()) return;

        $this->validate([
            'folio_tramite' => Rule::requiredIf(!$this->aviso->tramite_sgc),
            'folio_certificado' => Rule::requiredIf(!$this->aviso->certificado_sgc && !$this->aviso->aviso_original),
            'folio_avaluo' => Rule::requiredIf(!$this->aviso->aviso_original)
        ]);

        try {

            if(!$this->aviso->tramite_sgc)
                if($this->consultarTramite()) return;

            if(!$this->aviso->aviso_original){

                if(!$this->aviso->certificado_sgc)
                    if($this->consultarCertificado()) return;

                if($this->consultarAvaluo()) return;

            }

        } catch (\Throwable $th) {

            Log::error("Error de conexión con sistemas en cierre por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

        if($this->aviso->entidad->numero_notaria){

            $entidad = 'Notaria ' . $this->aviso->entidad->numero_notaria;

        }else{

            $entidad = $this->aviso->entidad->dependencia;

        }

        try {

            $response = Http::acceptJson()
                        ->withToken(env('SGC_ACCESS_TOKEN'))
                        ->withQueryParameters([
                            'predio' => $this->aviso->predio_sgc,
                            'tramite_aviso' => $this->aviso->tramite_sgc,
                            'tramite_certificado' => $this->aviso->certificado_sgc,
                            'aviso_id' => $this->aviso->id,
                            'entidad_nombre' => $entidad,
                            'entidad_id' => $this->aviso->entidad_id,
                            'avaluo_id' => $this->aviso->avaluo_spe
                        ])
                        ->post(env('SGC_INGRESAR_TRASLADO'));


            $data = json_decode($response, true);

            if($response->status() === 200){

                $this->aviso->estado = 'cerrado';
                $this->aviso->actualizado_por = auth()->id();
                $this->aviso->save();

                return redirect()->route('mis_avisos');

            }elseif($response->status() === 404){

                $this->dispatch('mostrarMensaje', ['error', $data['error']]);

                return;

            }elseif($response->status() === 500){


                $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

                return;
            }

        } catch (\Throwable $th) {

            Log::error("Error al cerrar aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }


    }

    public function mount(){

        if($this->avisoId){

            $this->cargarAviso($this->avisoId);

        }else{

            $this->crearModeloVacio();

        }

        if(auth()->user()->entidad?->numero_notaria)
            $this->nombre_entidad = 'Notaria ' . auth()->user()->entidad->numero_notaria;
        else
            $this->nombre_entidad = auth()->user()->entidad?->dependencia;

        $this->años = Constantes::AÑOS;

        $this->año_tramite = $this->año_certificado = $this->año_avaluo = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.usuarios.aviso.archivo');
    }
}
