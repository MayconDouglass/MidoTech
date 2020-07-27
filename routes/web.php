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
    })->name('logoutAdmin');
  
    //CRUD Empresa
    Route::get('/empresa', 'EmpresaController@create')->name('empresas');
    Route::post('/empresa/cad', 'EmpresaController@store');
    Route::post('/empresa/update', 'EmpresaController@update');
    Route::post('/empresa/delete', 'EmpresaController@destroy');

    //CRUD Users
    Route::get('/usuario', 'UsuarioController@create')->name('usuarios');
 

});

