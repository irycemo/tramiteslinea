<?php

namespace App\Jobs\Mails;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Aviso;
use App\Mail\AvisoAutorizadoMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;

class AvisoAutorizadoMailJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public int $tries = 5;

    public function __construct(public int $aviso_id)
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $aviso = Aviso::with('entidad')->findOrFail($this->aviso_id);

        Mail::to($aviso->entidad->email)->send(new AvisoAutorizadoMail($aviso, $validated['observaciones'] ?? null));

    }
}
