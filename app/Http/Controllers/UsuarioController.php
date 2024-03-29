<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\PerfilAcesso;
use Illuminate\Http\Request;
use App\Models\Setempresa;
use App\Models\Usuario;
use Auth;
use Hash;

class UsuarioController extends Controller
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
            
            $empresas = Setempresa::where('id_empresa',$uempresa)->get();
           

            $roleView = PerfilAcesso::where('perfil_cod',Auth::user()->perfil_fk)
                                    ->where('role',1)
                                    ->pluck('ativo');
            $acessoPerfil = PerfilAcesso::where('perfil_cod',Auth::user()->perfil_fk)
            ->select('role','ativo')->get();

            $roles = PerfilAcesso::where('perfil_cod',Auth::user()->perfil_fk)
            ->pluck('ativo');

                $usuarios = Usuario::where('empresa',$uempresa)->get();
                $perfis = Perfil::where('ativo',1)->where('emp_cod',$uempresa)->get();
            

            if (($roleView[0]  == 1) && ($roles[5] == 1)){
            return view('painel.page.usuario',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','usuarios','perfis','acessoPerfil','uempresa'));
            }else{
                return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','perfis','acessoPerfil'));
            }  

        }else{

            return view('login');

        }
    }


    public function store(Request $request){
        $countUser = count(Usuario::where('email',$request->emailcad)->get());
        $countUserLicenca = count(Usuario::where('empresa',Auth::user()->empresa)->get());
        $countLicenca = Setempresa::where('id_empresa',Auth::user()->empresa)->pluck('licenca')[0];
        
        if(($countLicenca - $countUserLicenca) > 0){

            if($countUser < 1){
                $usuario = new Usuario();
                $usuario->empresa = $request->empcad;
                $usuario->perfil_fk = $request->perfilcad;
                $usuario->nome = $request->nomecad;
                $usuario->email = $request->emailcad;
                $usuario->password = bcrypt($request->passwordcad);
                $usuario->ativo = $request->ativacad;
                $usuario->usucad = Auth::user()->id_usuario;
                $usuario->data_cadastro = date('Y-m-d H:i:s');
                $saveStatus = $usuario->save();

                if($request->fotocad){
                    $file = $request->fotocad;
                    $filename= $usuario->id_usuario.'.jpg';
                    $info = getimagesize($file);
                    $destination_path = 'storage/img/users/';
    
                    if ($info['mime'] == 'image/jpeg') {
                        $image = imagecreatefromjpeg($file);
                    }elseif($info['mime'] == 'image/png'){
                        $image = imagecreatefrompng($file);
                    }
            
                    imagejpeg($image, $destination_path.$filename, 70);
                }

                if($saveStatus){            
                    return redirect()->action('UsuarioController@create')->with('status_success', 'Usuário Cadastrada!');
                }else{
                    return redirect()->action('UsuarioController@create')->with('status_error', 'OPS! Algum erro no cadastro, tente novamente!');
                }

            }else{
                return redirect()->action('UsuarioController@create')->with('status_error', 'Já existe um usuário com este email!');
            }
        }else{
            return redirect()->action('UsuarioController@create')->with('status_error', 'Limite de licenças atingido! Contratadas: '.$countLicenca.'.');  
        }
    }

    public function update(Request $request){
            $countUser = count(Usuario::where('email',$request->emailalt)->get());
            $usuario = Usuario::find($request->idUser);
            $usuario->empresa = $request->empresaalt;
            $usuario->perfil_fk = $request->perfilalt;
            $usuario->nome = $request->nomealt;
            $usuario->ativo = $request->ativaalt;
            $usuario->usucad = Auth::user()->id_usuario;
            $usuario->data_alteracao = date('Y-m-d H:i:s');
            $saveStatus = $usuario->save();

                if($request->fotoalt){
                    $file = $request->fotoalt;
                    $filename= $usuario->id_usuario.'.jpg';
                    $info = getimagesize($file);
                    $destination_path = 'storage/img/users/';
        
                    if ($info['mime'] == 'image/jpeg') {
                        $image = imagecreatefromjpeg($file);
                    }elseif($info['mime'] == 'image/png'){
                        $image = imagecreatefrompng($file);
                    }
                
                    imagejpeg($image, $destination_path.$filename, 70);
                }

                if($saveStatus){            
                        return redirect()->action('UsuarioController@create')->with('status_success', 'Usuário Atualizado!');
                }else{
                        return redirect()->action('UsuarioController@create')->with('status_error', 'OPS! Algum erro na alteração, tente novamente!');
                }

       
    }

    public function resetPassword(Request $request){

       if(empty($request->idUser)){

            return redirect()->action('UsuarioController@create')->with('status_error', 'Falha!');  

       }
       
       $usuario = Usuario::find($request->idUser);
       $usuario->password = bcrypt('123');
       
        if($usuario->save()){

            return redirect()->action('UsuarioController@create')->with('status_success', 'Senha resetada!');

        }else{

            return redirect()->action('UsuarioController@create')->with('status_error', 'OPS! Tente novamente!');

        }

    }


    public function destroy(Request $request){
        if(empty($request->iddelete)){
            return redirect()->action('UsuarioController@create')->with('status_error', 'Falha!');    
            }
            $usuario = Usuario::find($request->iddelete);
            $delete=$usuario->delete();
            if($delete){
                $arquivo = 'storage/img/users/'.$request->iddelete.'.jpg';
                if(file_exists($arquivo)){
                unlink($arquivo);
                }
            return redirect()->action('UsuarioController@create')->with('status_success', 'Usuário Excluída!');
            }else{
            return redirect()->action('UsuarioController@create')->with('status_error', 'Não foi possível excluir o usuário, possivelmente existem movimentação/cadastros!');    
            }
    }
}
