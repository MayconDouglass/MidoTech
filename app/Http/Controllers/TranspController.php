<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\PerfilAcesso;
use App\Models\Settributo;
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
           
            $transportadoras = Settributo::where('emp_cod',$uempresa)->get();

            if ($roleView[0] == 1){
                return view('painel.page.transportadora',compact('uperfil','uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil','uempresa','sittributarias'));
            }else{
                return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','acessoPerfil'));
            }  

        }else{

            return view('login');

        }
    }

    public function store(Request $request){
        $uempresa = Auth::user()->empresa;
      
        $st = new Settributo;
        $st->emp_cod = $uempresa;
        $st->codigo = $request->codigocad;
        $st->descricao = $request->descricaocad;
        $st->tipo = $request->tipocad;
        $st->trib_cst = $request->cstcad;
        $st->trib_origem = $request->origemcad;
        $st->mod_icms = $request->mod_icmscad;
        $st->mod_icms_st = $request->mod_icms_stcad;
        $st->mot_desoneracao = $request->mot_desoneracaocad;
        $st->aliq_mva = $request->mvacad;
        $st->aliq_mva_simples = $request->mva_simplescad;
        $st->aliq_icms = $request->aliq_icmscad;
        $st->aliq_icms_interno = $request->aliq_icms_ufcad;
        $st->aliq_icms_st = $request->aliq_icms_stcad;
        $st->aliq_red_icms = $request->aliq_red_icmscad;
        $st->aliq_red_icms_st = $request->aliq_red_icms_stcad;
        $st->aliq_simples = $request->aliq_simplescad;
        $st->trib_csosn = $request->csosncad;
        $st->aliq_fecp = $request->aliq_fecpcad;
        $st->tipo_riolog = $request->riologcad;
        $st->benef_fiscal = $request->beneficiocad;
        $st->aliq_diferimento = $request->aliq_diferimentocad;
        $st->aliq_red_unitario = $request->aliq_red_unitariocad;
        $st->ativo = $request->statuscad;
       
        $saveStatus = $st->save();
              
        if($saveStatus){   
   
            return redirect()->action('SituacaoTribController@create')->with('status_success', 'Situacao Tributária Cadastrada!');              
                
        }else{

            return redirect()->action('SituacaoTribController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');

        }


    }

    public function update(Request $request){
 
        $st = Settributo::find($request->idST);
        $st->descricao = $request->descricaoalt;
        $st->tipo = $request->tipoalt;
        $st->trib_cst = $request->cstalt;
        $st->trib_origem = $request->origemalt;
        $st->mod_icms = $request->mod_icmsalt;
        $st->mod_icms_st = $request->mod_icms_stalt;
        $st->mot_desoneracao = $request->mot_desoneracaoalt;
        $st->aliq_mva = $request->mvaalt;
        $st->aliq_mva_simples = $request->mva_simplesalt;
        $st->aliq_icms = $request->aliq_icmsalt;
        $st->aliq_icms_interno = $request->aliq_icms_ufalt;
        $st->aliq_icms_st = $request->aliq_icms_stalt;
        $st->aliq_red_icms = $request->aliq_red_icmsalt;
        $st->aliq_red_icms_st = $request->aliq_red_icms_stalt;
        $st->aliq_simples = $request->aliq_simplesalt;
        $st->trib_csosn = $request->csosnalt;
        $st->aliq_fecp = $request->aliq_fecpalt;
        $st->tipo_riolog = $request->riologalt;
        $st->benef_fiscal = $request->beneficioalt;
        $st->aliq_diferimento = $request->aliq_diferimentoalt;
        $st->aliq_red_unitario = $request->aliq_red_unitarioalt;
        $st->ativo = $request->statusalt;
       
        $updateStatus = $st->save();
              
        if($updateStatus){   
                  
                return redirect()->action('SituacaoTribController@create')->with('status_success', 'Almoxarifado Atualizado!');              

        }else{

                return redirect()->action('SituacaoTribController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }


    }

    public function destroy(Request $request){
        if(empty($request->iddelete)){
            return redirect()->action('SituacaoTribController@create')->with('status_error', 'Falha!');    
        }
                $stDel = Settributo::find($request->iddelete);
                $delete=$stDel ->delete();
                if($delete){
                   return redirect()->action('SituacaoTribController@create')->with('status_success', 'Excluído!');
                }else{
                return redirect()->action('SituacaoTribController@create')->with('status_error', 'Não foi possível excluir o registro, possivelmente existem movimentação/cadastros!');    
                }
    }

}
