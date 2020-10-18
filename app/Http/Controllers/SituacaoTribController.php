<?php

namespace App\Http\Controllers;

use App\Models\AlLocalizacao;
use App\Models\Perfil;
use App\Models\PerfilAcesso;
use App\Models\Almoxarifado;
use App\Models\Settributo;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Storage;

class SituacaoTribController extends Controller
{
    public function create()
    {
        if (Auth::user()){
            
            $uid= Auth::user()->id_usuario;
            $unome= Auth::user()->nome;
            $uperfil= Auth::user()->perfil_fk;
            $unomeperfil= Auth::user()->perfil->nome;
            $uempresa= Auth::user()->empresa;

            $statusPerfil= Perfil::find(Auth::user()->perfil_fk);
            if($statusPerfil->ativo == 0){
                Auth::logout();
            }
            
            $arquivo = 'storage/img/users/'.$uid.'.jpg';
            if(file_exists($arquivo)){
            $uimagem = $arquivo;
            } else {
            $uimagem = 'storage/img/users/default.jpg';
            }
            
            $roleView = PerfilAcesso::where('perfil_cod',$uperfil)
                                    ->pluck('ativo');
                                    

            $acessoPerfil = PerfilAcesso::where('perfil_cod',$uperfil)
                                        ->select('role','ativo')->get();
           
            $sittributarias = Settributo::where('emp_cod',$uempresa)->get();

            if ($roleView[0] == 1){
                return view('painel.page.situacaotrib',compact('uperfil','uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil','uempresa','sittributarias'));
            }else{
                return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','acessoPerfil'));
            }  

        }else{

            return view('login');

        }
    }

    public function store(Request $request){
        $uempresa = Auth::user()->empresa;
      
        $almoxarifado = new Almoxarifado;
        $almoxarifado->emp_cod = $uempresa;
        $almoxarifado->codigo = $request->codigocad;
        $almoxarifado->descricao = $request->descricaocad;
        $almoxarifado->tipo = $request->tipocad;
        $almoxarifado->status = $request->statuscad;
        $almoxarifado->qtd_estatistica = $request->qtdcad;
       
        $saveStatus = $almoxarifado->save();
              
        if($saveStatus){   
   
            return redirect()->action('AlmoxarifadoController@create')->with('status_success', 'Almoxarifado Cadastrado!');              
                
        }else{

            return redirect()->action('AlmoxarifadoController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');

        }


    }

    public function storeLocal(Request $request){
      
        $localizacao = new AlLocalizacao;
        $localizacao->al_cod = $request->idAlmo;
        $localizacao->localiza_fisica = $request->locfisica;
        $localizacao->ean = $request->ean;
        $localizacao->tipo = $request->tipo;
        $localizacao->capacidade = $request->capacidade;
        $localizacao->status = $request->status;
        $localizacao->data_cad = date('Y-m-d H:i:s');
       
        $saveStatus = $localizacao->save();
              
        if($saveStatus){   
   
            return redirect()->action('AlmoxarifadoController@create')->with('status_success', 'Localização Cadastrada!');              
                
        }else{

            return redirect()->action('AlmoxarifadoController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');

        }


    }

    public function update(Request $request){
 
        $almoxarifado = Almoxarifado::find($request->idAlmo);
        $almoxarifado->tipo = $request->tipoalt;
        $almoxarifado->status = $request->statusalt;
        $almoxarifado->qtd_estatistica = $request->qtdalt;
       
        $updateStatus = $almoxarifado->save();
              
        if($updateStatus){   
                  
                return redirect()->action('AlmoxarifadoController@create')->with('status_success', 'Almoxarifado Atualizado!');              

        }else{

                return redirect()->action('AlmoxarifadoController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }


    }

    public function destroy(Request $request){
       
            if(empty($request->iddelete)){
                return redirect()->action('AlmoxarifadoController@create')->with('status_error', 'Falha!');    
            }
                $almoxarifado = Almoxarifado::find($request->iddelete);
                $delete=$almoxarifado->delete();
                
                if($delete){
                    return redirect()->action('AlmoxarifadoController@create')->with('status_success', 'Almoxarifado excluído!');
                }else{
                    return redirect()->action('AlmoxarifadoController@create')->with('status_error', 'Não foi possível excluir o registro, possivelmente existem movimentação/cadastros!');    
                }

    }

}
