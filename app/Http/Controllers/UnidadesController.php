<?php

namespace App\Http\Controllers;

use App\Models\PerfilAcesso;
use App\Models\Setempresa;
use App\Models\Setunidade;
use App\Models\Tabelapreco;
use Illuminate\Http\Request;

use Auth;

class UnidadesController extends Controller
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

            $roleAdmin = PerfilAcesso::where('perfil_cod',$uperfil)
                                    ->where('role',5)
                                    ->pluck('ativo');
                                    
            $acessoPerfil = PerfilAcesso::where('perfil_cod',$uperfil)
                                        ->select('role','ativo')->get();

            $unidades = Setunidade::all();
                                 
            if ($roleView[0]  == 1){
                return view('painel.page.unidades',compact('uperfil','uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil','unidades'));
            }else{
                return view('painel.page.nopermission',compact('uperfil','$uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil'));
            }  

        }else{

            return view('login');

        }
    }

    public function store(Request $request){
        $unidade = new Setunidade;
        $unidade->descricao = $request->descricaocad;
        $unidade->ativo = $request->statuscad;
        $saveStatus = $unidade->save();
      
        if($saveStatus){            
                return redirect()->action('UnidadesController@create')->with('status_success', 'Unidade Cadastrada!');
        }else{
                return redirect()->action('UnidadesController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }


    }


}
