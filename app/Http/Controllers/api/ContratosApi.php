<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contrato;
use App\Models\ContratoArquivo;
use Illuminate\Support\Facades\Storage;

class ContratosApi extends Controller
{
    
    public function index()
    {
        return response()->json(Contrato::all(), 200);
    }

    public function show($id)
    {
       $contrato = Contrato::find($id);
       
       if(!$contrato)
        return response()->json(['code'=>'404','erro'=>'Nenhum contrato encontrado.'], 404);

        return response()->json($contrato, 200); 
        
    }

    public function update(Request $request, $id)
    {
       
    }

    public function destroy($path)
    {
        
    }

}
