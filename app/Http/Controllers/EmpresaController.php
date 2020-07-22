<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use App\Models\Setempresa;
use App\Models\Setatividade;
use Auth;
use Hash;

class EmpresaController extends Controller
{
    public function create()
    {
        if (Auth::user()){
            
            $uid= Auth::user()->id_usuario;
            $unome= Auth::user()->nome;
            $uperfil= Auth::user()->perfil_fk;
            $unomeperfil= Auth::user()->perfil->nome;

            //dd();
            $arquivo = 'storage/img/users/'.$uid.'.jpg';
            if(file_exists($arquivo)){
            $uimagem = $arquivo;
            } else {
            $uimagem = 'storage/img/users/default.jpg';
            }
            
            $empresas = Setempresa::all();
            $atividades = Setatividade::where('ativo',1)->get();

            return view('painel.page.empresa',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','atividades'));
            
        }else{

            return view('login');

        }
    }

    public function store(Request $request){
        $countEmp = count(Setempresa::where('CNPJ',$request->cnpj)->get());
        if($countEmp < 1 ){
            $empresa = new Setempresa;
            $empresa->razao_social = $request->razaocad;
            $empresa->nome_fantasia = $request->fantasiacad;
            $empresa->Logradouro = $request->logradourocad;
            $empresa->Numero = $request->numerocad;
            $empresa->Complemento = $request->complementocad;
            $empresa->Bairro = $request->bairrocad;
            $empresa->Cidade = $request->cidadecad;
            $empresa->Estado = $request->estadocad;
            $empresa->CEP = $request->cepcad;
            $empresa->CNPJ = $request->cnpjcad;
            $empresa->IE = $request->iecad;
            $empresa->IM = $request->imcad;
            $empresa->Telefone = $request->telefonecad;
            $empresa->ativo = $request->ativacad;
            $empresa->Pag_web = $request->sitecad;
            $empresa->email = $request->emailcad;
            $empresa->Sigla = $request->siglacad;
            $empresa->DataCad = date('Y-m-d H:i:s');
            $empresa->regimetrib = $request->regimecad;
            $empresa->atividade = $request->atividadecad;
            $empresa->saldo_cliente = $request->saldocad;
            $empresa->data_processamento = date('Y-m-d H:i:s');
            $ 



        }
    }

}
