<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function exibirConta($id) {
        $query = DB::table('contas')
            ->select(
                'contas.*',
                'clientes.nome',

            )
            ->join('clientes', 'clientes.id', '=', 'contas.cliente_id')
            ->where('cliente_id',$id)
            ->get();

        return $query;
    }
}
