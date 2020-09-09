<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Clilogradouro;
use App\Models\Modocobranca;
use App\Models\PerfilAcesso;
use App\Models\Prazopagamento;
use App\Models\Setempresa;
use App\Models\Tabelapreco;
use App\Models\Vendedor;
use Illuminate\Http\Request;

use Auth;

class ClienteController extends Controller
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
            
            $acessoPerfil = PerfilAcesso::where('perfil_cod',$uperfil)
                                        ->select('role','ativo')->get();
            
            $roleClientes = PerfilAcesso::where('perfil_cod',$uperfil)
                                        ->where('role',5)
                                        ->pluck('ativo');
            if($roleClientes = 1){
                $clientes = Cliente::all();
            }else{
                $clientes = Cliente::where('emp_cod',$uempresa)->get();   
            }

            $empresas = Setempresa::all();

                if ($roleView[0]  == 1){
                    return view('painel.page.cliente',compact('uperfil','unomeperfil','uempresa','unome','uid','uimagem','empresas','acessoPerfil','clientes'));
                }else{
                    return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','acessoPerfil'));
                }  

        }else{

            return view('login');

        }
    }

    public function addUser()
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
            $uimagem = '/storage/img/users/'.$uid.'.jpg';
            } else {
            $uimagem = '/storage/img/users/default.jpg';
            }
            
            $roleView = PerfilAcesso::where('perfil_cod',$uperfil)
                                    ->where('role',1)
                                    ->pluck('ativo');
            
            $acessoPerfil = PerfilAcesso::where('perfil_cod',$uperfil)
                                        ->select('role','ativo')->get();
            
            $roleAdmin = PerfilAcesso::where('perfil_cod',$uperfil)
                                        ->where('role',5)
                                        ->pluck('ativo');

            if($roleAdmin = 1){
                $modCobs = Modocobranca::where('ativo',1)->get();
                $tabPrecos = Tabelapreco::where('ativo',1)->where('emp_cod',$uempresa)->get();
                $prazoCobs = Prazopagamento::where('ativo',1)->get();
                $vendedores = Vendedor::where('ativo',1)->get();
            }else{  
                $modCobs = Modocobranca::where('ativo',1)->get();
                $tabPrecos = Tabelapreco::where('ativo',1)->where('emp_cod',$uempresa)->get();
                $prazoCobs = Prazopagamento::where('ativo',1)->get();
                $vendedores = Vendedor::where('ativo',1)->where('emp_cod',$uempresa)->get();
            }

            $empresas = Setempresa::all();

                if ($roleView[0]  == 1){
                    return view('painel.page.clienteadd',
                    compact('uperfil','unomeperfil','uempresa',
                    'unome','uid','uimagem','empresas','acessoPerfil',
                    'modCobs','tabPrecos','prazoCobs','vendedores'));
                }else{
                    return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','acessoPerfil'));
                }  

        }else{

            return view('login');

        }
    }

    public function store(Request $request){
        $cliente = new Cliente;
        $cliente->emp_cod = $request->empcod;
        $cliente->razao_social = $request->razao;
        $cliente->nome_fantasia = $request->fantasia;
        $cliente->tipo_pessoa = $request->pessoa;
        $cliente->grupo = $request->grupo;
        $cliente->cpf_cnpj = $request->cpfcnpj;
        $cliente->status = $request->status;
        $cliente->insc_estadual = $request->iestadual;
        $cliente->email = $request->email;
        $cliente->cnpj_sefaz = $request->cnpjsefaz;
        $cliente->limite_cred = $request->limitecred;
        $cliente->venc_limite_cred = $request->venccred;
        $cliente->cModCob = $request->cModCob;
        $cliente->modo_cobranca = $request->modcob;
        $cliente->cPrazoPag = $request->cPrazoPag;
        $cliente->prazo_pagamento = $request->prazocob;
        $cliente->cTabPreco = $request->cTabPreco;
        $cliente->tab_cod = $request->tabpreco;
        $cliente->tipo_contribuinte = $request->pessoa;
        $cliente->transp_cod = $request->transp;
        $cliente->flag_orc = $request->orc;
        $cliente->tes_cod = $request->tes;
        $cliente->ven_cod = $request->vendedor;
        $cliente->observacoes = $request->obs;
        $saveStatus = $cliente->save();

        if($saveStatus){    
            $clienteEnd = new Clilogradouro;
            $clienteEnd->emp_cod = $request->$request->empcod;        
            $clienteEnd->cli_cod = $cliente->id_cliente;        
            $clienteEnd->tipo = $request->tipolog;   
            $clienteEnd->cep = $request->cep;   
            $clienteEnd->IBGE = $request->ibge;   
            $clienteEnd->endereco = $request->logradouro;   
            $clienteEnd->complemento = $request->complemento;   
            $clienteEnd->numero = $request->numero;   
            $clienteEnd->bairro = $request->bairro;   
            $clienteEnd->cidade = $request->cidade;   
            $clienteEnd->UF = $request->uf;   
            $clienteEnd->referencia = $request->referencia;   
            $saveEnd = $clienteEnd->save();

            if($saveEnd){
                return redirect()->action('ClienteController@create')->with('status_success', 'Cliente Cadastrado!');
            }else{
                return redirect()->action('ClienteController@create')->with('status_warning', 'OPS! Algum erro no Cadastrado, o Cliente foi salvo mas o Endereço não!');
            }

        }else{
            return redirect()->action('ClienteController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }

    }

}
