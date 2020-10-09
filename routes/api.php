<?php
//Adicionar erros e mensagem na app/exceptions/handler

Route::group(['middleware' => ['auth']], function () {
    Route::apiResource('clientes','api\ClientesApi');
    Route::apiResource('climov','api\ClienteMovApi');
    Route::apiResource('fileContrato', 'api\\ArquivosApi@destroy');
});