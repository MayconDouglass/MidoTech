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
        $valEmp = Setempresa::where('CNPJ',$request->cnpjcad)->get();
        $countEmp = count(Setempresa::where('CNPJ',$request->cnpjcad)->get());
        if($countEmp < 1 ){
            $empresa = new Setempresa;
            $empresa->razao_social = $request->razaocad;
            $empresa->nome_fantasia = $request->fantasiacad;
            $empresa->Logradouro = $request->logradourocad;
            $empresa->Numero = $request->numerocad;
            $empresa->Complemento = $request->complementocad;
            $empresa->Bairro = $request->bairrocad;
            $empresa->Cidade = $request->cidadecad;
            $empresa->Estado = $request->ufcad;
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
         
            $saveStatus = $empresa->save();

            if($request->fotocad){
                $file = $request->fotocad;
                $filename= $empresa->id_empresa.'.jpg';
                $info = getimagesize($file);
                $destination_path = 'storage/img/emp/';
    
                if ($info['mime'] == 'image/jpeg') {
                    $image = imagecreatefromjpeg($file);
                }elseif($info['mime'] == 'image/png'){
                    $image = imagecreatefrompng($file);
                }
            
                imagejpeg($image, $destination_path.$filename, 70);
            }

            if($saveStatus){            
                return redirect()->action('EmpresaController@create')->with('status_success', 'Empresa Cadastrada!');
            }else{
                    return redirect()->action('EmpresaController@create')->with('status_error', 'OPS! Algum erro no Cadastrado, tente novamente!');
                }

        }else{
           
            return redirect()->action('EmpresaController@create')->with('status_error', 'Já existe uma empresa com este CNPJ!');

        }
    }

    public function update(Request $request){
        $valEmp = Setempresa::where('CNPJ',$request->cnpjcad)->get();
        $countEmp = count(Setempresa::where('CNPJ',$request->cnpjcad)->get());
        if($countEmp < 1 ){
            $empresa = Setempresa::find($request->id_empresa)->get();
            $empresa->razao_social = $request->razaocad;
            $empresa->nome_fantasia = $request->fantasiacad;
            $empresa->Logradouro = $request->logradourocad;
            $empresa->Numero = $request->numerocad;
            $empresa->Complemento = $request->complementocad;
            $empresa->Bairro = $request->bairrocad;
            $empresa->Cidade = $request->cidadecad;
            $empresa->Estado = $request->ufcad;
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
         
            $saveStatus = $empresa->save();

            if($request->fotocad){
                $file = $request->fotocad;
                $filename= $empresa->id_empresa.'.jpg';
                $info = getimagesize($file);
                $destination_path = 'storage/img/emp/';
    
                if ($info['mime'] == 'image/jpeg') {
                    $image = imagecreatefromjpeg($file);
                }elseif($info['mime'] == 'image/png'){
                    $image = imagecreatefrompng($file);
                }
            
                imagejpeg($image, $destination_path.$filename, 70);
            }

            if($saveStatus){            
                return redirect()->action('EmpresaController@create')->with('status_success', 'Empresa Alterada!');
            }else{
                    return redirect()->action('EmpresaController@create')->with('status_error', 'OPS! Algum erro na atualização, tente novamente!');
                }

        }else{
           
            return redirect()->action('EmpresaController@create')->with('status_error', 'Já existe uma empresa com este CNPJ!');

        }

    }


}
