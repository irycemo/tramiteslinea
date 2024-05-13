<?php

namespace App\Mail;

use App\Models\Observacion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RechazarAvisoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Observacion $observacion){}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rechazo de aviso',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        if($this->observacion->entidad->numero_notaria){

            $entidad = 'Notaria ' . $this->observacion->entidad->numero_notaria;

        }else{

            $entidad = $this->observacion->entidad->dependencia;

        }

        return new Content(
            markdown: 'emails.aviso-rechazo',
            with:[
                'entidad' => $entidad,
                'observacion' => $this->observacion,
                'url' => route('mis_avisos')
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
