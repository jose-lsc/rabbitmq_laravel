<?php

namespace App\Services;

use App\Console\Commands\RabbitMQCreateQueue;
use App\Events\NotificaTransacaoEvent;
use App\Models\Conta;
use App\Models\Transacao;
use App\RabbitMQ\Publishers\PublisherTransacao;
use App\RabbitMQ\Subscribers\SubscriberTransacao;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransacaoService
{
    public function transacao($emissor_id, $valor, $chave_pix) {
        //DB::beginTransaction();
        try {
            $emissor = DB::table('contas')
                ->where('cliente_id', $emissor_id)
                ->first();
            
            $recebedor = DB::table('contas')
                ->select(
                    'contas.id',
                    'contas.saldo',
                    'clientes.nome',
                    'clientes.agencia'
                )
                ->join('clientes', 'clientes.id', 'contas.cliente_id')
                ->where('chave_pix', $chave_pix)
                ->first();
            
            if (!$emissor || !$recebedor) {
                
                Log::info("Conta emissora ou recebedora não encontrada");
                return false;
            }
            if($emissor->saldo < $valor){
               Log::info('Saldo insuficiente');
               return false;
            }
            
            $novoSaldoEmissor = $emissor->saldo - $valor;

            DB::table('contas')
                ->where('id', $emissor->id)
                ->update(['saldo' => $novoSaldoEmissor]);

            $novoSaldoRecebedor = $recebedor->saldo + $valor;

            DB::table('contas')
                ->where('id', $recebedor->id)
                ->update(['saldo' => $novoSaldoRecebedor]);

            
            $nomeRecebedor = $recebedor->nome;
            $agenciaRecebedor = $recebedor->agencia;
            $transacao = Transacao::create([
                'cliente_emissor_id' => $emissor->id,
                'cliente_recebedor_id' => $recebedor->id,
                'valor_transferido' => $valor,
                'descricao' => "valor de R$$valor transferido para $nomeRecebedor",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            //DB::commit();
            Log::info('Transação PIX processada com sucesso', [
                'para' => $nomeRecebedor,
                'valor' => $valor,
                'agencia' => $agenciaRecebedor
            ]);
            event(new NotificaTransacaoEvent($transacao));
            return true;
        }catch (\Exception $e) {
            //DB::rollBack();
            return $e->getMessage(). "->Line: ".$e->getLine();
        }
    }

    public function consultarHistorico($id) {
        try {
            
            $query = DB::table('transacoes')
                ->select(
                    "transacoes.*",
                    "clientes.nome",
                    "clientes.email",
                    "clientes.agencia",
                    "clientes.cpf",
                    "clientes.telefone",
                    "clientes.data_nascimento",
                )
                ->rightJoin('clientes', function($join) {
                    $join->on( "clientes.id", '=', "transacoes.cliente_emissor_id")
                        ->orOn( "clientes.id", '=', "transacoes.cliente_emissor_id");
                })
                ->where(function($query) use($id){
                    $query ->where('cliente_emissor_id', $id)
                        ->orWhere('cliente_recebedor_id', $id);
                })
                ->get();
                
            $descricoes = $query->pluck('descricao')->toArray();
            $descricoes = array_splice($descricoes, 5);
            Log::info('Histórico de transacoes', [
                "descricao" => $descricoes
            ]);

            return response()->json([
                'retorno' => true,
                'dados' => $query
            ]);
            
            
        } catch (\Exception $e) {

            return response()->json([
                'retorno' => true,
                'mensagem' => $e->getMessage()
            ]);
        }
           
    }

   
}
