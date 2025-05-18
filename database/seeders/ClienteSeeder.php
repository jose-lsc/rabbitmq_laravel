<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $database = [[
            'nome' => "Jose",
            'email' => "teste@gmail.com",
            'senha' => "123",
            'cpf' => "12345678910",
            'agencia' => "Banco Brasil",
            'telefone' => "(14)991067232",
            'data_nascimento' => "2002-01-01",
            'cep' => "17521388",
            'ativo' => "1",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'nome' => "Joao",
            'email' => "teste2@gmail.com",
            'senha' => "123",
            'cpf' => "12345678911",
            'agencia' => "Banco Santander",
            'telefone' => "(14)991067232",
            'data_nascimento' => "1992-06-15",
            'cep' => "17521388",
            'ativo' => "1",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'nome' => "Silvia",
            'email' => "teste3@gmail.com",
            'senha' => "123",
            'cpf' => "12345678912",
            'agencia' => "Banco Brasil",
            'telefone' => "(14)991067232",
            'data_nascimento' => "2002-01-01",
            'cep' => "17521388",
            'ativo' => "0",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]];
        
        foreach($database as $data){
            DB::table('clientes')
                ->insert([$data]);
        }
    }
}
