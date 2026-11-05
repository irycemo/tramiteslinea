<?php

namespace App\Jobs\Mails;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\AvsioRevertidoMail;
use App\Models\Aviso;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;

class RevertirAvisoMailJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public int $tries = 5;

    public function __construct(public int $aviso_id, public string $observaciones)
    {}

    public function handle(): void
    {

        $aviso = Aviso::with('entidad')->findOrFail($this->aviso_id);

        Mail::to($aviso->entidad->email)->send(new AvsioRevertidoMail($aviso, $this->observaciones));

    }
}
