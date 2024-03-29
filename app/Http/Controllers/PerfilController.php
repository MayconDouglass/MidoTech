<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\PerfilAcesso;
use Illuminate\Http\Request;
use App\Models\Setempresa;
use App\Models\Role;

use Auth;
class PerfilController extends Controller
{
    public function create()
    {
        if (Auth::user()){
            
            $uid= Auth::user()->id_usuario;
            $unome= Auth::user()->nome;
            $uperfil= Auth::user()->perfil_fk;
            $unomeperfil= Auth::user()->perfil->nome;
            $uempresa= Auth::user()->empresa;

            $statusPerfil= Perfil::find($uperfil);
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
                                    
            $acessoPerfil = PerfilAcesso::where('perfil_cod',$uperfil)
                                        ->select('role','ativo')->get();

            $perfis = Perfil::where('emp_cod',$uempresa)->get();
           
            $empresas = Setempresa::all();
            
            $roles = PerfilAcesso::where('perfil_cod',Auth::user()->perfil_fk)
            ->pluck('ativo');

            if (($roleView[0] == 1) && ($roles[6] == 1)){
                    return view('painel.page.perfil',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','perfis','acessoPerfil','uempresa'));
                }else{
                    return view('painel.page.nopermission',compact('uperfil','unomeperfil','unome','uid','uimagem','empresas','perfis','acessoPerfil'));
                }  

        }else{

            return view('login');

        }
    }


    public function store(Request $request)
    {
        $uempresa = Auth::user()->empresa;
        $sizeRole = Role::all()->max('id_role');
        $countPerfil = count(Perfil::where('nome',$request->nomecad)->where('emp_cod',$request->empcad)->get());
        if($countPerfil < 1)
        {
            
            $perfil = new Perfil();
            $perfil->emp_cod = $uempresa;
            $perfil->nome = $request->nomecad;
            $perfil->ativo = $request->statuscad;
            $perfil->datacad = date('Y-m-d H:i:s');
            $perfil->usucad = Auth::user()->id_usuario;
            $saveStatus = $perfil->save();

            if($saveStatus){       
                foreach (range(1,$sizeRole) as $teste => $role) {
                    $perfilAcesso = new PerfilAcesso();     
                    $perfilAcesso->perfil_cod = $perfil->id_perfil;
                    $perfilAcesso->usuario = Auth::user()->id_usuario;
                    $perfilAcesso->role = $role;
                    $perfilAcesso->ativo = 0;
                    $perfilAcesso->save();
                }                
                
                return redirect()->action('PerfilController@create')->with('status_success', 'Perfil Cadastrado!');
            }else{
                    return redirect()->action('PerfilController@create')->with('status_error', 'OPS! Algum erro no cadastro, tente novamente!');
            }

        }else{
            return redirect()->action('PerfilController@create')->with('status_error', 'Já existe um perfil com este nome na empresa selecionada!');
        }
    }

    public function update(Request $request)
    {

            $perfil = Perfil::find($request->idPerfil);
            $perfil->ativo = $request->statusalt;
            $perfil->dataalt = date('Y-m-d H:i:s');
            $perfil->usualt = Auth::user()->id_usuario;
            $updateStatus = $perfil->save();

            if($updateStatus){         
               return redirect()->action('PerfilController@create')->with('status_success', 'Status atualizado!');
            }else{
               return redirect()->action('PerfilController@create')->with('status_error', 'OPS! Algum erro ocorreu, tente novamente!');
            }        
    }

    public function destroy(Request $request){
        if(empty($request->iddelete)){
            return redirect()->action('PerfilController@create')->with('status_error', 'Falha!');    
            }
            $perfil = Perfil::find($request->iddelete);
            $delete=$perfil->delete();
            if($delete){   
            return redirect()->action('PerfilController@create')->with('status_success', 'Perfil Excluído!');
            }else{
            return redirect()->action('PerfilController@create')->with('status_error', 'Não foi possível excluir o perfil, possivelmente existem movimentação/cadastros!');    
            }
    }

    public function atualizarPermissao(Request $request){
        $select = 'role';
        $acesso = PerfilAcesso::where('perfil_cod','=',$request->idPerfil)->get();  
        $sizeRole = Role::all()->max('id_role');
        //dd($sizeRole);
        if(count($acesso) > 0){
            for ($i=1; $i < $sizeRole + 1; $i++) { 
                $roleExist = PerfilAcesso::where('perfil_cod','=',$request->idPerfil)
                                 ->where('role','=',$i)
                                 ->get();  
                if(count($roleExist) > 0){
                $perfilAcesso = PerfilAcesso::where('perfil_cod','=',$request->idPerfil)->where('role',$i)->first();     
                $perfilAcesso->perfil_cod = $request->idPerfil;
                $perfilAcesso->usuario = Auth::user()->id_usuario;
                $perfilAcesso->role = $i;
                $perfilAcesso->ativo = $request->input($select.$i);
                $perfilAcesso->save();
                }else{
                $perfilAcesso = new PerfilAcesso();     
                $perfilAcesso->perfil_cod = $request->idPerfil;
                $perfilAcesso->usuario = Auth::user()->id_usuario;
                $perfilAcesso->role = $i;
                $perfilAcesso->ativo = $request->input($select.$i);
                $perfilAcesso->save(); 
                }
            }
        }else{
            foreach (range(1,$sizeRole) as $size => $role) {
                $perfilAcesso = new PerfilAcesso();     
                $perfilAcesso->perfil_cod = $request->idPerfil;
                $perfilAcesso->usuario = Auth::user()->id_usuario;
                $perfilAcesso->role = $role;
                $perfilAcesso->ativo = $request->input($select.$role);
                $perfilAcesso->save();
            }             
        }              
        
        $perfil = Perfil::find($request->idPerfil);
        $perfil->usualt = Auth::user()->id_usuario;
        $perfil->dataalt = date('Y-m-d H:i:s');
        $statusAcesso = $perfil->save();
        if($statusAcesso){   
            return redirect()->action('PerfilController@create')->with('status_success', 'Permissões atualizadas!');
            }else{
            return redirect()->action('PerfilController@create')->with('status_error', 'Não foi possível atualizar as permissões deste perfil, tente novamente!');    
            }
    }

    public function obterPermissaoPerfil(Request $request){
        //dd($request);
        $permissao = PerfilAcesso::where('perfil_cod',$request->id)->pluck('ativo');
        //dd($permissao[0]);
        return response()->json([$permissao],200);

    }
}
