<?php

namespace App\Http\Controllers;

use App\Models\PerfilAcesso;
use App\Models\Setempresa;
use App\Models\Tabelapreco;
use Illuminate\Http\Request;

use Auth;

class TabPrecoController extends Controller
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

                     
            if($roleAdmin[0] == 1){
                $tabPrecos = Tabelapreco::all();
                $empresas = Setempresa::all();
            }else{
                $tabPrecos = Tabelapreco::where('emp_cod',$uempresa)->get();
                $empresas = Setempresa::where('id_empresa',$uempresa)->get();
            }

            

                if ($roleView[0]  == 1){
                    return view('painel.page.tabpreco',compact('uperfil','uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil','tabPrecos','empresas'));
                }else{
                    return view('painel.page.nopermission',compact('uperfil','$uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil'));
                }  

        }else{

            return view('login');

        }
    }

    public function store(Request $request){

      
        if('a'){            
                return redirect()->action('TabPrecoController@create')->with('status_success', 'Tabela de Preço Cadastrada!');
        }else{
                return redirect()->action('TabPrecoController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }


    }

    public function update(Request $request){
        //dd($request->all());
        $modCobAlt = Modocobranca::find($request->idTabPreco);
        $modCobAlt->situacao = $request->situacaoalt;
        $modCobAlt->observacao = $request->obsalt;
        $modCobAlt->natureza = $request->naturezaalt;
        $modCobAlt->lib_credito = $request->liberacaoalt;
        $modCobAlt->pag_nfe = $request->formaalt;
        $modCobAlt->ativo = $request->statusalt;
        $modCobAlt->dataAlt = date('Y-m-d H:i:s');
        $modCobAlt->usuAlt = Auth::user()->id_usuario;
        
        $saveStatus = $modCobAlt->save();

        if($saveStatus){            
                return redirect()->action('TabPrecoController@create')->with('status_success', 'Tabela de Preço Atualizada!');
        }else{
                return redirect()->action('TabPrecoController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }


    }

    public function destroy(Request $request){
        if(empty($request->iddelete)){
        return redirect()->action('TabPrecoController@create')->with('status_error', 'Falha!');    
        }
            $modCobDel = Modocobranca::find($request->iddelete);
            $delete=$modCobDel ->delete();
            if($delete){
               return redirect()->action('TabPrecoController@create')->with('status_success', 'Excluído!');
            }else{
            return redirect()->action('TabPrecoController@create')->with('status_error', 'Não foi possível excluir o registro, possivelmente existem movimentação/cadastros!');    
            }
    }

}
