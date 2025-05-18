<?php

namespace App\Http\Controllers\Api;

use App\Console\Commands\RabbitMQCreateQueue;
use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\RabbitMQ\Publishers\PublisherTransacao;
use App\RabbitMQ\Subscribers\SubscriberTransacao;
use App\Services\TransacaoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransacaoController extends Controller
{
    protected const TRANSACAO = 'transacao';
    protected const HISTORICO = 'historico';
    protected PublisherTransacao $publisher;
    
    public function __construct() {
        $this->publisher = new PublisherTransacao();
    }


    public function transacao(Request $request) {

        $valido = $request->validate([
            "emissor_id" => 'required|integer',
            "valor" => 'required|numeric|decimal:2',
        ]);
        $valido['chave_pix'] = $request->input('chave_pix');
        $valido['tipo'] = self::TRANSACAO;

        Log::info('Transação iniciada e enviada ao publisher');
        
        $this->publisher->publish($valido, 10);
        
        return response()->json([
            'retorno' => true,
            'mensagem' => 'Transação enviada ao publisher'
        ]);
        
    }

    public function consultarHistorico($id) {
        try {

            $cliente = Cliente::findOrFail($id);
            if(!$cliente){
                return response()->json([
                    'retorno' => false,
                    'dados' => "cliente não encontrado"
                ]);
            }
            $envio = [
                'id' => $id,
                'tipo' => self::HISTORICO
            ];
            Log::info('requisição de historico enviada ao publisher');
            $this->publisher->publish($envio, 3);
            
            return response()->json([
                'retorno' => true,
                'mensagem' => 'requisição enviada ao publisher'
            ]);
                
        } catch (\Exception $e) {

            return response()->json([
                'retorno' => false,
                'dados' => $e->getMessage()
            ]);
            
        }
           
    }

    public function subscribeTeste() {
         $subscriber = new SubscriberTransacao();
         $subscriber->subscribe();
    }
}
