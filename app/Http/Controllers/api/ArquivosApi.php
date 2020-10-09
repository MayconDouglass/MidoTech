<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contrato;
use App\Models\ContratoArquivo;
use Illuminate\Support\Facades\Storage;

class ArquivosApi extends Controller
{
    
    public function index()
    {
     
    }

    public function show($id)
    {
       
    }

    public function update(Request $request, $id)
    {
       
    }

    public function destroy($path)
    {
        $contrato = ContratoArquivo::where('path',$path)->first();

        if(!$contrato)
            return response()->json(['code'=>'404','erro'=>'Nenhum arquivo encontrado.'], 404);

        $statusDel = $contrato->delete();
        if($statusDel){
            Storage::delete([$path]);
            return response()->json(['code'=>'200','status'=>'Item excluido.'], 200);
        }else{
            return response()->json(['code'=>'404','erro'=>'Nenhum arquivo excluido.'], 404); 
        }
    }

}
