<?php

use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\TransacaoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//PARA VERIFICAR AS FILAS 

//php artisan queue:work rabbitmq --queue=fila.transacoes --verbose
//php artisan consume:transacao

// php -c dev/php.ini -S 127.0.0.1:8000 -t public

Route::prefix('transacao')->name('transacoes')->group(function() {
    Route::post('/realizar', [TransacaoController::class, 'transacao']);
    Route::get('/consultar-historico/{id}', [TransacaoController::class, 'consultarHistorico']);


    Route::post('/sub-teste', [TransacaoController::class, 'subscribeTeste']);
});

Route::prefix('cliente')->name('transacoes')->group(function() {
    
    Route::get('/exibir-conta/{id}', [ClienteController::class, 'exibirConta']);


    
});