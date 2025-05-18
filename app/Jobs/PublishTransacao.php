<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

class PublishTransacao implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $dados;
    public $priority;

    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    public function handle()
    {
        
        // try {
        //     $connection = new AMQPStreamConnection(
        //     env('RABBITMQ_HOST'),
        //     env('RABBITMQ_PORT'),
        //     env('RABBITMQ_USER'),
        //     env('RABBITMQ_PASSWORD'),
        //     env('RABBITMQ_VHOST')
        //     );
            
        //     $queue = 'fila.transacoes';
        //     $exchange = 'exchange.transacoes';
        //     $routing_key = "key.transacoes";
            
        //     $channel = $connection->channel();
        //     $channel->queue_declare(
        //         $queue,
        //         false,
        //         true,
        //         false,
        //         false,
        //         false,
        //         new AMQPTable(['x-max-priority' => 10])
        //     );
        //     $channel->exchange_declare($exchange, 'direct', false, true, false);
        //     $channel->queue_bind($queue, $exchange, $routing_key);
        //     $mensagem = new AMQPMessage(json_encode('teste'),[
        //             'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
        //             'priority' => 10
        //         ]);
        //     $channel->basic_publish( $mensagem, $exchange, $routing_key);
           
            
        //     echo " Mensagem publicada na fila do CloudAMQP com sucesso.\n";
            
        // } catch (\Exception $e) {
        //     echo $e->getMessage();
        // }
        //  $channel->close();
        // $connection->close();
    }
}
