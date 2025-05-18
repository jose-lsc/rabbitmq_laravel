<?php

namespace App\Console\Commands;

use App\RabbitMQ\Subscribers\SubscriberTransacao;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Wire\AMQPTable;

class SubscriberTransacaoCommand extends Command
{
   
    protected $signature = 'consume:transacao';

    public function handle()
    {
        $subscriber = new SubscriberTransacao();
        
        $subscriber->subscribe();
    }
}
