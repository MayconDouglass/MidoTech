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

Route::get('/', function () {
    return view('login');
});
Route::get('/index', function () {
    return view('painel.page.index');
});

Route::get('/index2', function () {
    return view('painel.page.exemplo');
});
Route::get('/recuperar/password', function () {
    return view('recpass');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->action('LoginController@form');
    })->name('logoutAdmin');

    });