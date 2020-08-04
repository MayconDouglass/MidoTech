<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\PerfilAcesso;
use Illuminate\Http\Request;
use App\Models\Setempresa;
use App\Models\Usuario;

use Auth;
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
           
            return view('painel.page.perfil',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','perfis'));
            
        }else{

            return view('login');

        }
    }


    public function store(Request $request)
    {

        $countPerfil = count(Perfil::where('nome',$request->nomecad)->where('emp_cod',$request->empcad)->get());
        if($countPerfil < 1)
        {
            $perfil = new Perfil();
            $perfil->emp_cod = $request->empcad;
            $perfil->nome = $request->nomecad;
            $perfil->ativo = $request->statuscad;
            $perfil->datacad = date('Y-m-d H:i:s');
            $perfil->usucad = Auth::user()->id_usuario;
            $saveStatus = $perfil->save();

            if($saveStatus){            
                return redirect()->action('PerfilController@create')->with('status_success', 'Perfil Cadastrado!');
            }else{
                    return redirect()->action('PerfilController@create')->with('status_error', 'OPS! Algum erro no cadastro, tente novamente!');
            }

        }else{
            return redirect()->action('PerfilController@create')->with('status_error', 'Já existe um perfil com este nome na empresa selecionada!');
        }
    }

    public function update(Request $request)
    {

            $perfil = Perfil::find($request->idPerfil);
            $perfil->ativo = $request->statusalt;
            $perfil->dataalt = date('Y-m-d H:i:s');
            $perfil->usualt = Auth::user()->id_usuario;
            $updateStatus = $perfil->save();

            if($updateStatus){            
                return redirect()->action('PerfilController@create')->with('status_success', 'Status atualizado!');
            }else{
                    return redirect()->action('PerfilController@create')->with('status_error', 'OPS! Algum erro ocorreu, tente novamente!');
            }        
    }

    public function destroy(Request $request){
        if(empty($request->iddelete)){
            return redirect()->action('PerfilController@create')->with('status_error', 'Falha!');    
            }
            $perfil = Perfil::find($request->iddelete);
            $delete=$perfil->delete();
            if($delete){   
            return redirect()->action('PerfilController@create')->with('status_success', 'Perfil Excluído!');
            }else{
            return redirect()->action('PerfilController@create')->with('status_error', 'Não foi possível excluir o perfil, possivelmente existem movimentação/cadastros!');    
            }
    }

}
