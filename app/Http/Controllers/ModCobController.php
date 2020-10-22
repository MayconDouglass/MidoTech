<?php

namespace App\Http\Controllers;

use App\Models\Modocobranca;
use App\Models\Natoperacao;
use App\Models\Perfil;
use App\Models\PerfilAcesso;
use App\Models\Situacaomodcob;

use Illuminate\Http\Request;

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
            $uempresa= Auth::user()->empresa;

            
            $statusPerfil= Perfil::find($uperfil);
            if($statusPerfil->ativo == 0){
                Auth::logout();
            }
            
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

            $modoCobs = Modocobranca::where('emp_cod',$uempresa)->get();
            $situacoesCob = Situacaomodcob::all();
            $natOperacoes = Natoperacao::where([['ativo',1],['emp_cod',$uempresa]])->get();

                if ($roleView[0]  == 1){
                    return view('painel.page.modocob',compact('uperfil','unomeperfil','unome','uid','uimagem','acessoPerfil','situacoesCob','modoCobs','natOperacoes'));
                }else{
                    return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','acessoPerfil'));
                }  

        }else{

            return view('login');

        }
    }

    public function store(Request $request){
        $uempresa= Auth::user()->empresa;
        $modCob = new Modocobranca;
        $modCob->emp_cod = $uempresa;
        $modCob->descricao = $request->descricaocad;
        $modCob->situacao = $request->situacaocad;
        $modCob->observacao = $request->obscad;
        $modCob->natureza = $request->naturezacad;
        $modCob->lib_credito = $request->liberacaocad;
        $modCob->pag_nfe = $request->formacad;
        $modCob->ativo = $request->statuscad;
        $modCob->dataCad = date('Y-m-d H:i:s');
        $modCob->usuCad = Auth::user()->id_usuario;
        $saveStatus = $modCob->save();

        if($saveStatus){            
                return redirect()->action('ModCobController@create')->with('status_success', 'Modo de Cobrança Cadastrada!');
        }else{
                return redirect()->action('ModCobController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }


    }

    public function update(Request $request){
        //dd($request->all());
        $modCobAlt = Modocobranca::find($request->idModCob);
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
                return redirect()->action('ModCobController@create')->with('status_success', 'Modo de Cobrança Atualizado!');
        }else{
                return redirect()->action('ModCobController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }


    }

    public function destroy(Request $request){
        if(empty($request->iddelete)){
        return redirect()->action('ModCobController@create')->with('status_error', 'Falha!');    
        }
            $modCobDel = Modocobranca::find($request->iddelete);
            $delete=$modCobDel ->delete();
            if($delete){
               return redirect()->action('ModCobController@create')->with('status_success', 'Excluído!');
            }else{
            return redirect()->action('ModCobController@create')->with('status_error', 'Não foi possível excluir o registro, possivelmente existem movimentação/cadastros!');    
            }
    }

}
