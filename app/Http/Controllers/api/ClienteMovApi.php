<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Climov;

class ClienteMovApi extends Controller
{
    
    public function index()
    {
        return Climov::all();
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        $movCli= Climov::where('cli_cod',$id)
                       ->join('cliente', 'climov.cli_cod', '=', 'cliente.id_cliente')
                       ->join('setempresa', 'climov.emp_cod', '=', 'setempresa.id_empresa')
                       ->select('cliente.limite_cred as limitecred','cliente.venc_limite_cred as venclimitecred',
                       'cliente.razao_social as cliente',
                       'climov.*','setempresa.razao_social as empresa')
                       ->orderBy('data_mov', 'DESC')
                       ->get();
        
        if(!$movCli)
            return response()->json(['code'=>'404','erro'=>'Nenhum cliente com esse ID.'], 404);
            
        return $movCli; 
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
