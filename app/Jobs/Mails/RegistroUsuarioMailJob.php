<?php

namespace App\Jobs\Mails;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\RegistroUsuarioMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;

class RegistroUsuarioMailJob implements ShouldQueue
{

    use Queueable, InteractsWithQueue, SerializesModels;

    public int $tries = 5;

    public function __construct(public int $user_id)
    {}

    public function handle(): void
    {
         $usuario = User::find($this->user_id);

         Mail::to($usuario->email)->send(new RegistroUsuarioMail($usuario));

    }

}
