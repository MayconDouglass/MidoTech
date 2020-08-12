<?php

namespace App\Http\Controllers;

use App\Models\Modocobranca;
use App\Models\PerfilAcesso;
use App\Models\Situacaomodcob;
use Auth;

class ModCobController extends Controller
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
            $roleView = PerfilAcesso::where('perfil_cod',$uperfil)
                                    ->where('role',1)
                                    ->pluck('ativo');
                                    
            $acessoPerfil = PerfilAcesso::where('perfil_cod',$uperfil)
                                        ->select('role','ativo')->get();

            $modoCobs = Modocobranca::all();
            $situacoesCob = Situacaomodcob::all();

                if ($roleView[0]  == 1){
                    return view('painel.page.modocob',compact('uperfil','unomeperfil','unome','uid','uimagem','acessoPerfil','situacoesCob','modoCobs'));
                }else{
                    return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','acessoPerfil'));
                }  

        }else{

            return view('login');

        }
    }

}
