<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'cpf',
        'agencia',
        'telefone',
        'data_nascimento',
        'cep',
        'ativo'
    ];

    public function contas(){
        return $this->hasMany(Conta::class);
    }

    public function transacoesEnviadas(){
        return $this->hasMany(Transacao::class, 'cliente_emissor_id');
    }

    public function transacoesRecebidas(){
        return $this->hasMany(Transacao::class, 'cliente_recebedor_id');
    }

    public function notificacoes(){
        return $this->hasMany(Notificacao::class, 'cliente_id');
    }
}
