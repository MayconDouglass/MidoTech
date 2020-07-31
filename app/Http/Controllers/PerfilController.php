<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerfilController extends Controller
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
            
            $perfis = Perfil::where('ativo',1)->get();

            $empresas = Setempresa::all();
           
            $usuarios = Usuario::all();

            return view('painel.page.perfil',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','perfis'));
            
        }else{

            return view('login');

        }
}
