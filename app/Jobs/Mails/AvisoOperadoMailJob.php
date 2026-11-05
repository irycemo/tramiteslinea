<?php

namespace App\Jobs\Mails;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\AvisoOperadoMail;
use App\Models\Aviso;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class AvisoOperadoMailJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public int $tries = 5;

    public function __construct(public int $aviso_id)
    {}

    public function handle(): void
    {

        $aviso = Aviso::with('entidad')->findOrFail($this->aviso_id);

        Mail::to($aviso->entidad->email)->send(new AvisoOperadoMail($aviso));

    }
}
