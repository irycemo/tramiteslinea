<?php

namespace App\Livewire\Admin\Avisos;

use App\Models\Aviso;
use Livewire\Component;
use App\Services\SGCService;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Services\PeritosExternosService;

class VerAviso extends Component
{

    public Aviso $aviso;
    public $predio;

    public $data_tramite_aviso;
    public $modal = false;

    public function verTramiteAviso(){

        try {

            $this->data_tramite_aviso = (new SGCService())->consultarTramieId($this->aviso->tramite_sgc);

            $this->modal = true;

        }  catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        }catch (\Throwable $th) {

            Log::error("Error al consultar aviso aclaratorio en ver aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function reimprimirCertificado(){

        try {

            $data = (new SGCService())->generarCertificadoPdf($this->aviso->certificado_sgc);

            $pdf = base64_decode($data['data']['pdf']);

            return response()->streamDownload(
                fn () => print($pdf),
                $this->predio->cuentaPredial() . '-' . 'certificado_de_registro.pdf'
            );

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al generar pdf del certificado en ver aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function imprimirAvaluo(){

        try {

            $data = (new PeritosExternosService())->generarAvaluoPdf($this->aviso->avaluo_spe);

            $pdf = base64_decode($data['data']['pdf']);

            return response()->streamDownload(
                fn () => print($pdf),
                'avaluo.pdf'
            );

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al generar pdf del avalúo en ver aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function mount(){

        $this->aviso->load('audits.user');

        $this->predio = $this->aviso->predio;

    }

    public function render()
    {
        return view('livewire.admin.avisos.ver-aviso')->extends('layouts.admin');
    }

}
