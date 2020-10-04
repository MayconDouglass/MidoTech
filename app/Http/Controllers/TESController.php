<?php

namespace App\Http\Controllers;

use App\Models\Operacaofiscal;
use App\Models\Perfil;
use App\Models\PerfilAcesso;
use App\Models\Te as TES;
use Illuminate\Http\Request;

use Auth;

class TESController extends Controller
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

            $roleAdmin = PerfilAcesso::where('perfil_cod',$uperfil)
                                    ->where('role',5)
                                    ->pluck('ativo');
                                    
            $acessoPerfil = PerfilAcesso::where('perfil_cod',$uperfil)
                                        ->select('role','ativo')->get();

            $cfops = Operacaofiscal::all();

            if($roleAdmin[0] == 1){
                $tes = TES::all();
            }else{
                $tes = TES::where('emp_cod',$uempresa)->get();
            }
                                 
            if ($roleView[0]  == 1){
                return view('painel.page.tes',compact('uperfil','uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil','tes','cfops'));
            }else{
                return view('painel.page.nopermission',compact('uperfil','$uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil'));
            }  

        }else{

            return view('login');

        }
    }

    public function store(Request $request){

        //dd($request->incide_icms_pci_cad ? 'teste' : 'asasa');
        $TES = new TES;
        $TES->emp_cod = Auth::user()->empresa;
        $TES->cod_tes = $request->codigocad;
        $TES->descricao = $request->descricaocad;
        $TES->CFOP = $request->cfopcad;
        $TES->tipo = $request->tipocad;
        $TES->status = $request->statuscad;
        $TES->serie = $request->seriecad;
        $TES->calc_icms = $request->calc_icms_cad ? '1' : '0';
        $TES->calc_ipi = $request->calc_ipi_cad ? '1' : '0';
        $TES->cred_icm = $request->cred_icm_cad ? '1' : '0';
        $TES->cred_ipi = $request->cred_ipi_cad ? '1' : '0';
        $TES->cred_piscofins = $request->cred_piscofins_cad ? '1' : '0';
        $TES->financeiro = $request->financeiro_cad ? '1' : '0';
        $TES->nfe = $request->emissao_cad ? '1' : '0';
        $TES->boleto = $request->boleto_cad;
        $TES->mov_estoque = $request->mov_est_cad ? '1' : '0';
        $TES->dest_ipi = $request->dest_ipi_cad ? '1' : '0';
        $TES->incide_ipi = $request->incide_ipi_cad ? '1' : '0';
        $TES->incide_frete = $request->incide_frete_cad ? '1' : '0';
        $TES->incide_despesas = $request->incide_despesas_cad ? '1' : '0';
        $TES->incide_base_ipi = $request->incide_base_ipi_cad ? '1' : '0';
        $TES->calc_iss = $request->calc_iss_cad ? '1' : '0';
        $TES->at_custo = $request->at_custo_cad ? '1' : '0';
        $TES->at_custo_medio = $request->at_custo_medio_cad ? '1' : '0';
        $TES->at_custo_aquisicao = $request->at_custo_aq_cad ? '1' : '0';
        $TES->at_preco_venda = $request->at_preco_cad ? '1' : '0';
        $TES->soma = $request->soma_cad ? '1' : '0';
        $TES->espelho = $request->espelho_cad ? '1' : '0';
        $TES->aliq_iss = $request->aliq_iss_cad;
        $TES->aliq_irrf = $request->aliq_irrf_cad;
        $TES->irrf_nfsuperior = $request->irrf_cad;
        $TES->aliq_inss = $request->aliq_inss_cad;
        $TES->inss_nfsuperior = $request->inss_cad;
        $TES->ret_pis = $request->ret_pis_cad;
        $TES->pis_nfsuperior = $request->pis_nf_cad;
        $TES->ret_cofins = $request->ret_cofins_cad;
        $TES->cofins_nfsuperior = $request->cofins_nf_cad;
        $TES->ret_csll = $request->ret_csll_cad;
        $TES->abat_suframa_pis = $request->abat_suframa_pis_cad;
        $TES->abat_suframa_cofins = $request->abat_suframa_cofins_cad;
        $TES->comissao = $request->comissao_cad ? '1' : '0';
        $TES->simples = $request->simples_cad;
        $TES->ali_simples = $request->aliq_simples_cad;
        $TES->calc_import = $request->calc_import_cad ? '1' : '0';
        $TES->soma_import = $request->soma_import_cad ? '1' : '0';
        $TES->lancamento_ipi = $request->lanc_ipi_cad ? '1' : '0';
        $TES->incide_icms_pci = $request->incide_icms_pci_cad ? '1' : '0';
        $TES->incide_despesas_pc = $request->incide_despesas_pc_cad ? '1' : '0';
        $TES->ded_icms_pc = $request->ded_icms_pc_cad ? '1' : '0';
        $TES->calc_difal = $request->calc_difal_cad ? '1' : '0';
        $TES->calc_fcp = $request->calc_fecp_cad ? '1' : '0';
        $TES->duplicata_st = $request->dup_st_cad ? '1' : '0';
        $TES->desc_icms = $request->desc_icms_cad ? '1' : '0';
        $TES->desc_icms_des = $request->desc_icms_des_cad ? '1' : '0';
        $TES->desc_ipi = $request->desc_ipi_cad ? '1' : '0';
        $TES->al_padrao = $request->alcodcad;
        $saveStatus = $TES->save();
      
        if($saveStatus){            
                return redirect()->action('TESController@create')->with('status_success', 'TES Cadastrado!');
        }else{
                return redirect()->action('TESController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }


    }

    public function update(Request $request){
        $TES = TES::find($request->idTES);
        //dd($request->all());
        $TES->descricao = $request->descricaoalt;
        $TES->CFOP = $request->cfopalt;
        $TES->status = $request->statusalt;
        $TES->serie = $request->seriealt;
        $TES->calc_icms = $request->calc_icms_alt ? '1' : '0';
        $TES->calc_ipi = $request->calc_ipi_alt ? '1' : '0';
        $TES->cred_icm = $request->cred_icm_alt ? '1' : '0';
        $TES->cred_ipi = $request->cred_ipi_alt ? '1' : '0';
        $TES->cred_piscofins = $request->cred_piscofins_alt ? '1' : '0';
        $TES->financeiro = $request->financeiro_alt ? '1' : '0';
        $TES->nfe = $request->emissao_alt ? '1' : '0';
        $TES->boleto = $request->boleto_alt;
        $TES->mov_estoque = $request->mov_est_alt ? '1' : '0';
        $TES->dest_ipi = $request->dest_ipi_alt ? '1' : '0';
        $TES->incide_ipi = $request->incide_ipi_alt ? '1' : '0';
        $TES->incide_frete = $request->incide_frete_alt ? '1' : '0';
        $TES->incide_despesas = $request->incide_despesas_alt ? '1' : '0';
        $TES->incide_base_ipi = $request->incide_base_ipi_alt ? '1' : '0';
        $TES->calc_iss = $request->calc_iss_alt ? '1' : '0';
        $TES->at_custo = $request->at_custo_alt ? '1' : '0';
        $TES->at_custo_medio = $request->at_custo_medio_alt ? '1' : '0';
        $TES->at_custo_aquisicao = $request->at_custo_aq_alt ? '1' : '0';
        $TES->at_preco_venda = $request->at_preco_alt ? '1' : '0';
        $TES->soma = $request->soma_alt ? '1' : '0';
        $TES->espelho = $request->espelho_alt ? '1' : '0';
        $TES->aliq_iss = $request->aliq_iss_alt;
        $TES->aliq_irrf = $request->aliq_irrf_alt;
        $TES->irrf_nfsuperior = $request->irrf_alt;
        $TES->aliq_inss = $request->aliq_inss_alt;
        $TES->inss_nfsuperior = $request->inss_alt;
        $TES->ret_pis = $request->ret_pis_alt;
        $TES->pis_nfsuperior = $request->pis_nf_alt;
        $TES->ret_cofins = $request->ret_cofins_alt;
        $TES->cofins_nfsuperior = $request->cofins_nf_alt;
        $TES->ret_csll = $request->ret_csll_alt;
        $TES->abat_suframa_pis = $request->abat_suframa_pis_alt;
        $TES->abat_suframa_cofins = $request->abat_suframa_cofins_alt;
        $TES->comissao = $request->comissao_alt ? '1' : '0';
        $TES->simples = $request->simples_alt;
        $TES->ali_simples = $request->aliq_simples_alt;
        $TES->calc_import = $request->calc_import_alt ? '1' : '0';
        $TES->soma_import = $request->soma_import_alt ? '1' : '0';
        $TES->lancamento_ipi = $request->lanc_ipi_alt ? '1' : '0';
        $TES->incide_icms_pci = $request->incide_icms_pci_alt ? '1' : '0';
        $TES->incide_despesas_pc = $request->incide_despesas_pc_alt ? '1' : '0';
        $TES->ded_icms_pc = $request->ded_icms_pc_alt ? '1' : '0';
        $TES->calc_difal = $request->calc_difal_alt ? '1' : '0';
        $TES->calc_fcp = $request->calc_fecp_alt ? '1' : '0';
        $TES->duplicata_st = $request->dup_st_alt ? '1' : '0';
        $TES->desc_icms = $request->desc_icms_alt ? '1' : '0';
        $TES->desc_icms_des = $request->desc_icms_des_alt ? '1' : '0';
        $TES->desc_ipi = $request->desc_ipi_alt ? '1' : '0';
        $TES->al_padrao = $request->alcodalt;
        $saveStatus = $TES->save();
      
        if($saveStatus){            
                return redirect()->action('TESController@create')->with('status_success', 'TES Cadastrado!');
        }else{
                return redirect()->action('TESController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }
    }

    public function destroy(Request $request){
        if(empty($request->iddelete)){
        return redirect()->action('TESController@create')->with('status_error', 'Falha!');    
        }
            $TESDel = TES::find($request->iddelete);
            $delete= $TESDel->delete();
            if($delete){
               return redirect()->action('TESController@create')->with('status_success', 'Excluído!');
            }else{
            return redirect()->action('TESController@create')->with('status_error', 'Não foi possível excluir o registro, possivelmente existem movimentação/cadastros!');    
            }
    }

    public function viewTES($id){
        $TES = TES::where('id_tes',$id)->first();
        
        if(!$TES)
            return json_encode(['Erro'=>'404','Motivo'=>'Nao Encontrado TES com este ID'],true);

        return json_encode($TES,true);
    }


}
