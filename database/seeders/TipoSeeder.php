<?php

namespace Database\Seeders;

use App\Models\TipoConta;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
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
            'nome' => 'corrente',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'nome' => 'poupança',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]
        ];
        foreach ($database as $data){
            DB::table('tipo_contas')
                ->insert([$data]);
        }
    }
}
