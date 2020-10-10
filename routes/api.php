<?php
//Adicionar erros e mensagem na app/exceptions/handler

use Illuminate\Http\Request;

Route::group(['middleware' => ['api']], function () {
    Route::apiResource('clientes','api\ClientesApi');
    Route::apiResource('climov','api\ClienteMovApi');
    Route::apiResource('contratos', 'api\ContratosApi');
    Route::apiResource('almoxarifado', 'api\AlmoxarifadoApi');
});
