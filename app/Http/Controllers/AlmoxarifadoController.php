<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\ContratoArquivo;
use App\Models\ContratosEmpresa;
use App\Models\Perfil;
use App\Models\PerfilAcesso;
use App\Models\Almoxarifado;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Storage;

class AlmoxarifadoController extends Controller
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


            $almoxarifados = Almoxarifado::where('emp_cod',$uempresa)->get();

            if ($roleView[4] == 1){
                return view('painel.page.almoxarifado',compact('uperfil','uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil','almoxarifados','uempresa'));
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
