<?php

namespace App\Http\Controllers;

use App\Models\Modocobranca;
use App\Models\PerfilAcesso;
use App\Models\Prazopagamento;
use App\Models\Setempresa;
use App\Models\Setor;
use App\Models\Tabelapreco;
use App\Models\Vendedor;
use App\Models\Venmodcobranca;
use App\Models\Venprazopag;
use App\Models\Ventabelapreco;
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
                $tabPrecos = Tabelapreco::where('ativo',1)->get();
                $modCobs = Modocobranca::where('ativo',1)->get();
                $prazoCobs = Prazopagamento::where('ativo',1)->get();
            }else{
                $vendedores = Vendedor::where('emp_cod',$uempresa)->get();
                $empresas = Setempresa::where('id_empresa',$uempresa)->get();
                $supervisores = Vendedor::where('tipo',1)->where('emp_cod',$uempresa)->get();
                $gerentes = Vendedor::where('tipo',2)->where('emp_cod',$uempresa)->get();
                $setores = Setor::where('emp_cod',$uempresa)->get();
                $tabPrecos = Tabelapreco::where('emp_cod',$uempresa)->where('ativo',1)->get();
                $modCobs = Modocobranca::where('ativo',1)->get();
                $prazoCobs = Prazopagamento::where('ativo',1)->where('emp_cod',$uempresa)->get();
            }

            

                if ($roleView[0]  == 1){
                    return view('painel.page.vendedor',compact('uperfil','uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil','vendedores','empresas','supervisores','gerentes','setores','tabPrecos','modCobs','prazoCobs'));
                }else{
                    return view('painel.page.nopermission',compact('uperfil','$uempresa','unomeperfil','unome','uid','uimagem','acessoPerfil'));
                }  

        }else{

            return view('login');

        }
    }

    public function store(Request $request){
        $count = count(Vendedor::where('cnpjcpf',$request->cnpjcpfcad)->get());
        //dd($count);
        if($count < 1){
        $vendedor = new Vendedor;
        $vendedor->emp_cod = $request->empresacad;
        $vendedor->nome = $request->nomecad;
        $vendedor->logradouro = $request->logradourocad;
        $vendedor->complemento = $request->complementocad;
        $vendedor->numero = $request->numerocad;
        $vendedor->bairro = $request->bairrocad;
        $vendedor->cidade = $request->cidadecad;
        $vendedor->uf = $request->ufcad;
        $vendedor->cep = $request->cepcad;
        $vendedor->pessoa = $request->pessoacad;
        $vendedor->cnpjcpf = $request->cnpjcpfcad;
        $vendedor->tipo = $request->tipocad;
        $vendedor->supervisor = $request->supervisorcad;
        $vendedor->gerente = $request->gerentecad;
        $vendedor->telefone = $request->telefonecad;
        $vendedor->email = $request->emailcad;
        $vendedor->senha = bcrypt('123');
        $vendedor->comissao = $request->comissaocad;
        $vendedor->pago_emissao = $request->pagoemissaocad;
        $vendedor->pago_baixa = $request->pagobaixacad;
        $vendedor->desconto_max = $request->descontocad;
        $vendedor->pedido_min = $request->pedmincad;
        $vendedor->pedido_min = $request->pedmincad;
        $vendedor->setor = $request->setorcad;
        $vendedor->ativo = $request->statuscad;
        $saveStatus = $vendedor->save();
      
        if($saveStatus){            

            
            foreach ($request->tabPrecocad as $tabPreco) {
                $venTabPreco = new Ventabelapreco();
                $venTabPreco->vendedor = Vendedor::orderBy('id_vendedor','desc')->first()->id_vendedor;
                $venTabPreco->tabpreco = $tabPreco;
                $venTabPreco->save();
            }
            
            foreach ($request->modCobcad as $modCob) {
                $venModCob = new Venmodcobranca();
                $venModCob->vendedor = Vendedor::orderBy('id_vendedor','desc')->first()->id_vendedor;
                $venModCob->modocobranca = $modCob;
                $venModCob->save();
            }

            foreach ($request->tabPrazocad as $tabPrazo) {
                $venPrazo= new Venprazopag();
                $venPrazo->vendedor = Vendedor::orderBy('id_vendedor','desc')->first()->id_vendedor;
                $venPrazo->prazopag = $tabPrazo;
                $venPrazo->save();
            }

        }

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

        return redirect()->action('VendedorController@create')->with('status_error', 'Falha!');

        }
            $vendedorDel = Vendedor::find($request->iddelete);
            $delete=$vendedorDel ->delete();

            if($delete){
                return redirect()->action('VendedorController@create')->with('status_success', 'Excluído!');
            }else{
                return redirect()->action('VendedorController@create')->with('status_error', 'Não foi possível excluir o registro, possivelmente existem movimentação/cadastros!');    
            }
    }

    public function obterModCobVen(Request $request){

        $modCob = Venmodcobranca::where('vendedor',$request->id)->pluck('modocobranca');
       
        return response()->json([$modCob],200);

    }

    public function obterPrazoPagVen(Request $request){

        $prazoPag = Venprazopag::where('vendedor',$request->id)->pluck('prazopag');
       
        return response()->json([$prazoPag],200);

    }

    public function obterTabPrecoVen(Request $request){

        $tabPreco = Ventabelapreco::where('vendedor',$request->id)->pluck('tabpreco');
       
        return response()->json([$tabPreco],200);

    }

}
