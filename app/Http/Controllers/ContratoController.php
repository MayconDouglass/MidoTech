<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\ContratosEmpresa;
use App\Models\Perfil;
use App\Models\PerfilAcesso;
use App\Models\Setunidade;
use Illuminate\Http\Request;

use Auth;

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
        $contFiles = $request->file('arquivocad');
        if($contFiles == null){
        $path = null;
        }else{
        $path = $contFiles->store('contratos','public');
        }

        $contrato = new Contrato;
        $contrato->razao_social = $request->razaocad;
        $contrato->cli_cod = $request->idCliente;
        $contrato->proposta = $proposta;
        $contrato->pessoa = $request->pessoacad;
        $contrato->cgc = $request->cgccad;
        $contrato->path = $path;
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

                if($saveConEmp){
                    return redirect()->action('ContratoController@create')->with('status_success', 'Contrato Cadastrado!');
                }else{
                    return redirect()->action('ContratoController@create')->with('status_error', 'Erro I/O - Contratos. Entre em contato com o suporte.');
                }            
                
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


}
