<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\PerfilAcesso;
use App\Models\Setor;
use App\Models\Transportadora;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Storage;

class TranspController extends Controller
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
           
            $transportadoras = Transportadora::where('emp_cod',$uempresa)->get();

            $setores = Setor::where([['emp_cod',$uempresa],['ativo',1]])->get();
            
            if ($roleView[0] == 1){
                return view('painel.page.transportadora',compact('uperfil','uempresa','unomeperfil',
                                                                 'unome','uid','uimagem','acessoPerfil',
                                                                 'uempresa','transportadoras','setores'));
            }else{
                return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','acessoPerfil'));
            }  

        }else{

            return view('login');

        }
    }

    public function store(Request $request){
        $uempresa = Auth::user()->empresa;
      
        $transp = new Transportadora;
        $transp->emp_cod = $uempresa;
        $transp->razao_social = $request->razaocad;
        $transp->nome_fantasia = $request->fantasiacad;
        $transp->transp_cgc = $request->cnpjcad;
        $transp->transp_ie = $request->iecad;
        $transp->email = $request->emailcad;
        $transp->cep = $request->cepcad;
        $transp->logradouro = $request->logradourocad;
        $transp->numero = $request->numerocad;
        $transp->complemento = $request->complementocad;
        $transp->cidade = $request->cidadecad;
        $transp->bairro = $request->bairrocad;
        $transp->uf = $request->ufcad;
        $transp->ibge = $request->ibgecad;
        $transp->telefone = $request->telefonecad;
        $transp->car_modelo = $request->modelocad;
        $transp->car_placa = $request->placacad;
        $transp->car_uf = $request->ufplacacad;
        $transp->car_cidade = $request->cidadeplacacad;
        $transp->site = $request->sitecad;
        $transp->setor = $request->setorcad;
        $transp->status = $request->statuscad;
        $transp->data_cad = date('Y-m-d H:i:s');
        $saveStatus = $transp->save();
              
        if($saveStatus){   
   
            return redirect()->action('TranspController@create')->with('status_success', 'Transportadora Cadastrada!');              
                
        }else{

            return redirect()->action('TranspController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');

        }


    }

    public function update(Request $request){
 
        $transp = Transportadora::find($request->idTransp);
        $transp->razao_social = $request->razaoalt;
        $transp->nome_fantasia = $request->fantasiaalt;
        $transp->transp_cgc = $request->cnpjalt;
        $transp->transp_ie = $request->iealt;
        $transp->email = $request->emailalt;
        $transp->cep = $request->cepalt;
        $transp->logradouro = $request->logradouroalt;
        $transp->numero = $request->numeroalt;
        $transp->complemento = $request->complementoalt;
        $transp->cidade = $request->cidadealt;
        $transp->bairro = $request->bairroalt;
        $transp->uf = $request->ufalt;
        $transp->ibge = $request->ibgealt;
        $transp->telefone = $request->telefonealt;
        $transp->car_modelo = $request->modeloalt;
        $transp->car_placa = $request->placaalt;
        $transp->car_uf = $request->ufplacaalt;
        $transp->car_cidade = $request->cidadeplacaalt;
        $transp->site = $request->sitealt;
        $transp->setor = $request->setoralt;
        $transp->status = $request->statusalt;
        $transp->data_alt = date('Y-m-d H:i:s');
        $updateStatus = $transp->save();
              
        if($updateStatus){   
   
            return redirect()->action('TranspController@create')->with('status_success', 'Transportadora Atualizada!');              
                
        }else{

            return redirect()->action('TranspController@create')->with('status_error', 'OPS! Algum erro aconteceu, tente novamente!');

        }

    }

    public function destroy(Request $request){
        if(empty($request->iddelete)){
            return redirect()->action('TranspController@create')->with('status_error', 'Falha!');    
        }
                $stDel = Transportadora::find($request->iddelete);
                $delete=$stDel ->delete();
                if($delete){
                   return redirect()->action('TranspController@create')->with('status_success', 'Excluído!');
                }else{
                return redirect()->action('TranspController@create')->with('status_error', 'Não foi possível excluir o registro, possivelmente existem movimentação/cadastros!');    
                }
    }

}
