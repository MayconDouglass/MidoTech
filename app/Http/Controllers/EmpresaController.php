<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\PerfilAcesso;
use App\Models\Regimetrib;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use App\Models\Setempresa;
use App\Models\Setatividade;
use Auth;

class EmpresaController extends Controller
{
    public function create()
    {
        if (Auth::user()){
            $uid= Auth::user()->id_usuario;
            $uperfil= Auth::user()->perfil_fk;
            $unome= Auth::user()->nome;
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
            
            $atividades = Setatividade::where('ativo',1)->get();
            
            $regimetributados = Regimetrib::where('ativo',1)->get();
           
            $acessoPerfil = PerfilAcesso::where('perfil_cod',Auth::user()->perfil_fk)
                                        ->select('role','ativo')->get();

            $roles = PerfilAcesso::where('perfil_cod',Auth::user()->perfil_fk)
                                 ->pluck('ativo');
            if($roles[4] == 1){
            $empresas = Setempresa::all();
            }else{
            $empresas = Setempresa::where('id_empresa',$uempresa)->get();   
            }
                if (($roles[0]  == 1) && ($roles[1] == 1)){
                    return view('painel.page.empresa',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','atividades','regimetributados','acessoPerfil'));
                }else{
                    return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','acessoPerfil'));
                }  

        }else{

            return view('login');

        }
    }

    public function store(Request $request){
        $countEmp = count(Setempresa::where('CNPJ',$request->cnpjcad)->get());
        
        if(!$request->licencacad){
            $licencas = 0;
        }else{
            $licencas = $request->licencacad;
        }


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
            $empresa->ibge = $request->ibgecad;
            $empresa->CNPJ = $request->cnpjcad;
            $empresa->IE = $request->iecad;
            $empresa->IM = $request->imcad;
            $empresa->Telefone = $request->telefonecad;
            $empresa->ativo = $request->ativacad;
            $empresa->Pag_web = $request->sitecad;
            $empresa->email = $request->emailcad;
            $empresa->Sigla = $request->siglacad;
            $empresa->Licenca =$licencas ;
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
        
        $countEmp = count(Setempresa::where('CNPJ',$request->cnpjalt)->get());
        
        if(!$request->licencaalt){
            $licencas = 0;
        }else{
            $licencas = $request->licencaalt;
        }

            $empresa = Setempresa::find($request->idEmp);
            $empresa->razao_social = $request->razaoalt;
            $empresa->nome_fantasia = $request->fantasiaalt;
            $empresa->Logradouro = $request->logradouroalt;
            $empresa->Numero = $request->numeroalt;
            $empresa->Complemento = $request->complementoalt;
            $empresa->Bairro = $request->bairroalt;
            $empresa->Cidade = $request->cidadealt;
            $empresa->Estado = $request->ufalt;
            $empresa->CEP = $request->cepalt;
            $empresa->ibge = $request->ibgealt;
            if($countEmp < 1 ){
                $empresa->CNPJ = $request->cnpjalt;
            }
            $empresa->IE = $request->iealt;
            $empresa->IM = $request->imalt;
            $empresa->Telefone = $request->telefonealt;
            $empresa->ativo = $request->ativaalt;
            $empresa->Pag_web = $request->sitealt;
            $empresa->email = $request->emailalt;
            $empresa->Sigla = $request->siglaalt;
            $empresa->Licenca = $licencas;
            $empresa->DataAlt = date('Y-m-d H:i:s');
            $empresa->regimetrib = $request->regimealt;
            $empresa->atividade = $request->atividadealt;
            $empresa->saldo_cliente = $request->saldoalt;
            $updateStatus = $empresa->update();

            
        if($request->fotoalt){
            $file = $request->fotoalt;
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

            if($updateStatus){            
                return redirect()->action('EmpresaController@create')->with('status_success', 'Empresa Alterada!');
            }else{
                    return redirect()->action('EmpresaController@create')->with('status_error', 'OPS! Algum erro na atualização, tente novamente!');
                }


    }

    public function destroy(Request $request){
        if(empty($request->iddelete)){
            return redirect()->action('EmpresaController@create')->with('status_error', 'Falha!');    
            }
            $empresa = Setempresa::find($request->iddelete);
            $delete=$empresa->delete();
            if($delete){
                $arquivo = 'storage/img/emp/'.$request->iddelete.'.jpg';
                if(file_exists($arquivo)){
                unlink($arquivo);
                }
            return redirect()->action('EmpresaController@create')->with('status_success', 'Empresa Excluída!');
            }else{
            return redirect()->action('EmpresaController@create')->with('status_error', 'Não foi possível excluir a empresa, possivelmente existem movimentação/cadastros!');    
            }
    }


}
