<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;
    protected $table = 'transacoes';

    protected $fillable = [
        'cliente_emissor_id',
        'cliente_recebedor_id',
        'valor_transferido',
        'descricao',
    ];

    public function emissor(){
        return $this->belongsTo(Cliente::class, 'cliente_emissor_id');
    }

    public function recebedor(){
        return $this->belongsTo(Cliente::class, 'cliente_recebedor_id');
    }
}
