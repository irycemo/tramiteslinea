<?php

namespace App\Jobs\Mails;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\AvsioRechazadoMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Aviso;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;

class AvisoRechazadoMailJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public int $tries = 5;

    public function __construct(public int $aviso_id, public string $observaciones)
    {}

    public function handle(): void
    {

        $aviso = Aviso::with('entidad')->findOrFail($this->aviso_id);

        Mail::to($aviso->entidad->email)->send(new AvsioRechazadoMail($aviso, $this->observaciones));

    }
}
