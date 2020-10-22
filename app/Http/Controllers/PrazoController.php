<?php

namespace App\Http\Controllers;

use App\Models\ParcelaPrazo;
use App\Models\Perfil;
use App\Models\PerfilAcesso;
use App\Models\Prazopagamento;

use Illuminate\Http\Request;

use Auth;

class PrazoController extends Controller
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

            $prazoPagamentos = Prazopagamento::where('emp_cod',$uempresa)->get(); 

                if ($roleView[0]  == 1){
                    return view('painel.page.prazopag',compact('uperfil','unomeperfil','unome','uid','uimagem','acessoPerfil','prazoPagamentos'));
                }else{
                    return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','acessoPerfil'));
                }  

        }else{

            return view('login');

        }
    }

    public function store(Request $request){
        $uempresa= Auth::user()->empresa;
        
        if($request->tipocad == 0){
            $qtdParcelas = 1;
        }else{
            $qtdParcelas = $request->parcelascad; 
        }
        
        $prazoPag = new Prazopagamento;
        $prazoPag->emp_cod = $uempresa;
        $prazoPag->descricao = $request->descricaocad;
        $prazoPag->taxa_diario = $request->taxajuroscad;
        $prazoPag->multa_atraso = $request->multacad;
        $prazoPag->acrescimo_financeiro = $request->acrescimocad;
        $prazoPag->desc_prazo = $request->descontocad;
        $prazoPag->tipo_prazo = $request->tipocad;
        $prazoPag->num_parcelas = $qtdParcelas;
        $prazoPag->intervalodias = $request->diascad;
        $prazoPag->ativo = $request->statuscad;
        $saveStatus = $prazoPag->save();

        foreach (range(1,$qtdParcelas) as $parc => $parcela) {
            $diasParcela = $request->diascad * $parcela;
            $parcelaPrazo = new ParcelaPrazo();
            $parcelaPrazo->prazopag = $prazoPag->id_prazo;
            $parcelaPrazo->parcela = $parcela;
            if($parcela == $request->parcelascad){
                $parcelaPrazo->porcentagem = (round(100-(round(100/($qtdParcelas),3)*($qtdParcelas-1)),3)); 
            }else{
                $parcelaPrazo->porcentagem = round((100/$qtdParcelas),3);
            }
            $parcelaPrazo->prazo = $diasParcela;
            $parcelaPrazo->tipo = 1;
           
            $parcelaPrazo->save();
        }

        if($saveStatus){  
            
                return redirect()->action('PrazoController@create')->with('status_success', 'Prazo de pagamento cadastrado!');
        }else{
                return redirect()->action('PrazoController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }


    }

    public function update(Request $request){
        $prazoPag = Prazopagamento::find($request->idPrazoAlt);
        $prazoPag->taxa_diario = $request->taxajurosAlt;
        $prazoPag->multa_atraso = $request->multaAlt;
        $prazoPag->acrescimo_financeiro = $request->acrescimoAlt;
        $prazoPag->desc_prazo = $request->descontoAlt;
        $prazoPag->ativo = $request->statusAlt;
        $saveStatus = $prazoPag->save();

        if($saveStatus){            
                return redirect()->action('PrazoController@create')->with('status_success', 'Prazo Atualizado!');
        }else{
                return redirect()->action('PrazoController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }


    }

    public function destroy(Request $request){
        if(empty($request->iddelete)){
        return redirect()->action('PrazoController@create')->with('status_error', 'Falha!');    
        }
            $prazoDel = Prazopagamento::find($request->iddelete);
            $delete= $prazoDel->delete();
            if($delete){
               return redirect()->action('PrazoController@create')->with('status_success', 'Excluído!');
            }else{
            return redirect()->action('PrazoController@create')->with('status_error', 'Não foi possível excluir o registro, possivelmente existem movimentação/cadastros!');    
            }
    }

    public function obterParcelas(Request $request){
        
        $parcelas = ParcelaPrazo::where('prazopag',$request->id)->get();
        return response()->json([$parcelas],200);

    }

    public function storeParcelas(Request $request){
        foreach (range(1,$request->parcelascad) as $parc => $parcela) {
            $parcelaPrazo = new ParcelaPrazo();
            $parcelaPrazo->prazopag = 1;
            $parcelaPrazo->parcela = $parcela;
            $parcelaPrazo->porcentagem = round((100/$request->parcelascad),0);
            $parcelaPrazo->prazo = $request->intervalocad.$parcela;
            $parcelaPrazo->tipo = 1;
           
            $saveStatus= $parcelaPrazo->save();
            if($saveStatus){  
            
                return redirect()->action('PrazoController@create')->with('status_success', 'Modo de Cobrança Cadastrada!');
        }else{
                return redirect()->action('PrazoController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }
        }
    }
}
