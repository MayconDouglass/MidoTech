<?php

namespace App\Http\Controllers;

use App\Models\PerfilAcesso;
use App\Models\Setempresa;
use App\Models\Setor;
use App\Models\Setunidade;
use App\Models\Tabelapreco;
use Illuminate\Http\Request;

use Auth;

class SetorController extends Controller
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

            if($roleAdmin[0] == 1){
                $setores = Setor::all();
                $empresas = Setempresa::all();
            }else{
                $setores = Setor::where('emp_cod',$uempresa)->get();
                $empresas = Setempresa::where('id_empresa',$uempresa)->get();
            }
                                 
            if ($roleView[0]  == 1){
                return view('painel.page.setores',compact('uperfil','uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil','setores','empresas'));
            }else{
                return view('painel.page.nopermission',compact('uperfil','$uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil'));
            }  

        }else{

            return view('login');

        }
    }

    public function store(Request $request){
        $setor = new Setor;
        $setor->emp_cod = $request->empresacad;
        $setor->setor = $request->setorcad;
        $setor->uf = $request->ufcad;
        $setor->ativo = $request->statuscad;
        $saveStatus = $setor->save();
      
        if($saveStatus){            
                return redirect()->action('SetorController@create')->with('status_success', 'Setor Cadastrado!');
        }else{
                return redirect()->action('SetorController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }


    }

    public function update(Request $request){
        $setor = Setor::find($request->idSetor);
        $setor->ativo = $request->statusalt;
        $saveUpdate = $setor->save();
      
        if($saveUpdate){            
                return redirect()->action('SetorController@create')->with('status_success', 'Setor Atualizado!');
        }else{
                return redirect()->action('SetorController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }
    }

    public function destroy(Request $request){
        if(empty($request->iddelete)){
        return redirect()->action('SetorController@create')->with('status_error', 'Falha!');    
        }
            $setorDel = Setor::find($request->iddelete);
            $delete=$setorDel ->delete();
            if($delete){
               return redirect()->action('SetorController@create')->with('status_success', 'Excluído!');
            }else{
            return redirect()->action('SetorController@create')->with('status_error', 'Não foi possível excluir o registro, possivelmente existem movimentação/cadastros!');    
            }
    }


}
