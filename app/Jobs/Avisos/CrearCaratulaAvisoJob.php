<?php

namespace App\Jobs\Avisos;

use App\Http\Controllers\ImprimirAvisosController;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Aviso;
use App\Models\File;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CrearCaratulaAvisoJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Aviso $aviso, public User $user)
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        try {

            if($this->aviso->caratula){

                if(app()->isProduction()){

                    if (Storage::disk('s3')->exists(config('services.ses.ruta_caratulas') . $this->aviso->caratula->url)) {

                        Storage::disk('s3')->delete(config('services.ses.ruta_caratulas') . $this->aviso->caratula->url);

                    }

                }else{

                    if (Storage::disk('caratulas')->exists($this->aviso->caratula->url)) {

                        Storage::disk('caratulas')->delete($this->aviso->caratula->url);

                    }

                }

                $this->aviso->caratula->delete();

            }

            $pdf = (new ImprimirAvisosController())->imprimir($this->aviso, $this->user);

            $nombre = Str::random(40) . '.pdf';

            if(app()->isProduction()){

                Storage::disk('s3')->put(config('services.ses.ruta_caratulas') . $nombre, $pdf->output());

            }else{

                Storage::put('caratulas/' . $nombre, $pdf->output());

            }

            File::create([
                'fileable_id' => $this->aviso->id,
                'fileable_type' => 'App\Models\Aviso',
                'descripcion' => 'caratula',
                'url' => $nombre
            ]);

        } catch (\Throwable $th) {

            Log::error('Error al crear caratula en job' . $th);

        }

    }
}
