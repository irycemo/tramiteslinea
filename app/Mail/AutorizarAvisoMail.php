<?php

namespace App\Mail;

use App\Models\Aviso;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class AutorizarAvisoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public $observaciones = null, public Aviso $aviso){}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Autorización de aviso',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        if($this->aviso->entidad->numero_notaria){

            $entidad = 'Notaria ' . $this->aviso->entidad->numero_notaria;

        }else{

            $entidad = $this->aviso->entidad->dependencia;

        }

        return new Content(
            markdown: 'emails.aviso-autorizar',
            with:[
                'entidad' => $entidad,
                'aviso' => $this->aviso,
                'observacion' => $this->observaciones,
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
