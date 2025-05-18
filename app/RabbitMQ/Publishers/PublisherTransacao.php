<?php

namespace App\RabbitMQ\Publishers;

use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

class PublisherTransacao
{
    
    public function publish($dados, $prioridade)
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USER'),
            env('RABBITMQ_PASSWORD'),
            env('RABBITMQ_VHOST')
        );
       
        try {
            $queue = 'fila.transacoes';
            $exchange = 'exchange.transacoes';
            $routing_key = "key.transacoes";

            $channel = $connection->channel();
            $channel->queue_declare(
                $queue,
                false,
                true,
                false,
                false,
                false,
                new AMQPTable(['x-max-priority' => 10])
            );
            $channel->exchange_declare($exchange, 'direct', false, true, false);
            $channel->queue_bind($queue, $exchange, $routing_key);
            
            $mensagem = new AMQPMessage(json_encode($dados),[
                    'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
                    'priority' => $prioridade
                ]);
            $channel->basic_publish( $mensagem, $exchange, $routing_key);
             Log::info("requisição enviada para a fila: $queue");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
       

        $channel->close();
        $connection->close();
    }
    
}
