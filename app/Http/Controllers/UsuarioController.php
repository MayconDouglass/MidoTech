<?php

namespace App\Http\Controllers;

use App\Models\PerfilAcesso;
use Illuminate\Http\Request;
use App\Models\Setempresa;
use App\Models\Usuario;
use Auth;
use Hash;

class UsuarioController extends Controller
{
    public function create()
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
            

            $empresas = Setempresa::all();
           
            $usuarios = Usuario::all();

            return view('painel.page.usuario',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','usuarios'));
            
        }else{

            return view('login');

        }
    }

}
