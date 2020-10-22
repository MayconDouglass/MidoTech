<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\ContratoArquivo;
use App\Models\ContratosEmpresa;
use App\Models\Perfil;
use App\Models\PerfilAcesso;
use App\Models\Setunidade;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Storage;

class ContratoController extends Controller
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

           // $contratos = json_decode(Contrato::with('contratos_empresas')->get(),true);
            $contratos = json_decode(ContratosEmpresa::with(['contrato','setempresa'])->where('emp_cod',$uempresa)->get(),true);
            

            if ($roleView[4] == 1){
                return view('painel.page.contratos',compact('uperfil','uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil','contratos','uempresa'));
            }else{
                return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','acessoPerfil'));
            }  

        }else{

            return view('login');

        }
    }

    public function store(Request $request){
        $uempresa= Auth::user()->empresa;
        $ctEspecial = array('.','/','-');
        $proposta = str_shuffle(str_replace($ctEspecial, '', $request->cgccad.$uempresa));
        $contFiles = $request->file('arquivoCad');
        $contrato = new Contrato;
        $contrato->razao_social = $request->razaocad;
        $contrato->cli_cod = $request->idCliente ? $request->idCliente : 1;
        $contrato->proposta = $proposta;
        $contrato->pessoa = $request->pessoacad;
        $contrato->cgc = str_replace($ctEspecial, '', $request->cgccad);
        $contrato->status = $request->statuscad;
        $contrato->valor = $request->valorcad;
        $contrato->desconto = $request->descontocad;
        $contrato->data_cad = date('Y-m-d H:i:s');
        $contrato->basico = $request->basico_cad ? '1' : '0';
        $contrato->nfs = $request->nfs_cad ? '1' : '0';
        $contrato->nfe = $request->nfe_cad ? '1' : '0';
        $contrato->nfce = $request->nfce_cad ? '1' : '0';
        $contrato->cfe_sat = $request->cfesat_cad ? '1' : '0';
        $contrato->mfe = $request->mfe_cad ? '1' : '0';
        $contrato->mde = $request->mde_cad ? '1' : '0';
        $contrato->mdfe = $request->mdfe_cad ? '1' : '0';
        $contrato->cte = $request->cte_cad ? '1' : '0';
        $contrato->contratos = $request->contrato_cad ? '1' : '0';
        $contrato->servicos = $request->servico_cad ? '1' : '0';
        $saveStatus = $contrato->save();
              
        if($saveStatus){   

                $contEmpresa = new ContratosEmpresa;
                $contEmpresa->emp_cod = $uempresa;
                $contEmpresa->contrato = $contrato->id_contrato;
                $saveConEmp = $contEmpresa->save();
                if($contFiles != null){
                    foreach ($contFiles as $key => $contFile) {
                        $arquivo = new ContratoArquivo;
                        $arquivo->contrato = $contrato->id_contrato;
                        $arquivo->path = $contFile->store('contratos','public');
                        $arquivo->save();
                    }
                }

                if($saveConEmp){
                    return redirect()->action('ContratoController@create')->with('status_success', 'Contrato Cadastrado!');
                }else{
                    return redirect()->action('ContratoController@create')->with('status_error', 'Erro I/O - Contratos. Entre em contato com o suporte.');
                }            
                
        }else{
                return redirect()->action('ContratoController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }


    }

    public function update(Request $request){
        $contFiles = $request->file('arquivoAlt');
 
        $contrato = Contrato::find($request->idContrato);
        $contrato->valor = $request->valoralt;
        $contrato->desconto = $request->descontoalt;
        $contrato->data_alt = date('Y-m-d H:i:s');
        $contrato->basico = $request->basico_alt ? '1' : '0';
        $contrato->nfs = $request->nfs_alt ? '1' : '0';
        $contrato->nfe = $request->nfe_alt ? '1' : '0';
        $contrato->nfce = $request->nfce_alt ? '1' : '0';
        $contrato->cfe_sat = $request->cfesat_alt ? '1' : '0';
        $contrato->mfe = $request->mfe_alt ? '1' : '0';
        $contrato->mde = $request->mde_alt ? '1' : '0';
        $contrato->mdfe = $request->mdfe_alt ? '1' : '0';
        $contrato->cte = $request->cte_alt ? '1' : '0';
        $contrato->contratos = $request->contrato_alt ? '1' : '0';
        $contrato->servicos = $request->servico_alt ? '1' : '0';
        $updateStatus = $contrato->save();
              
        if($updateStatus){   

                if($contFiles != null){
                    foreach ($contFiles as $key => $contFile) {
                        $arquivo = new ContratoArquivo;
                        $arquivo->contrato = $request->idContrato;
                        $arquivo->path = $contFile->store('contratos','public');
                        $arquivo->save();
                    }
                }
                  
                return redirect()->action('ContratoController@create')->with('status_success', 'Contrato Atualizado!');              
        }else{
                return redirect()->action('ContratoController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }


    }

    public function codCliente($emp,$cgc){
        $cliente = Cliente::where('emp_cod',$emp)
                          ->where('cpf_cnpj',$cgc)
                          ->first();
            if(!$cliente)
                return response()->json(['code'=>'404','erro'=>'Não encontrado'], 404);

        return response()->json($cliente, 200);
    }

    public function contrato($id){
        $contrato = Contrato::where('id_contrato',$id)
                          ->with(['contrato_arquivos','cliente'])
                          ->first();
            if(!$contrato)
                return response()->json(['code'=>'404','erro'=>'Não encontrado'], 404);

        return response()->json($contrato, 200);
    }

    public function deleteFile(Request $request){
        $arrayPath = explode(',',$request->fileDel);
   
        $contrato = ContratoArquivo::whereIn('path',$arrayPath)->get();
        $statusDel = $contrato->each->delete();
        if($statusDel){
            Storage::delete($arrayPath);
            return redirect()->action('ContratoController@create')->with('status_success', 'Arquivo excluído!');              
        }else{
                return redirect()->action('ContratoController@create')->with('status_error', 'OPS! Algo aconteceu, tente novamente!');
        }

    }

    public function destroy(Request $request){
       
            if(empty($request->iddelete)){
                return redirect()->action('ContratoController@create')->with('status_error', 'Falha!');    
            }
                $arrayPath = json_decode(ContratoArquivo::where('contrato',$request->iddelete)->pluck('path'),true);    
                Storage::delete($arrayPath);
     
                $contrato = Contrato::find($request->iddelete);
                $delete=$contrato->delete();
                
                if($delete){
                    return redirect()->action('ContratoController@create')->with('status_success', 'Contrato excluído!');
                }else{
                    return redirect()->action('ContratoController@create')->with('status_error', 'Não foi possível excluir o registro, possivelmente existem movimentação/cadastros!');    
                }

    }

}
