<?php

namespace App\Livewire\Usuarios\Aviso;

use App\Models\Actor;
use App\Models\Aviso;
use App\Models\Persona;
use Livewire\Component;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class Transmitentes extends Component
{

    public $años;
    public $año;
    public $folio;
    public $usuario = 11;

    public $transmitentes;
    public $transmitente;

    public Aviso $aviso;
    public $avisoId;

    protected $listeners = ['cargarAviso'];

    public function crearModeloVacio(){
        $this->aviso = Aviso::make(['estado' => 'nuevo']);
    }

    public function cargarAviso($id){

        $this->aviso = Aviso::find($id);

    }

    public function buscarTramite(){

        if(!$this->aviso->getKey()){

            $this->dispatch('mostrarMensaje', ['error', "Primero debe cargar el aviso."]);

            return;

        }

        try {

            $response = Http::acceptJson()
                            ->withToken(env('SGC_ACCESS_TOKEN'))
                            ->withQueryParameters([
                                'entidad' => auth()->user()->entidad_id,
                                'año' => $this->año,
                                'folio' => $this->folio,
                                'usuario' => $this->usuario,
                                'predio' => $this->aviso->predio_sgc
                            ])
                            ->get(env('SGC_CONSULTA_PROPIETARIOS'));


            $data = json_decode($response, true);

            if($response->status() === 200){

                if($this->aviso->acto == 'CONSOLIDACIÓN DE USUFRUCTO'){

                    $this->obtenerAdquirientes($data['data']);

                }else{

                    $this->transmitentes =  collect($data['data']);

                }

            }else if($response->status() === 404 || $response->status() === 401){

                $this->dispatch('mostrarMensaje', ['error', $data['error']]);

            }else{

                Log::error("Error al cargar transmitentes por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . json_encode($data));

                $this->dispatch('mostrarMensaje', ['error', 'Hubo un error']);

            }

        } catch (\Throwable $th) {
            Log::error("Error al consultar propietarios en SGC por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
        }

    }

    public function agregarTransmitente(){

        try {

            $transmitente = $this->transmitentes->where('id', $this->transmitente)->first();

            $persona = Persona::query()
                                ->where(function($q) use($transmitente){
                                    $q->when(isset($transmitente['nombre']), function($q) use($transmitente) { $q->where('nombre', $transmitente['nombre']); })
                                        ->when(isset($transmitente['ap_paterno']), function($q) use($transmitente) { $q->where('ap_paterno', $transmitente['ap_paterno']); })
                                        ->when(isset($transmitente['ap_materno']), function($q) use($transmitente) { $q->where('ap_materno', $transmitente['ap_materno']); });
                                })
                                ->when(isset($transmitente['razon_social']), function($q) use($transmitente) { $q->orWhere('razon_social', $transmitente['razon_social']); })
                                ->when(isset($transmitente['rfc']), function($q) use($transmitente) { $q->orWhere('rfc', $transmitente['rfc']); })
                                ->when(isset($transmitente['curp']), function($q) use($transmitente) { $q->orWhere('curp', $transmitente['curp']); })
                                ->first();


            if($persona && $this->aviso->actores()->where('tipo', 'transmitente')->where('persona_id', $persona->id)->first()){

                $this->dispatch('mostrarMensaje', ['error', 'La persona ya es un transmitente']);

                return;

            }

            if(!$persona){

                $persona = Persona::create([
                    'tipo' => $transmitente['tipo'],
                    'nombre' => $transmitente['nombre'],
                    'ap_paterno' => $transmitente['ap_paterno'],
                    'ap_materno' => $transmitente['ap_materno'],
                    'curp' => $transmitente['curp'],
                    'rfc' => $transmitente['rfc'],
                    'razon_social' => $transmitente['razon_social'],
                    'fecha_nacimiento' => $transmitente['fecha_nacimiento'],
                    'nacionalidad' => $transmitente['nacionalidad'],
                    'estado_civil' => $transmitente['estado_civil'],
                    'calle' => $transmitente['calle'],
                    'numero_exterior' => $transmitente['numero_exterior'],
                    'numero_interior' => $transmitente['numero_interior'],
                    'colonia' => $transmitente['colonia'],
                    'cp' => $transmitente['cp'],
                    'entidad' => $transmitente['entidad'],
                    'municipio' => $transmitente['municipio'],
                    'ciudad' => $transmitente['ciudad'],
                    'creado_por' => auth()->id()
                ]);

            }

            $this->aviso->actores()->create([
                'tipo' => 'transmitente',
                'persona_id' => $persona->id,
                'porcentaje' => $transmitente['porcentaje'],
                'porcentaje_nuda' => $transmitente['porcentaje_nuda'],
                'porcentaje_usufructo' => $transmitente['porcentaje_usufructo'],
                'creado_por' => auth()->id()
            ]);

            $this->aviso->refresh();

            $this->dispatch('mostrarMensaje', ['success', 'Se agregó el transmitente con éxito']);


        } catch (\Throwable $th) {

            Log::error("Error al cargar transmitentes por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error']);

        }

    }

    public function borrarTransmitente($id){

        try {

            Actor::find($id)->delete();

             $this->dispatch('mostrarMensaje', ['success', 'Se elimino el transmitente con éxito']);

        } catch (\Throwable $th) {

            Log::error("Error al borrar transmitente por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error']);

        }

    }

    public function obtenerAdquirientes($data){

        $propietarios = collect($data['data']);

        foreach($propietarios as $propietario){

            if(isset($propietario['porcentaje_nuda'])){

                $persona = Persona::query()
                                        ->where(function($q) use($propietario){
                                            $q->when(isset($propietario['nombre']), function($q) use($propietario) { $q->where('nombre', $propietario['nombre']); })
                                                ->when(isset($propietario['ap_paterno']), function($q) use($propietario) { $q->where('ap_paterno', $propietario['ap_paterno']); })
                                                ->when(isset($propietario['ap_materno']), function($q) use($propietario) { $q->where('ap_materno', $propietario['ap_materno']); });
                                        })
                                        ->when(isset($propietario['razon_social']), function($q) use($propietario) { $q->orWhere('razon_social', $propietario['razon_social']); })
                                        ->when(isset($propietario['rfc']), function($q) use($propietario) { $q->orWhere('rfc', $propietario['rfc']); })
                                        ->when(isset($propietario['curp']), function($q) use($propietario) { $q->orWhere('curp', $propietario['curp']); })
                                        ->when(isset($propietario['correo']), function($q) use($propietario) { $q->orWhere('correo', $propietario['correo']); })
                                        ->first();

                if(!$persona){

                    $persona = Persona::create([
                        'tipo' => $propietario['tipo_persona'],
                        'nombre' => $propietario['nombre'],
                        'ap_paterno' => $propietario['ap_paterno'],
                        'ap_materno' => $propietario['ap_materno'],
                        'curp' => $propietario['curp'],
                        'rfc' => $propietario['rfc'],
                        'razon_social' => $propietario['razon_social'],
                        'fecha_nacimiento' => $propietario['fecha_nacimiento'],
                        'nacionalidad' => $propietario['nacionalidad'],
                        'estado_civil' => $propietario['estado_civil'],
                        'calle' => $propietario['calle'],
                        'numero_exterior' => $propietario['numero_exterior_propietario'],
                        'numero_interior' => $propietario['numero_interior_propietario'],
                        'colonia' => $propietario['colonia'],
                        'ciudad' => $propietario['ciudad'],
                        'correo' => $propietario['correo'],
                        'cp' => $propietario['cp'],
                        'entidad' => $propietario['entidad'],
                        'municipio' => $propietario['municipio_propietario'],
                        'creado_por' => auth()->id()
                    ]);

                }

                $this->aviso->actores()->create([
                    'persona_id' => $persona->id,
                    'tipo' => 'adquiriente',
                    'porcentaje' => $propietario['porcentaje'],
                    'porcentaje_nuda' => $propietario['porcentaje_nuda'],
                    'porcentaje_usufructo' => $propietario['porcentaje_usufructo'],
                    'creado_por' => auth()->id()
                ]);

            }

        }

    }

    public function mount(){

        if($this->avisoId){

            $this->cargarAviso($this->avisoId);

        }else{

            $this->crearModeloVacio();

        }

        $this->años = Constantes::AÑOS;

        $this->año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.usuarios.aviso.transmitentes');
    }

}
