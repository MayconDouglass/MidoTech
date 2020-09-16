<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VwClientesFull;
use App\Models\Cliente;
use App\Models\Clilogradouro;

class ClientesApi extends Controller
{
    
    public function index()
    {
      return VwClientesFull::all();
    }

    public function show($id)
    {
        $cliente = VwClientesFull::where('id_cliente',$id)->first();
        if(!$cliente)
            return response()->json(['code'=>'404','erro'=>'Nenhum cliente com esse ID.'], 404);
            
        return $cliente;    
            
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);
        if(!$cliente)
            return response()->json(['code'=>'404','erro'=>'Nenhum cliente com esse ID.'], 404);

        $cliente->update($request->all());

        $logradouro = Clilogradouro::where('cli_cod',$id)->first();
        $logradouro->update($request->all());        
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
    }

}
