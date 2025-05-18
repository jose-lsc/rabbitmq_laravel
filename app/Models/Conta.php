<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'tipo_id',
        'chave_pix',
        'saldo'
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function tipo(){
        return $this->belongsTo(TipoConta::class);
    }

    
}