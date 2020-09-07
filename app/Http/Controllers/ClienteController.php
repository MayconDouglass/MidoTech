<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Modocobranca;
use App\Models\PerfilAcesso;
use App\Models\Prazopagamento;
use App\Models\Setempresa;
use App\Models\Tabelapreco;
use Illuminate\Http\Request;

use Auth;

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
            if($roleClientes = 1){
                $clientes = Cliente::all();
            }else{
                $clientes = Cliente::where('emp_cod',$uempresa)->get();   
            }

            $empresas = Setempresa::all();

                if ($roleView[0]  == 1){
                    return view('painel.page.cliente',compact('uperfil','unomeperfil','uempresa','unome','uid','uimagem','empresas','acessoPerfil','clientes'));
                }else{
                    return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','acessoPerfil'));
                }  

        }else{

            return view('login');

        }
    }

    public function addUser()
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
            $uimagem = '/storage/img/users/'.$uid.'.jpg';
            } else {
            $uimagem = '/storage/img/users/default.jpg';
            }
            
            $roleView = PerfilAcesso::where('perfil_cod',$uperfil)
                                    ->where('role',1)
                                    ->pluck('ativo');
            
            $acessoPerfil = PerfilAcesso::where('perfil_cod',$uperfil)
                                        ->select('role','ativo')->get();
            
            $roleAdmin = PerfilAcesso::where('perfil_cod',$uperfil)
                                        ->where('role',5)
                                        ->pluck('ativo');

            if($roleAdmin = 1){
                $modCobs = Modocobranca::where('ativo',1)->get();
                $tabPrecos = Tabelapreco::where('ativo',1)->where('emp_cod',$uempresa)->get();
                $prazoCobs = Prazopagamento::where('ativo',1)->get();
            }else{  
                $modCobs = Modocobranca::where('ativo',1)->get();
                $tabPrecos = Tabelapreco::where('ativo',1)->where('emp_cod',$uempresa)->get();
                $prazoCobs = Prazopagamento::where('ativo',1)->get();
            }

            $empresas = Setempresa::all();

                if ($roleView[0]  == 1){
                    return view('painel.page.Clientes.clienteadd',compact('uperfil','unomeperfil','uempresa',
                    'unome','uid','uimagem','empresas','acessoPerfil','modCobs','tabPrecos','prazoCobs'));
                }else{
                    return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','acessoPerfil'));
                }  

        }else{

            return view('login');

        }
    }
}
