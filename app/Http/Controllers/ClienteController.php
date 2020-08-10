<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\PerfilAcesso;
use App\Models\Setempresa;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function create()
    {
        if (Auth::user()){
            
            $uid= Auth::user()->id_usuario;
            $unome= Auth::user()->nome;
            $uperfil= Auth::user()->perfil_fk;
            $unomeperfil= Auth::user()->perfil->nome;
            $uempresa= Auth::user()->empresa;

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
            
            $roleClientes = PerfilAcesso::where('perfil_cod',$uperfil)
                                        ->where('role',5)
                                        ->pluck('ativo');
            if($roleClientes == 1){
                $clientes = Cliente::all();
            }else{
                $clientes = Cliente::where('emp_cod',$uempresa)->get();   
            }

            $empresas = Setempresa::all();

                if ($roleView[0]  == 1){
                    return view('painel.page.cliente',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','acessoPerfil'));
                }else{
                    return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','acessoPerfil'));
                }  

        }else{

            return view('login');

        }
    }
}
