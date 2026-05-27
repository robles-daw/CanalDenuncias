<?php

namespace App\Mail;

use App\Models\Denuncia;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CodigoSeguimientoMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Denuncia $denuncia,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Código de seguimiento de tu denuncia',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.denuncias.codigo-seguimiento',
        );
    }
}
