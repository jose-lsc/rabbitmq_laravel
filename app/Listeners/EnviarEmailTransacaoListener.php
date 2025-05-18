<?php

namespace App\Listeners;

use App\Events\NotificaTransacaoEvent;
use App\Mail\EnvioNotificacaoEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EnviarEmailTransacaoListener
{
    
    public function __construct()
    {
        //
    }

   
    public function handle(NotificaTransacaoEvent $event)
    {
        try {
            Log::info("Tentando enviar email, dados: $event->eventoTransacao");

            Mail::to('j.leozinhocosta@gmail.com')->send(new EnvioNotificacaoEmail($event->eventoTransacao));

            Log::info("E-mail enviado com sucesso para: j.leozinhocosta@gmail.com");
        } catch (\Exception $e) {
            Log::error("Erro ao enviar e-mail: " . $e->getMessage());
        }
    }
}
