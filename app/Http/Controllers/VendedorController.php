<?php

namespace App\Http\Controllers;

use App\Models\PerfilAcesso;
use App\Models\Setempresa;
use App\Models\Setor;
use App\Models\Tabelapreco;
use App\Models\Vendedor;
use Illuminate\Http\Request;

use Auth;

class VendedorController extends Controller
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
                $vendedores = Vendedor::all();
                $empresas = Setempresa::all();
                $supervisores = Vendedor::where('tipo',1)->get();
                $gerentes = Vendedor::where('tipo',2)->get();
                $setores = Setor::all();
            }else{
                $vendedores = Vendedor::where('emp_cod',$uempresa)->get();
                $empresas = Setempresa::where('id_empresa',$uempresa)->get();
                $supervisores = Vendedor::where('tipo',1)->where('emp_cod',$uempresa)->get();
                $gerentes = Vendedor::where('tipo',2)->where('emp_cod',$uempresa)->get();
                $setores = Setor::where('emp_cod',$uempresa)->get();
            }

            

                if ($roleView[0]  == 1){
                    return view('painel.page.vendedor',compact('uperfil','uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil','vendedores','empresas','supervisores','gerentes','setores'));
                }else{
                    return view('painel.page.nopermission',compact('uperfil','$uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil'));
                }  

        }else{

            return view('login');

        }
    }

    public function store(Request $request){
        $vendedor = new Vendedor;
        $vendedor->emp_cod = $request->empresacad;
        $vendedor->nome = $request->nomecad;
        $vendedor->logradouro = $request->logradourocad;
        $vendedor->complemento = $request->complementocad;
        $vendedor->numero = $request->numerocad;
        $vendedor->bairro = $request->bairrocad;
        $tabPreco->pedidoweb = $request->pedwebcad;
        $tabPreco->ativo = $request->statuscad;
        $saveStatus = $tabPreco->save();
      
        if($saveStatus){            
                return redirect()->action('VendedorController@create')->with('status_success', 'Vendedor Cadastrado!');
        }else{
                return redirect()->action('VendedorController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }


    }

    public function update(Request $request){
        $tabPreco = Tabelapreco::find($request->idTabPrecoAlt);
        $tabPreco->prevenda = $request->prevendaalt;
        $tabPreco->pedidoweb = $request->pedwebalt;
        $tabPreco->ativo = $request->statusalt;
        $saveStatus = $tabPreco->save();

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
            $tabPrecoDel = Tabelapreco::find($request->iddelete);
            $delete=$tabPrecoDel ->delete();
            if($delete){
               return redirect()->action('TabPrecoController@create')->with('status_success', 'Excluído!');
            }else{
            return redirect()->action('TabPrecoController@create')->with('status_error', 'Não foi possível excluir o registro, possivelmente existem movimentação/cadastros!');    
            }
    }

}
