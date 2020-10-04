<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Perfil;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\PerfilAcesso;
use App\Models\Vendedor;
use Auth;
use Hash;

class LoginController extends Controller
{
    public function form()
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

            $roleView = PerfilAcesso::where('perfil_cod',Auth::user()->perfil_fk)
                                    ->where('role',1)
                                    ->pluck('ativo');
            $roleAdmin = PerfilAcesso::where('perfil_cod',Auth::user()->perfil_fk)
                                    ->where('role',5)
                                    ->pluck('ativo');

            $acessoPerfil = PerfilAcesso::where('perfil_cod',Auth::user()->perfil_fk)
            ->select('role','ativo')->get();
            
            if($roleAdmin[0] == 1){

                $clientes = Cliente::all()->count();
                $vendedores = Vendedor::all()->count();
                
            }else{

                $clientes = Cliente::where('emp_cod',$uempresa)->count();
                $vendedores = Vendedor::where('emp_cod',$uempresa)->count();

            }
            
            if ($roleView[0]  == 1){
                return view('painel.page.index',compact('uperfil','unomeperfil','unome','uid','uimagem','acessoPerfil','clientes','vendedores'));
            }else{
                return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','perfis','acessoPerfil'));
            }  

            
       
        }else{

            return view('login');

        }
    }

    public function Login(Request $request)
    {
        //dd(bcrypt($request->password));
        $request->validate([
            'email' => 'required',
            'senha' => 'required'
        ]);


        $lembrar = empty($request->remember) ? false : true;

        $usuario = User::where('email', $request->email)
                       ->where('ativo',1)
                       ->with(['perfil','setempresa'])
                       ->first();
       
        $statusUser = User::where('email', $request->email)->first();
        //dd($statusUser->ativo);
        //dd(bcrypt($request->senha));
            
        if(!$usuario->setempresa->ativo){
            return redirect()->action('LoginController@form')->with('status_login_error', 'Empresa Inativa! Contate o Setor financeiro.');
        }
        if(!$usuario->perfil->ativo){
            return redirect()->action('LoginController@form')->with('status_login_error', 'Perfil do usuário Inativo!');
        }

        if ($usuario && Hash::check($request->senha, $usuario->password)) {
           
            Auth::loginUsingId($usuario->id_usuario, $lembrar);
        }
            
       

        if($statusUser->ativo==0){
            return redirect()->action('LoginController@form')->with('status_login_error', 'Usuário Inativo!');
        }else{
            return redirect()->action('LoginController@form')->with('status_login_error', 'Por favor, verifique os dados!');
        }
          
    }


}
