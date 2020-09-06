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
        if($request->supervisorcad != null){
        $vendedor->supervisor = $request->supervisorcad;
        }else{
        $vendedor->supervisor =  0;
        }
        if($request->gerentecad != null){
        $vendedor->gerente = $request->gerentecad;
        }else{
        $vendedor->gerente = 0;
        }
        $vendedor->telefone = $request->telefonecad;
        $vendedor->email = $request->emailcad;
        $vendedor->senha = bcrypt('123');
        $vendedor->comissao = $request->comissaocad;
        $vendedor->pago_emissao = $request->pagoemissaocad;
        $vendedor->pago_baixa = $request->pagobaixacad;
        $vendedor->desconto_max = $request->descontocad;
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
        $vendedor = Vendedor::find($request->idVendedor);
        $vendedor->nome = $request->nomealt;
        $vendedor->logradouro = $request->logradouroalt;
        $vendedor->complemento = $request->complementoalt;
        $vendedor->numero = $request->numeroalt;
        $vendedor->bairro = $request->bairroalt;
        $vendedor->cidade = $request->cidadealt;
        $vendedor->uf = $request->ufalt;
        $vendedor->cep = $request->cepalt;
        $vendedor->tipo = $request->tipoalt;
        if($request->supervisoralt != null){
        $vendedor->supervisor = $request->supervisoralt;
        }else{
        $vendedor->supervisor = 0;   
        }
        if($request->gerentealt != null){
        $vendedor->gerente = $request->gerentealt;
        }else{
        $vendedor->gerente = 0;
        }
        $vendedor->telefone = $request->telefonealt;
        $vendedor->email = $request->emailalt;
        $vendedor->comissao = $request->comissaoalt;
        $vendedor->pago_emissao = $request->pagoemissaoalt;
        $vendedor->pago_baixa = $request->pagobaixaalt;
        $vendedor->desconto_max = $request->descontoalt;
        $vendedor->pedido_min = $request->pedminalt;
        $vendedor->setor = $request->setoralt;
        $vendedor->ativo = $request->statusalt;
        $saveUpdate = $vendedor->save();
      
        if($saveUpdate){            
            $tabPrecoExist = Ventabelapreco::where('vendedor',$request->idVendedor)->delete();
            foreach ($request->tabPrecoalt as $tabPreco) {
                $Exist = Ventabelapreco::where('tabpreco',$tabPreco)->where('vendedor',$request->idVendedor)->get()->count('tabpreco');
                if($Exist < 1){
                $venTabPreco = new Ventabelapreco();
                $venTabPreco->vendedor = $request->idVendedor;
                $venTabPreco->tabpreco = $tabPreco;
                $venTabPreco->save();
                }
            }
            if($tabPrecoExist){
                $modCobExist = Venmodcobranca::where('vendedor',$request->idVendedor)->delete();
                foreach ($request->modCobalt as $modCob) {
                    $Exist = Venmodcobranca::where('modocobranca',$modCob)->where('vendedor',$request->idVendedor)->get()->count('modocobranca');
                    if($Exist < 1){
                    $venModCob = new Venmodcobranca();
                    $venModCob->vendedor = $request->idVendedor;
                    $venModCob->modocobranca = $modCob;
                    $venModCob->save();
                    }
                }

                if($modCobExist){
                    $prazoPagExist = Venprazopag::where('vendedor',$request->idVendedor)->delete();
                    foreach ($request->tabPrazoalt as $tabPrazo) {
                        $Exist = Venprazopag::where('prazopag',$tabPrazo)->where('vendedor',$request->idVendedor)->get()->count('tabPrazo');
                        if($Exist < 1){
                        $venPrazo= new Venprazopag();
                        $venPrazo->vendedor = $request->idVendedor;
                        $venPrazo->prazopag = $tabPrazo;
                        $venPrazo->save();
                        }
                    }
                }
            
            }

            return redirect()->action('VendedorController@create')->with('status_success', 'Vendedor Atualizado!');

        }else{

            return redirect()->action('VendedorController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
        }

    }

    public function destroy(Request $request){

        if(empty($request->iddelete)){

        return redirect()->action('VendedorController@create')->with('status_error', 'Falha!');

        }
            $vendedorDel = Vendedor::find($request->iddelete);
            $delete=$vendedorDel->delete();

            if($delete){
                return redirect()->action('VendedorController@create')->with('status_success', 'Excluído!');
            }else{
                return redirect()->action('VendedorController@create')->with('status_error', 'Não foi possível excluir o registro, possivelmente existem movimentação/cadastros!');    
            }
    }

    public function resetPassword(Request $request){

        if(empty($request->idVendedor)){
 
             return redirect()->action('VendedorController@create')->with('status_error', 'Falha!');  
 
        }
        
        $vendedor = Vendedor::find($request->idVendedor);
        $vendedor->senha = bcrypt('123');
        
        if($vendedor->save()){
            return redirect()->action('VendedorController@create')->with('status_success', 'Senha resetada!');
        }else{
            return redirect()->action('VendedorController@create')->with('status_error', 'OPS! Tente novamente!');
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
