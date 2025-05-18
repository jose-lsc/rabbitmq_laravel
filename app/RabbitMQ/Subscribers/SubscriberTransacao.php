<?php

namespace App\RabbitMQ\Subscribers;

use App\Services\TransacaoService;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

class SubscriberTransacao
{
    protected TransacaoService $transacaoService;
    
    public function __construct() {
        $this->transacaoService = new TransacaoService();
    }
    public function subscribe()
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
            $callback = function ($msg){
               
                $dados = json_decode(json_encode($msg), true);
                $body = json_decode($dados['body'], true);
                dump($body);
                $this->processarMensagem($body);

                $msg->ack();
            };
            Log::info('requisição consumida pelo subscriber');
            $channel->basic_consume($queue, "",false, true, false, false, $callback);
            
            while ($channel->is_consuming()){
                //sleep(3);
                $channel->wait();
            }
            $channel->close();
            $connection->close();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
       
    }

    private function processarMensagem($dados) {
        $tipo = $dados['tipo'];

        switch ($tipo) {
            case 'transacao':
                Log::info("requisicao de transacao processada");
                $this->transacaoService->transacao(
                    $dados['emissor_id'],
                    $dados['valor'],
                    $dados['chave_pix']
                );
                break;
            case 'historico':
                Log::info("requisicao de historico processada");
                $this->transacaoService->consultarHistorico($dados['id']);
                break;
            default:
                # code...
                break;
        }
    }
    
}
