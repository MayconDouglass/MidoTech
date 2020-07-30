<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use App\User;
use App\Perfil;
use Auth;
use Hash;

class LoginController extends Controller
{
    public function form()
    {
        if (Auth::user()){
            
            $uid= Auth::user()->id_usuario;
            $unome= Auth::user()->nome;
            $uperfil= Auth::user()->perfil_fk;
            $unomeperfil= Auth::user()->perfil->nome;

            //dd();
            $arquivo = 'storage/img/users/'.$uid.'.jpg';
            if(file_exists($arquivo)){
            $uimagem = $arquivo;
            } else {
            $uimagem = 'storage/img/users/default.jpg';
            }
            
            return view('painel.page.index',compact('uperfil','unomeperfil','unome','uid','uimagem'));
       
        }else{

            return view('login');

        }
    }

    public function Login(Request $request)
    {
        //dd(bcrypt($request->password));
        $request->validate([
            'email' => 'required',
            'senha' => 'required'
        ]);


        $lembrar = empty($request->remember) ? false : true;

        $usuario = User::where('email', $request->email)->where('ativo',1)->first();
        $statusUser = User::where('email', $request->email)->first();
        //dd($statusUser->ativo);
        //dd(bcrypt($request->senha));
            

        if ($usuario && Hash::check($request->senha, $usuario->password)) {
           
            Auth::loginUsingId($usuario->id_usuario, $lembrar);
        }
            
        if($statusUser->ativo==0){
            return redirect()->action('LoginController@form')->with('status_login_error', 'Usuário Inativo!');
        }else{
            return redirect()->action('LoginController@form')->with('status_login_error', 'Por favor, verifique os dados!');
        }
          
    }


}
