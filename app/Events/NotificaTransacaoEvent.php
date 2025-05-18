<?php

namespace App\Events;

use App\Models\Transacao;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificaTransacaoEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $eventoTransacao;

    public function __construct(Transacao $eventoTransacao)
    {
        $this->eventoTransacao = $eventoTransacao;
    }

   
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
