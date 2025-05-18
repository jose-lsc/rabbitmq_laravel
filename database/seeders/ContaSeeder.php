<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $database = [
           [
            'cliente_id' => 1,
            'tipo_id' => 1,
            'chave_pix' => "teste.pix",
            'saldo' => 1500,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
           ],
           [
            'cliente_id' => 1,
            'tipo_id' => 2,
            'chave_pix' => "teste2.pix",
            'saldo' => 2000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
           ],
           [
            'cliente_id' => 2,
            'tipo_id' => 1,
            'chave_pix' => "teste3.pix",
            'saldo' => 2000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
           ]
        ];

        foreach ($database as $data){
            DB::table('contas')
                ->insert([$data]);
        }
    }
}
