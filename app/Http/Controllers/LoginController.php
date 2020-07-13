<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use App\User;
use Auth;
use Hash;

class LoginController extends Controller
{
    public function form()
    {
        if (Auth::user()){
            
            $uid= Auth::user()->id_usuario;
            $unome= Auth::user()->nome;
            $uperfilnome= Auth::user()->perfil->nome;
            $uperfil= Auth::user()->perfil_fk;

           
            //dd($totalFunc);
            $arquivo = 'storage/img/users/'.$uid.'.jpg';
            if(file_exists($arquivo)){
            $uimagem = $arquivo;
            } else {
            $uimagem = 'storage/img/users/default.jpg';
            }

            return view('painel.index',compact('totalAlunos','totalEscolas','totalFunc','totalViacoes','uperfil','uperfilnome','unome','uid','uimagem'));
       
        }else{

            return view('login');

        }
    }

    public function Login(Request $request)
    {
        //dd(bcrypt($request->password));

        $request->validate([
            'login' => 'required',
            'senha' => 'required'
        ]);


        $lembrar = empty($request->remember) ? false : true;

        $usuario = User::where('login', $request->login)->where('ativo',1)->first();
        //dd(bcrypt($request->senha));
            //dd($usuario);

        if ($usuario && Hash::check($request->senha, $usuario->password)) {
            
            Auth::loginUsingId($usuario->id_usuario, $lembrar);
        }
        
        return redirect()->action('LoginController@form')->with('status_login_error', 'Por favor, verifique os dados!');
    }


}
