<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', 'LoginController@form')->name('login');
Route::post('/login', 'LoginController@Login');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->action('LoginController@form');
    })->name('logout');
  
    //CRUD Empresa
    Route::get('/empresa', 'EmpresaController@create')->name('empresas');
    Route::post('/empresa/cad', 'EmpresaController@store');
    Route::post('/empresa/update', 'EmpresaController@update');
    Route::post('/empresa/delete', 'EmpresaController@destroy');

    //CRUD Users
    Route::get('/usuario', 'UsuarioController@create')->name('usuarios');
    Route::post('/usuario/cad', 'UsuarioController@store');
    Route::post('/usuario/update', 'UsuarioController@update');
    Route::post('/usuario/delete', 'UsuarioController@destroy');
    Route::post('/usuario/resetpassword', 'UsuarioController@resetPassword');

     //CRUD Perfil
     Route::get('/perfil', 'PerfilController@create')->name('perfis');
     Route::post('/perfil/cad', 'PerfilController@store');
     Route::post('/perfil/update', 'PerfilController@update');
     Route::post('/perfil/delete', 'PerfilController@destroy'); 
     Route::post('/perfil/permissao', 'PerfilController@atualizarPermissao'); 
     Route::post('/perfil/obterperm', 'PerfilController@obterPermissaoPerfil'); 

     // Modo de Cobranca
     Route::get('/modocobranca', 'ModCobController@create')->name('modoCob');
     Route::post('/modocobranca/cad', 'ModCobController@store');
     Route::post('/modocobranca/update', 'ModCobController@update');
     Route::post('/modocobranca/delete', 'ModCobController@destroy');

     // Prazo de Pagamento
     Route::get('/prazopagamento', 'PrazoController@create')->name('prazoPag');
     Route::post('/prazopagamento/cad', 'PrazoController@store');
     Route::post('/prazopagamento/cads', 'PrazoController@storeParcelas');
     Route::post('/prazopagamento/update', 'PrazoController@update');
     Route::post('/prazopagamento/delete', 'PrazoController@destroy');
     Route::post('/prazopagamento/obterparcelas', 'PrazoController@obterParcelas'); 

     // Tabela de Preco
     Route::get('/tabpreco', 'TabPrecoController@create')->name('tabPreco');
     Route::post('/tabpreco/cad', 'TabPrecoController@store');
     Route::post('/tabpreco/update', 'TabPrecoController@update');
     Route::post('/tabpreco/delete', 'TabPrecoController@destroy');

    // Tabela de Unidade
    Route::get('/unidades', 'UnidadesController@create')->name('unidade');
    Route::post('/unidades/cad', 'UnidadesController@store');

    // Cliente
    Route::get('/clientes', 'ClienteController@create')->name('clientes');
    Route::get('/clientes/new', 'ClienteController@addUser')->name('adduser');
    Route::post('/clientes', 'ClienteController@store');
    Route::get('/clientes/teste', 'ClienteController@teste');
    
    // Vendedor
    Route::get('/vendedores', 'VendedorController@create')->name('vendedores');
    Route::post('/vendedores/cad', 'VendedorController@store');
    Route::post('/vendedores/update', 'VendedorController@update');
    Route::post('/vendedores/delete', 'VendedorController@destroy');
    Route::post('/vendedores/ModCob', 'VendedorController@obterModCobVen');
    Route::post('/vendedores/PrazoPag', 'VendedorController@obterPrazoPagVen');
    Route::post('/vendedores/TabPreco', 'VendedorController@obterTabPrecoVen');
    Route::post('/vendedores/resetPassword', 'VendedorController@resetPassword');

    // Setor
    Route::get('/setores', 'SetorController@create')->name('setores');
    Route::post('/setores/cad', 'SetorController@store');
    Route::post('/setores/update', 'SetorController@update');
    Route::post('/setores/delete', 'SetorController@destroy');

});

