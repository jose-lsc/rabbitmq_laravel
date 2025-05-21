<?php

namespace App\Mail;

use App\Models\Transacao;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EnvioNotificacaoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $transacao;

    public function __construct($transacao)
    {
        $this->transacao = $transacao;
    }

    public function build() {
        Log::info("email enviado $this->transacao");
        return $this->subject("Transacao bancaria efetuada em sua conta")
            ->html('Sua Transacao foi concluida!');
    }

}
